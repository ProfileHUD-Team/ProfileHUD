<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * GamePageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display()
    {
        $data = ['hasXbl' => 'hidden', 'hasStm' => 'hidden'];
        $stmAcc = auth()->user()->accounts()->firstwhere('platform','stm');
        $xblAcc = auth()->user()->accounts()->firstwhere('platform','xbl');

        if(null !== $stmAcc){
            $data['hasStm'] = '';
        }
        if(null !== $xblAcc){
            $data['hasXbl'] = '';
        }

        return view('settings', $data);
    }

    /**
     * Removes account from the authorized user.
     */
    public function removeAccount()
    {
        $data= request()->validate(['platform' => 'required']);
        auth()->user()->accounts()->firstwhere('platform',$data['platform'])->delete();
        return redirect(route('settings'));
    }

    /**
     * Deletes the authorized user.
     */
    public function deleteUser()
    {
        auth()->user()->delete();
        return view('welcome');
    }

}
