<?php

namespace App\XboxApi;



use Illuminate\Support\Facades\Http;

class getuserid
{
    /**
     * @return
     */
    public function getData()
    {


        $gamertag = $_GET['userid'];

        $url = Http::withHeaders([

            'X-Auth' => '9ae5db1e3b8c6b049fe393f7a89c11014a4c78d4'//'844c90481c37b3bbbdd6a2ebab654ac9cb14d377'


        ])->get('https://xapi.us/v2/xuid/' . $gamertag);

        return view('getXboxProfile', ['user' => $url]);
    }


}
