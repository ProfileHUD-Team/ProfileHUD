<?php

namespace App\Http\Controllers;

use App\GameAPIs\SteamAPIConnector;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GamesController extends Controller
{
    /**
     * SteamAPIConnector.
     * @var SteamAPIConnector
     */
    protected $steamconnector;

    public function __construct()
    {
        $this->steamconnector = new SteamAPIConnector(\Illuminate\Support\Facades\Config::get('steam-auth.api_key'));
    }

    /**
     * gets user info to pass to view
     * @var string platform name
     * @var string database id
     */
    public function create($platform, $id)
    {
        if($platform == 'stm'){
            $games = $this->steamconnector->getGamesOwnedSimple(auth()->user()->accounts()->find($id)->platform_id);
        }
        elseif ($platform == 'xbl'){
            //get games from bxl api
            $games = NULL;
        }
        else{
            $games = NULL;
        }
        return view('games.create', ['platform'=>$platform,'id'=>$id, 'games'=>$games]);
    }

    public function store()
    {

        $data = request()->validate(['games' => '', 'platform'=>'', 'id'=>'']);
        $games = unserialize($data['games']);
        $allGames = \App\Models\Game::query()->where('platform', $data['platform'])->pluck('game_id')->toArray();
        foreach($games as $game){
            if(in_array($game, $allGames)){
                //Game already in database, connect to account
                if (!auth()->user()->accounts()->find($data['id'])->plays()->where(\App\Models\Game::where('game_key',$data['platform']."-".$game)->exists())){
                    auth()->user()->accounts()->find($data['id'])->plays()->attach(\App\Models\Game::where('game_key',$data['platform']."-".$game)->get());
                }
            }
            else {
                try {
                    $info = $this->steamconnector->getGameInfoArray($game);
                    $unique_key = $data['platform']."-".$game;

                    \App\Models\Game::create([
                        'platform' => $data['platform'],
                        'game_key' => $unique_key,
                        'game_id' => $game,
                        'name' => $info['name'],
                        'developer' => $info['developer'],
                        'publisher' => $info['publisher'],
                        'release_date' => $info['release_date']
                    ]);
                    auth()->user()->accounts()->find($data['id'])->plays()->attach(\App\Models\Game::where('game_key',$data['platform']."-".$game)->get());


                } catch (\Exception $e) {
                   // dd($game,$e->getMessage());
                }
                usleep(200);
            }

         }



    }
}
