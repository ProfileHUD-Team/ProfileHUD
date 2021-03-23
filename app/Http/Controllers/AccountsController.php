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
            'platform_username' => 'required'
        ]);
        $unique_key = $data['platform']."-".mb_strtolower($data['platform_username']);

        auth()->user()->accounts()->create([
            'platform' => $data['platform'],
            'unique_key' => $unique_key,
            'platform_username' => $data['platform_username']
        ]);
        dd($data);

    }
}
