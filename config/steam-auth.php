<?php

return [

    /*
     * Redirect URL after login
     */
    'redirect_url' => 'http://127.0.0.1:8000/steamlinked',

    /*
     * Realm override. Bypass domain ban by Valve.
     * Use alternative domain with redirection to main for authentication (banned by valve).
     */
    //'realm' => 'redirected.com',

    /*
     * API Key (set in .env file) [http://steamcommunity.com/dev/apikey]
     */
    'api_key' => env('STEAM_API_KEY', ''),

    /*
     * Is using https ?
     */
    'https' => false,
];