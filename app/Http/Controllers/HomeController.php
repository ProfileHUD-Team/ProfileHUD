<?php

namespace App\Http\Controllers;

use app\Http\Request;
use App\GameAPIs\SteamAPIConnector;
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
        $xbl = auth()->user()->accounts()->firstwhere('platform','xbl');
        $stm = auth()->user()->accounts()->firstwhere('platform','stm');

        if( null === $stm){
            $stm = [];
        }else{
            $stm = $stm->plays->toArray();

        }

        if( null === $xbl){
            $xbl = [];
        }else{
            $xbl = $xbl->plays->toArray();
        }

        $data = ['stm' => $stm, 'xbl' => $xbl];
        return view('home', $data);
    }

    private function sortByGameName($a, $b){
        return $a['name'] <=> $b['name'];
    }

}
