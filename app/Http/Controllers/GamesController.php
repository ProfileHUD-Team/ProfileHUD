<?php

namespace App\Http\Controllers;

use App\GameAPIs\SteamAPIConnector;
use App\GameAPIs\XboxAPIConnector;
use \Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function PHPUnit\Framework\isNull;
use \App\Models\Game as Game;

/**
 * Class GamesController: This controller is responsible for getting information for a user's games and populatiting the DB.
 * @author Gregory Dwyer
 * Updated : 4/29/21
 * @package App\Http\Controllers
 */
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

    /**
     * Controller constructor, initializes api connectors.
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->steamconnector = new SteamAPIConnector(Config::get('steam-auth.api_key'));
        $this->xboxconnector = new XboxAPIConnector(Config::get('xbox-auth.api_key'));
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
        $allGames = \App\Models\Game::query()->where('platform', $data['platform'])->pluck('id','game_id')->toArray() ?? [];
        if($data['platform']=='stm'){
            $playtimes = $this->steamconnector->getPlaytimeAll($data['platform_id']);
        }
        $account = auth()->user()->accounts()->find($data['account_id']);
        foreach($games as $game){
            $unique_key = $data['platform']."-".$game;

            if(array_key_exists($game, $allGames)){
                //Game already in database, skip
                $dbgame = $allGames[$game];
                if(Game::find($dbgame)->name == "NULL" or Game::find($dbgame)->cover_image == "/svg/default_image.png") {
                    $this->updateGame($game, $dbgame, $data['platform']);
                }
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
                    $dbgame = \App\Models\Game::create([
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
                   //dd($game,$e->getMessage());
                }
                if($data['platform']=='stm') {
                    usleep(200);
                }
            }
            if (null === $account->plays()->find($dbgame)){
                $account->plays()->attach($dbgame);
            }
            if(isset($playtimes)) {
                $account->plays()->updateExistingPivot($dbgame, ['hours_played' => $playtimes[array_search($game,array_column($playtimes,'id'))]['playtime']]);
            }
         }


        return redirect()->route('ach.create',[ $data['platform'],$data['account_id']]);
    }

    /**
     * Checks for non-null game info on Null entry
     * @var string game
     * @var int dbgame
     * z@var string platform
     */
    private function updateGame($game, $dbgame, $platform){
        if($platform=='stm'){
            $info = $this->steamconnector->getGameInfo($game)->toDataArray();
        }elseif($platform=='xbl'){
            $info = $this->xboxconnector->getGameInfo($game)->toDataArray();
        }
        else{
            $info = [];
        }
        Game::find($dbgame)->update(
            ['name' => $info['name'],
            'developer' => $info['developer'],
            'publisher' => $info['publisher'],
            'release_date' => $info['release_date'],
            'cover_image'=> $info['cover_image']]);
    }
}
