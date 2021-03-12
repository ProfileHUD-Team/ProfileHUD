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
    $connector = new SteamAPIConnector('A9D4xxxxxxxxxxxxxxxxxxxxxxxxxx');
    $steamId = '76561198962880722';
    // Get SteamUser Test:
    $steamUser = $connector->getSteamUser($steamId);
    // Load game information using ids
    $gameObject1 = $connector->getGameInfo('620');
    $gameStr1 = $gameObject1->toString();
    $gameObject2 = $connector->getGameInfo('638970');
    $gameStr2 = $gameObject2->toString();
    // Get owned games for user with id 76561198962880722
    $gameList = $connector->getGamesOwned($steamId);
?>
@section('content')
    <div class="container">
        <h1>Steam API Tests:</h1>
        <h2>Get Steam User Test:</h2>
        <p><?php echo $steamUser->toString(); ?></p>
        <h2>Load game information test:</h2>
        <p><?php echo $gameStr1; ?></p>
        <p><?php echo $gameStr2; ?></p>
        <h2>Get owned games test:</h2>
        <p><?php echo $gameList->toString(); ?></p>
    </div>
@endsection
