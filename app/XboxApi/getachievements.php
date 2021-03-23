<?php

namespace App\XboxApi;



use Illuminate\Support\Facades\Http;

class getachievements
{
    /**
     * @return
     */

    public function achievements()
    {
        $userid = $_GET['achievements'];
        $xboxReq = Http::withHeaders([
            'X-Authorization' => 'k8gocokcgss00cwsk4gkk8084808sswsows'


        ])->get('https://xbl.io/api/v2/achievements/player/' . $userid);


        if (!empty($xboxReq['titles'])) {


            return view('achievementresults', ['response' => $xboxReq['titles']]);

        } else {

            echo '<h2>No achievements available<h2>';

        }

    }
}
