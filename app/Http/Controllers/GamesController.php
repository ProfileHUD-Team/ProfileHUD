<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'platform' => 'required',
            'game_id' => 'required',
            'name' => '',
            'developer' => '',
            'publisher' => '',
            'release_date' => ''
        ]);
        $unique_key = $data['platform']."-".mb_strtolower($data['game_id']);

        auth()->user()->accounts()->create([
            'platform' => $data['platform'],
            'game_key' => $unique_key,
            'game_id' => $data['game_id'],
            'name' => $data['name'],
            'developer' => $data['developer'],
            'publisher' => $data['publisher'],
            'release_date' => $data['release_date'],
        ]);

    }
}
