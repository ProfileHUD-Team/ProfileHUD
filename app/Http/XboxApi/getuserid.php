<?php

namespace App\Http\XboxApi;



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

            'X-Auth' => '844c90481c37b3bbbdd6a2ebab654ac9cb14d377'


        ])->get('https://xapi.us/v2/xuid/' . $gamertag);


        return view('getachievements', ['user' => $url]);
    }


}
