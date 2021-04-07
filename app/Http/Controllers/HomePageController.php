<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;


/**
 * Class SteamPagesController: Controller class for hompage
 * Date Created: 4/04/2021
 * @author Willie Holmes
 *
 */

class HomePageController extends Controller
{
    public function index($Account, $user, $plays, $achieves)
    {
        $Account = Account::findOrFail($Account);
        $user = user::find($user);
        $plays = plays::find($plays);
        $achieves = achieves::find ($achieves);
        auth()->user()

        return view('home', [
            'Account'=> $Account,
            'user'=> $user,
            'plays'=> $plays,
            'achieves'=> $achieves

        ]);
    }
}
