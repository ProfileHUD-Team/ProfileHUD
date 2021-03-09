@extends('layouts.app');
<html>
<head>

</head>
<body>

</body>
</html>
<?php
    // PHP Code for the tests
    use App\GameAPIs\SteamAPIConnector;
    $connector = new SteamAPIConnector('A9D4A0CEAA3CEE6706C8B5D18589EA8D');
    $jsonObject = $connector->performRequest('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=A9D4A0CEAA3CEE6706C8B5D18589EA8D&steamids=76561198962880722');
    $response = $jsonObject['response'];
    $players = $response['players'];
    $innerJson = $players[0];
    $personaname = $innerJson['personaname'];
    $steamId = $innerJson['steamid'];
?>
@section('content')
    <div class="container">
        <h1>Steam API Tests:</h1>
        <p><?php var_dump($jsonObject);?></p>
        <p><?php echo 'Username: ' . $personaname; ?></p>
        <p><?php echo 'Steam ID: ' . $steamId; ?></p>
    </div>
@endsection
