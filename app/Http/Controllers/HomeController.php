<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        #$games = auth()->user()->accounts()->firstwhere('platform','xbl')->games->toArray();

        #$data = ['games' => $games];

        return view('home');
    }
}
