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
    $connector = new SteamAPIConnector('A9D4xxxxxxxxxx');
    // GetPlayerSummaries Test:
    $jsonObject = $connector->performRequest('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=A9D4xxxxxxxxxx&steamids=76561198962880722');
    $response = $jsonObject['response'];
    $playersString = 'players';
    $players = $response[$playersString];
    $innerJson = $players[0];
    $personaname = $innerJson['personaname'];
    $steamId = $innerJson['steamid'];
    // Load game information using id 620
    $gameObject1 = $connector->getGameInfo('620');
    $gameStr1 = $gameObject1->toString();
    $gameObject2 = $connector->getGameInfo('638970');
    $gameStr2 = $gameObject2->toString();
?>
@section('content')
    <div class="container">
        <h1>Steam API Tests:</h1>
        <h2>GetPlayerSummaries Test:</h2>
        <p><?php var_dump($jsonObject);?></p>
        <p><?php echo 'Username: ' . $personaname; ?></p>
        <p><?php echo 'Steam ID: ' . $steamId; ?></p>
        <h2>Load game information test:</h2>
        <p><?php echo $gameStr1; ?></p>
        <p><?php echo $gameStr2; ?></p>
    </div>
@endsection
