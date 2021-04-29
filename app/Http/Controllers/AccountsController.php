<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GameAPIs\XboxAPIConnector;
use Illuminate\Support\Facades\Config;

/**
 * Class AccountsController: This controller is responsible for
 * @author Fernando Villarreal, Gregory Dwyer
 * Date Created: 4/6/2021
 * @package App\Http\Controllers
 */
class AccountsController extends Controller
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
     * Routes call for xbox profile, gets profile and routes to Games Controller
     */
    public function getProfile()
    {   $data = request()->validate([
        'platform' => 'required',
        'platform_username' => 'required']);

        if($data['platform'] == 'xbl') {
            $xboxController = new XboxAPIConnector(Config::get('xbox-auth.api_key'));
            $xboxData = $xboxController->getXboxUser($data['platform_username']);
            return view('accounts/xboxlinked', $xboxData);
        }
        else{
            return redirect()->route('home');
        }
    }

    /**
     * Generates data package for account creation page, routes to page.
     * add and update variables will show and hide buttons as necessary on the view.
     */
    public function create()
    {
        $data = ['addxbl' => '', 'addstm' => '',
            'updatexbl' => 'hidden', 'updatestm' => 'hidden',
            'stmAcc' => '', 'xblAcc' =>''];
        $stmAcc = auth()->user()->accounts()->firstwhere('platform','stm');
        $xblAcc = auth()->user()->accounts()->firstwhere('platform','xbl');

        if(null !== $stmAcc){
            $data['addstm'] = 'hidden';
            $data['updatestm'] = '';
            $data['stmAcc'] = $stmAcc->id;
        }
        if(null !== $xblAcc){
            $data['addxbl'] = 'hidden';
            $data['updatexbl'] = '';
            $data['xblAcc'] = $xblAcc->id;
        }

        return view('accounts.create', $data);
    }

    /**
     * Stores an account in the database.
     */
    public function store()
    {
        $data = request()->validate([
            'platform' => 'required',
            'platform_username' => 'required',
            'platform_id' => '',
            'profile_image' => ''
        ]);
        $unique_key = $data['platform']."-".mb_strtolower($data['platform_username']);

        try {
            $account = auth()->user()->accounts()->create([
                'platform' => $data['platform'],
                'account_key' => $unique_key,
                'platform_username' => $data['platform_username'],
                'platform_id' => $data['platform_id'],
                'profile_image' => $data['profile_image']
            ]);
        }
        catch(\Illuminate\Database\QueryException $exception){
            //echo'Whoops!';
            //echo $exception->getMessage();
            //dd($data);

        }

        return redirect()->route('g.create',[ $data['platform'], $account]);
    }

    /**
     * Routes update call for an account to the Games Controller.
     */
    public function update(){
        $data = request()->validate([
            'platform' => 'required',
            'id' => 'required',
        ]);

        return redirect()->route('g.create',[ $data['platform'], $data['id']]);
    }
}
