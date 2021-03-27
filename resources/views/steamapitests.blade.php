<?php
    // PHP Code for the tests
    use App\GameAPIs\SteamAPIConnector;
    use Illuminate\Support\Facades\Config;
    $steamApiKey = Config::get('steam-auth.api_key');
    $connector = new SteamAPIConnector($steamApiKey);
    $steamID = session('steamData')['steamID'];
    // Get SteamUser Test:
    $steamUser = $connector->getSteamUser($steamID);
    // Load game information using hardcoded ids
    $gameObject1 = $connector->getGameInfo('620');
    $gameStr1 = $gameObject1->toString();
    $gameObject2 = $connector->getGameInfo('638970');
    $gameStr2 = $gameObject2->toString();
    // Get owned games for user with id 76561198962880722
    $gameList = $connector->getGamesOwned($steamID);
    // Load the achievements for the user and their first game
    $firstGameID = $gameList->getGame(0)->getGame()->getId();
    $achievementList = $connector->getAchievements($steamID, $firstGameID);
    $achievementsStr = $achievementList->toString();
    // Get any errors
    $errorsStr = $connector->getErrorsString();
?>

@extends('layouts.app');

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
        <h2>Get Achievement List test:</h2>
        <p><?php echo $achievementsStr; ?></p>
        <h3>Steam Web API requests made:</h3>
        <p><?php echo $connector->getRequestsMade(); ?></p>
        <h3>Errors Log:</h3>
        <p><?php echo $errorsStr; ?></p>
    </div>
@endsection
