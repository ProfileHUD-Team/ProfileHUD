<?php

namespace App\XboxApi;


use Illuminate\Support\Facades\Http;

class xboxProfile
{
    /**
     * @return
     */

    public function xboxProfile()
    {
        $id = $_GET['profile'];
        $xboxReq = Http::withHeaders([
            'X-Authorization' => 'k8gocokcgss00cwsk4gkk8084808sswsows'


        ])->get('https://xbl.io/api/v2/player/summary/' . $id);


        if (!empty($xboxReq['people'])) {


            return view('xboxProfile', ['response' => $xboxReq['people']]);

        } else {

            echo '<h2>No Profile available<h2>';

        }

    }


}
