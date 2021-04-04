<?php

namespace App\XboxApi;

use Illuminate\Support\Facades\Http;

class records
{
    public function record()
    {
        $gameid = $_GET['records'];
        $xboxReq = Http::withHeaders([
            'X-Authorization' => 'k8gocokcgss00cwsk4gkk8084808sswsows'


        ])->get('https://xbl.io/api/v2/achievements/' . $gameid);


        if (!empty($xboxReq['titles'])) {


            return view('xboxrecords', ['response' => $xboxReq['titles']]);

        } else {

            echo '<h2>No records available<h2>';

        }

    }
}
