<?php

namespace App\Http\Controllers;

use app\Http\Request;
use App\GameAPIs\SteamAPIConnector;
use App\Models\Account;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\SteamPagesController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $xblAcc = auth()->user()->accounts()->firstwhere('platform','xbl');
        $stmAcc = auth()->user()->accounts()->firstwhere('platform','stm');

        if( null === $stmAcc){
            $stmGames = [];
            $stmCounts = ['total'=>'0 / 0'];
        }else{
            $stmCounts = $this->countAchievements($stmAcc);
            $stmGames = $stmAcc->plays()->where('name','!=','NULL')->get()->toArray();
            $stmGames = $this->sortGamesArray($stmGames);

        }

        if( null === $xblAcc){
            $xblGames = [];
            $xblCounts = ['total'=>'0 / 0'];
        }else{
            $xblCounts = $this->countAchievements($xblAcc);
            $xblGames = $xblAcc->plays()->where('name','!=','NULL')->get()->toArray();
            $xblGames = $this->sortGamesArray($xblGames);
        }

        $data = ['stm' => $stmGames, 'xbl' => $xblGames, 'stmCounts' => $stmCounts, 'xblCounts'=> $xblCounts];
        return view('home', $data);
    }

    /**
     * Sort an array of games.
     * @var array
     * @return array
     */
    private function sortGamesArray($games): array
    {
        uasort($games, function ($a, $b){
            return $a['name'] <=> $b['name'];
        });
        return $games;
    }


    /**
     * Count the total number of achievements for the account.
     * @var Account
     * @return array
     */
    public function countAchievements($account) : array
    {
        $totalCount = 0;
        $earnedCount = 0;
        $games = $account->plays;
        $achievementCounts = [];
        foreach($games as $game) {
            $achievements = $account->achieves()->where('game_id', $game->id);
            $total = $achievements->count();
            $totalCount = $totalCount + $total;
            if($total == 0){
                //No achievements pass through string
                $earnedFraction = "N/A";
            }else {
                //Count earned achievements.
                $earned = $achievements->wherePivot('is_earned',true)->count();
                $earnedCount = $earnedCount + $earned;
                $earnedFraction = $earned . ' / ' . $total;
            }
            $achievementCounts[$game->id] = $earnedFraction;
        }
        $achievementCounts['total'] = $earnedCount . ' / ' . $totalCount;

        return $achievementCounts;
    }
}
