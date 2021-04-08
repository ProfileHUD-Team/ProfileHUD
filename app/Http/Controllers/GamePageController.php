<?php

namespace App\Http\Controllers;

use App\GameAPIs\SteamAPIConnector;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\SteamPagesController;

/**
 * Class GamePageController: This controller is responsible for getting information for a
 * specific game and user and rendering it on a view page.
 * @author Fernando Villarreal
 * Date Created: 4/6/2021
 * @package App\Http\Controllers
 */
class GamePageController extends Controller
{

    /**
     * GamePageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get information for the specified Steam game and return a view page with
     * this information.
     * @param string $gameID
     */
    public function viewSteamGame(string $gameID)
    {
        // Database query to get the achievements (for all the games)
        $array = auth()->user()->accounts()->firstwhere('platform','stm')->achieves->toArray();
        // TESTING: Get the game and achievements from the Steam API instead.
        $steamUser = SteamPagesController::getSteamUser();
        $steamID = $steamUser->getId();
        $connector = new SteamAPIConnector(Config::get('steam-auth.api_key'));
        $game = $connector->getGameInfo($gameID);
        $achievementList = $connector->getAchievements($steamID, $gameID)->getList();
        // Create the data array and return the view.
        $data = ['game' => $game, 'gameID' => $gameID, 'achievements' => $achievementList];
        return view('steamgamepage', $data);
    }

    /**
     * Get information for the specified game and return a view page with
     * this information.
     * @param int $id
     */
    public function viewGame(int $id)
    {
        // Database query to get the game and achievements
        $game = \App\Models\Game::find($id);
        $hoursPlayed = auth()->user()->accounts()->firstwhere('platform',$game->platform)->plays()
            ->firstwhere('name', $game->name)->pivot->hours_played ?? "N/A";
        $achievements = auth()->user()->accounts()->firstwhere('platform',$game->platform)->achieves()->where('game_id', $id);
        $total = $achievements->count();
        if($total == 0){
            //No achievements pass through string
            $earnedFraction = "None Available";
        }else {
            //Count earned achievements.
            $earned = $achievements->wherePivot('is_earned',true)->count();

            $earnedFraction = $earned . ' / ' . $total;
        }
        $achievements = auth()->user()->accounts()->firstwhere('platform',$game->platform)->achieves->where('game_id', $id)->toArray();
        // Create the data array and return the view.
        $data = ['game' => $game, 'achievements' => $achievements, 'earnedFraction' => $earnedFraction, 'hoursPlayed'=>$hoursPlayed];
        return view('gamepage', $data);
    }
}
