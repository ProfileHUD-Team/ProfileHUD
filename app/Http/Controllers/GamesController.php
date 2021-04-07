<?php

namespace App\Http\Controllers;

use App\GameAPIs\SteamAPIConnector;
use App\GameAPIs\XboxAPIConnector;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function PHPUnit\Framework\isNull;
use \App\Models\Game as Game;

class GamesController extends Controller
{
    /**
     * SteamAPIConnector.
     * @var SteamAPIConnector
     */
    protected $steamconnector;
    /**
     * XboxAPIConnector.
     * @var SteamAPIConnector
     */
    protected $xboxconnector;

    public function __construct()
    {
        $this->steamconnector = new SteamAPIConnector(\Illuminate\Support\Facades\Config::get('steam-auth.api_key'));
        $this->xboxconnector = new XboxAPIConnector(env('XBOX_API_KEY'));
    }

    /**
     * gets user info to pass to view
     * @var string platform name
     * @var string database id
     */
    public function create($platform, $id)
    {
        $account = auth()->user()->accounts()->find($id)->platform_id;
        if($platform == 'stm'){
            $games = $this->steamconnector->getGamesOwnedSimple($account);
        }
        elseif ($platform == 'xbl'){
            //get games from xbl api
            $games = $this->xboxconnector->getGamesOwnedSimple($account);
        }
        else{
            $games = NULL;
        }
        return view('games.create', ['platform'=>$platform,'id'=>$id, 'games'=>$games]);
    }

    /**
     * Stores game info in DB and connects accounts to games
     */
    public function store()
    {
        ini_set('max_execution_time', 300);
        $data = request()->validate(['games' => '', 'platform'=>'', 'account_id'=>'', 'platform_id'=>'']);
        $games = unserialize($data['games']);
        $allGames = \App\Models\Game::query()->where('platform', $data['platform'])->pluck('game_id')->toArray() ?? [];
        if($data['platform']=='stm'){
            $playtimes = $this->steamconnector->getPlaytimeAll($data['platform_id']);
        }
        $account = auth()->user()->accounts()->find($data['account_id']);
        foreach($games as $game){
            $unique_key = $data['platform']."-".$game;

            if(in_array($game, $allGames)){
                //Game already in database, skip
            }
            else {
                try {
                    if($data['platform']=='stm'){
                        $info = $this->steamconnector->getGameInfo($game)->toDataArray();
                    }elseif($data['platform']=='xbl'){
                        $info = $this->xboxconnector->getGameInfo($game)->toDataArray();
                    }
                    else{
                        $info =[];
                        break;
                    }
                    \App\Models\Game::create([
                        'platform' => $data['platform'],
                        'game_key' => $unique_key,
                        'game_id' => $game,
                        'name' => $info['name'],
                        'developer' => $info['developer'],
                        'publisher' => $info['publisher'],
                        'release_date' => $info['release_date'],
                        'cover_image'=> $info['cover_image']
                    ]);

                } catch (\Exception $e) {
                    dd($game,$e->getMessage());
                }
                if($data['platform']=='stm') {
                    usleep(200);
                }
            }
            if (null === $account->plays()->firstWhere('pivot_game_id',Game::firstwhere('game_key',$unique_key)->id)){
                $account->plays()->attach(Game::where('game_key',$unique_key)->get());
            }
            if(isset($playtimes)) {
                $account->plays()->updateExistingPivot(Game::firstwhere('game_key', $unique_key)->id,
                    ['hours_played' => $playtimes[array_search($game,array_column($playtimes,'id'))]['playtime']]);
            }
         }


        return redirect()->route('ach.create',[ $data['platform'],$data['account_id']]);
    }
}
