<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @param
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
<<<<<<< Updated upstream
        return view('home');
=======


        $xblAcc = auth()->user()->accounts()->firstwhere('platform', 'xbl');
        $stmAcc = auth()->user()->accounts()->firstwhere('platform', 'stm');

        if (null === $stmAcc) {
            $stmGames = [];
            $stmCounts = ['total' => '0 / 0'];
        } else {
            $stmCounts = $this->countAchievements($stmAcc);
            $stmGames = $stmAcc->plays->toArray();
           // $stmCover = auth()->user()->accounts()->firstwhere('platform', $game->platform)->plays()
             //   ->firstwhere('name', $game->name)->firstwhere('cover', $game->cover_image);
            uasort($stmGames, function ($a, $b) {
                return $a['name'] <=> $b['name'];
            });

        }

        if (null === $xblAcc) {
            $xblGames = [];
            $xblCounts = ['total' => '0 / 0'];
        } else {
            $xblCounts = $this->countAchievements($xblAcc);
            $xblGames = $xblAcc->plays->toArray();
           // $xblCover = auth()->user()->accounts()->firstwhere('platform', $game->platform)->plays()
           //     ->firstwhere('name', $game->name)->firstwhere('cover', $game->cover_image);
            uasort($xblGames, function ($a, $b) {
                return $a['name'] <=> $b['name'];
            });
        }

        $data = ['stm' => $stmGames, 'xbl' => $xblGames, 'stmCounts' => $stmCounts, 'xblCounts' => $xblCounts];
        return view('home', $data);
    }

    private function sortByGameName($a, $b)
    {
        return $a['name'] <=> $b['name'];
    }


    public function countAchievements($account): array
    {
        $totalCount = 0;
        $earnedCount = 0;
        $games = $account->plays;
        $achievementCounts = [];
        foreach ($games as $game) {
            $achievements = $account->achieves()->where('game_id', $game->id);
            $total = $achievements->count();
            $totalCount = $totalCount + $total;
            if ($total == 0) {
                //No achievements pass through string
                $earnedFraction = "N/A";
            } else {
                //Count earned achievements.
                $earned = $achievements->wherePivot('is_earned', true)->count();
                $earnedCount = $earnedCount + $earned;
                $earnedFraction = $earned . ' / ' . $total;
            }
            $achievementCounts[$game->id] = $earnedFraction;
        }
        $achievementCounts['total'] = $earnedCount . ' / ' . $totalCount;

        return $achievementCounts;
>>>>>>> Stashed changes
    }

    public function gameCover(int $id)
    {

        $game = \App\Models\Game::find($id);

        $cover = ['game' => $game];
        return view('home', $cover);
    }
}
