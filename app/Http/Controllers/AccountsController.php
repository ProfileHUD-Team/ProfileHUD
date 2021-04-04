<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function create()
    {
        return view('accounts.create');
    }

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
            auth()->user()->accounts()->create([
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

        return redirect()->route('g.create',[ $data['platform'],\App\Models\Account::firstwhere('account_key', $unique_key)->id]);
    }
}
