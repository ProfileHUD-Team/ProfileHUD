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
            'platform_id' => ''
        ]);
        $unique_key = $data['platform']."-".mb_strtolower($data['platform_username']);

        try {
            auth()->user()->accounts()->create([
                'platform' => $data['platform'],
                'account_key' => $unique_key,
                'platform_username' => $data['platform_username'],
                'platform_id' => $data['platform_id']
            ]);
        }
        catch(\Illuminate\Database\QueryException $exception){
            echo'Whoops! Looks like that user is already in use!';
            echo $exception->getMessage();
            dd($data);

        }


    }
}
