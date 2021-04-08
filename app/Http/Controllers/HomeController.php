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
        $xbl = auth()->user()->accounts()->firstwhere('platform','xbl')->plays->toarray();
        $stm = auth()->user()->accounts()->firstwhere('platform','stm')->plays->toarray();
        $data = ['stm' => $stm, 'xbl' => $xbl];
        return view('home', $data);
    }
}
