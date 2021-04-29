<?php

namespace App\Http\Controllers;

use App\GameAPIs\SteamAPIConnector;
use App\GameAPIs\XboxAPIConnector;
use \Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use \App\Models\Game as Game;
use \App\Models\Achievement as Achievement;
use function PHPUnit\Framework\isEmpty;

/**
 * Class AchievementsController: This controller is responsible for getting an account's achievements and populating the DB.
 * @author Gregory Dwyer
 * @package App\Http\Controllers
 */
class AchievementsController extends Controller
{
    protected $steamconnector;
    protected $xboxconnector;

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->steamconnector = new SteamAPIConnector(Config::get('steam-auth.api_key'));
        $this->xboxconnector = new XboxAPIConnector(Config::get('xbox-auth.api_key'));
    }

    /**
     * Gets user info to pass to view
     * @var string platform name
     * @var string database id
     */
    public function create($platform, $id)
    {
        $games = auth()->user()->accounts()->find($id)->plays->pluck('game_id')->toArray();

        return view('achievements.create', ['platform'=>$platform,'id'=>$id, 'games'=>$games]);
    }

    /**
     * Stores achievement info in DB, connects achievements to games, and accounts to achievements
     */
    public function store()
    {
        ini_set('max_execution_time', 300);
        $data = request()->validate(['games' => '', 'platform'=>'', 'account_id'=>'']);
        $games = unserialize($data['games']);
        $account = auth()->user()->accounts()->find($data['account_id']);
        $dbAchievement = null;
        foreach($games as $game){
            $currentGame = Game::where('platform', $data['platform'])->firstwhere('game_id',$game);
                try {
                    $allAchievements = [];
                    if($currentGame->has_achievements){
                        if ($data['platform'] == 'stm') {
                            $allAchievements = $this->steamconnector->getAchievements($account->platform_id, $game)->getList() ?? [];

                        } elseif ($data['platform'] == 'xbl'){
                            $allAchievements = $this->xboxconnector->getAchievements($account->platform_id, $game)->getList() ?? [];
                        } else{
                            $info = [];
                            break;
                        }
                        //Set table value to false to avoid future api calls for this game's achievements
                        if(empty($allAchievements)){
                            $currentGame->update(['has_achievements'=> false]);
                        }
                    }
                    if($currentGame->has_achievements) {
                        foreach ((array)$allAchievements as $achievement) {
                            $achievementArray = $achievement->toDataArray();
                            $currentAchievement = Achievement::where('game_id',$currentGame->id)->firstWhere('name',$achievementArray['name']);
                            if(null === $currentAchievement) {
                                 $currentAchievement = $currentGame->achievements()->create([
                                    'name' => $achievementArray['name'],
                                    'description' => $achievementArray['description'],
                                    'image' => $achievementArray['image']]);
                            }
                            if (null === $account->achieves()->find($currentAchievement)) {
                                $account->achieves()->attach($currentAchievement,['is_earned' => $achievementArray['is_earned'], 'date_earned' => $achievementArray['date_earned']]);
                            }
                            else {
                                $account->achieves()->updateExistingPivot($currentAchievement,
                                    ['is_earned' => $achievementArray['is_earned'], 'date_earned' => $achievementArray['date_earned']]);
                            }
                        }
                    }

                } catch (\Exception $e) {
                    //dd($game,$e->getMessage());
                }
                if($data['platform']=='stm') {
                    usleep(200);
                }
            }

        return redirect()->route('home');
    }
}
