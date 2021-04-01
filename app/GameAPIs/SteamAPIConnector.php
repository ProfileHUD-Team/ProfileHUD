<?php

namespace App\GameAPIs;

use mysql_xdevapi\Exception;

/**
 * Class SteamAPIConnector: This class can make Steam Web API requests and return parsable objects
 * defined in the GameAPIs package.
 * Date Created: 3/6/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class SteamAPIConnector implements GameAPIInterface
{

    //============================ STATIC PROPERTIES ============================

    /**
     * Null string to be used when returning empty objects.
     * @var string
     */
    public static $nullValue = 'NULL';

    //============================ CLASS PROPERTIES ============================

    /**
     * Steam Web API key to be used for making API requests with this connector.
     * @var string
     */
    private $apiKey;

    /**
     * Base URL where to make Steam API requests.
     * @var string
     */
    private $baseAPIUrl;

    /**
     * The number of requests made with this connector object so far.
     * @var int
     */
    private $requestsMade;

    /**
     * A list of any errors encountered when making requests with this connector object.
     * @var array
     */
    private $errorLog;

    //============================ CONSTRUCTOR ============================

    /**
     * SteamAPIConnector constructor.
     * @param String $apiKey : API key to be used for making requests.
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->baseAPIUrl = "http://api.steampowered.com/";
        $this->requestsMade = 0;
        $this->errorLog = array();
    }

    //============================ PUBLIC FUNCTIONS ============================

    /**
     * @inheritDoc
     */
    public function getGameInfo($gameId): GameObject
    {
        // Create the URL.
        $url = "https://store.steampowered.com/api/appdetails?appids=" . $gameId;
        // Make the request to get a JSON object.
        $jsonObject = $this->performRequest($url);
        // Check if the JSON object has errors. Return an empty object if so.
        if ($this->hasErrors($jsonObject)) {
            $nil = SteamAPIConnector::$nullValue;
            return new GameObject($nil, $nil, $nil, $nil, $nil);
        }
        // Check if the request was successful. Return an empty GameObject if not.
        $success = $jsonObject[$gameId]['success'];
        if ($success == false) {
            return new GameObject(self::$nullValue, self::$nullValue, self::$nullValue, self::$nullValue, self::$nullValue);
        }
        // Parse the JSON object.
        $data = $jsonObject[$gameId]['data'];
        $name = $data['name'];
        $developer = $data['developers'][0];
        $publisher = $data['publishers'][0];
        $releaseDate = $data['release_date']['date'];
        $releaseDate = $this->changeDateFormat($releaseDate);
        // Create and return the GameObject.
        return new GameObject($gameId, $name, $developer, $publisher, $releaseDate);
    }

    /**
     * Get the SteamUser object that corresponds to the provided Steam user ID.
     * @param $userId : The Steam ID of the user.
     * @return SteamUser : The SteamUser object.
     */
    public function getSteamUser($userId) : SteamUser
    {
        // Create the URL.
        $url = $this->baseAPIUrl . 'ISteamUser/GetPlayerSummaries/v0002/';
        $parameters = '?key=' . $this->apiKey . '&steamids=' . $userId;
        $url = $url . $parameters;
        // Make the request to get a JSON object.
        $jsonObject = $this->performRequest($url);
        // Check if the JSON object has errors. Return an empty object if so.
        if ($this->hasErrors($jsonObject)) {
            return new SteamUser(SteamAPIConnector::$nullValue, SteamAPIConnector::$nullValue, array());
        }
        // Check if the list of players is empty. Return an empty object if so.
        $players = $jsonObject['response']['players'];
        if (count($players) == 0) {
            $this->errorLog['getSteamUser(' . $userId . ')'] = 'The Steam user ID is invalid.';
            return new SteamUser(SteamAPIConnector::$nullValue, SteamAPIConnector::$nullValue, array());
        }
        // Parse the JSON object.
        $player = $players[0];
        $username = $player['personaname'];
        // Load the simple array of games owned.
        $gamesArray = $this->getGamesOwnedSimple($userId);
        // Create and return the SteamUser object.
        return new SteamUser($userId, $username, $gamesArray);
    }

    /**
     * @inheritDoc
     */
    public function getGamesOwned($userId) : GameList
    {
        // Get the arrays of game IDs and playtimes.
        $gameIds = $this->getGamesOwnedSimple($userId);
        $playtimes = $this->getGameIdsOrPlaytimes($userId, 'playtime_forever');
        // Load game information for each game ID.
        $gameListObject = new GameList();
        $index = 0;
        foreach ($gameIds as $gameId) {
            $game = $this->getGameInfo($gameId);
            // If the game object is empty, create an empty user-game object.
            if ($game->getId() == self::$nullValue) {
                $this->errorLog['getGameInfo(' . $gameId . ')'] = 'The Steam game ID is invalid or
                    belongs to a delisted game.';
                $userGame = new UserGameObject($game, self::$nullValue, -1, -1, -1);
                $gameListObject->addGame($userGame);
            }
            // Else, load the rest of the information.
            else {
                $hoursPlayed = $playtimes[$index] / 60;
                $achievementsRatio = $this->getAchievementRatio($userId, $gameId);
                $earnedAchievements = $achievementsRatio[0];
                $totalAchievements = $achievementsRatio[1];
                $userGame = new UserGameObject($game, 'Steam', $hoursPlayed, $earnedAchievements, $totalAchievements);
                $gameListObject->addGame($userGame);
            }
            $index++;
        }
        // Return the GameList.
        return $gameListObject;
    }

    /**
     * Get the list of games owned by the specified user as an array of integers where each
     * integer is the ID of the game. This 'simple' method only makes one request to the Steam API
     * while the 'normal' version makes multiple requests to get more detailed information.
     * @param $userId : The Steam ID of the user.
     * @return array : Array containing the ID numbers of the games.
     */
    public function getGamesOwnedSimple($userId) : array
    {
        return $this->getGameIdsOrPlaytimes($userId, 'appid');
    }

    /**
     * @inheritDoc
     */
    public function getGameInfoForUser($userId, $gameId) : UserGameObject
    {
        // Get the information to create the user-game object.
        $game = $this->getGameInfo($gameId);
        $hoursPlayed = $this->getPlaytime($userId, $gameId);
        $achievementRatio = $this->getAchievementRatio($userId, $gameId);
        $earnedAchievements = $achievementRatio[0];
        $totalAchievements = $achievementRatio[1];
        // Create and return the UserGameObject.
        return new UserGameObject($game, 'Steam', $hoursPlayed, $earnedAchievements, $totalAchievements);
    }

    /**
     * Get the list of achievements for the specified user and game.
     * @param $userId : The Steam ID of the user.
     * @param $gameId : The Steam ID of the game.
     * @return AchievementList
     */
    public function getAchievements($userId, $gameId) : AchievementList
    {
        // Create the URL to get the user's achievements.
        $url1 = $this->baseAPIUrl . 'ISteamUserStats/GetPlayerAchievements/v0001/';
        $parameters1 = '?key=' . $this->apiKey . '&steamid=' . $userId . '&appid=' . $gameId;
        $url1 = $url1 . $parameters1;
        // Create the URL to get the game's achievements.
        $url2 = $this->baseAPIUrl . 'ISteamUserStats/GetSchemaForGame/v0002/';
        $parameters2 = '?key=' . $this->apiKey . '&appid=' . $gameId;
        $url2 = $url2 . $parameters2;
        // Make the requests to get JSON objects.
        $jsonObject1 = $this->performRequest($url1);
        $jsonObject2 = $this->performRequest($url2);
        // Check if the JSON objects have errors. Return an empty object if so.
        if ($this->hasErrors($jsonObject1) || $this->hasErrors($jsonObject2)) {
            return new AchievementList();
        }
        // Check if both requests were made successfully. If not, return an empty AchievementList.
        $success1 = $jsonObject1['playerstats']['success'];;
        if ($success1 == false || count($jsonObject2) == 0) {
            return new AchievementList();
        }
        // Get the lists of achievements in both JSON objects and use them to load the AchievementList.
        $playerAchievements = $jsonObject1['playerstats']['achievements'];
        $gameAchievements = $jsonObject2['game']['availableGameStats']['achievements'];
        return $this->loadAchievements($playerAchievements, $gameAchievements);
    }

    /**
     * Get the number of Steam API requests made with this connector object so far.
     * @return int
     */
    public function getRequestsMade() : int
    {
        return $this->requestsMade;
    }

    /**
     * Get the list of errors in the error log as a string.
     * @return string
     */
    public function getErrorsString() : string
    {
        $str = "";
        foreach ($this->errorLog as $error_key => $error_value) {
            $str = $str . "REQUEST  : " . $error_key . "<br> ERROR MESSAGE: " . $error_value
                . "<br><br>";
        }
        return $str;
    }

    //============================ PRIVATE FUNCTIONS ============================

    /**
     * Perform an HTTP request using the provided URL string. Returns an JSON object on success.
     * @param $url
     * @return array
     */
    private function performRequest($url) : array {
        try {
            // Perform the request.
            $result = fopen($url, 'r');
            $this->requestsMade++;
            // Check if the request succeeded or failed.
            if ($result == false) {
                return array();
            } else {
                $str = stream_get_contents($result);
                $jsonObject =  json_decode($str, true);
                // If jsonObject is an array, the JSON string was decoded successfully.
                if (is_array($jsonObject)) {
                    return $jsonObject;
                } else {
                    return array();
                }
            }
        } catch (\Exception $ex) {
            // Add the error to the error log.
            $this->errorLog[$url] = $ex->getMessage();
            return array();
        }

    }

    /**
     * Check if the JSON object has errors (if it is empty).
     * @param array $jsonObject
     * @return bool
     */
    private function hasErrors(array $jsonObject) : bool
    {
        // Check if the JSON object is empty. Return true if so.
        if (count($jsonObject) == 0) {
            return true;
        }
        // The JSON object has no errors. Return false.
        return false;
    }

    /**
     * Get a list of either the IDs of games owned or their playtimes in minutes.
     * @param $userId : The Steam ID of the user.
     * @param $key : Must be either: 'appid' or 'playtime_forever'.
     * @return array : Array containing either game IDs or playtimes.
     */
    private function getGameIdsOrPlaytimes($userId, $key) : array
    {
        // Create the URL.
        $url = $this->baseAPIUrl . 'IPlayerService/GetOwnedGames/v0001/';
        $parameters = '?key=' . $this->apiKey . '&steamid=' . $userId;
        $url = $url . $parameters;
        // Make the request to get a JSON object.
        $jsonObject = $this->performRequest($url);
        // Check if the JSON object has errors. Return an empty object if so.
        if ($this->hasErrors($jsonObject)) {
            return array();
        }
        // Parse the JSON object (Get the response array).
        $response = $jsonObject['response'];
        // Check if the response array is empty. If it is, return an empty array.
        if (count($response) == 0) {
            return array();
        }
        // Parse the JSON object (Get each game ID or playtime).
        $gamesData = $response['games'];
        $gamesArray = array();
        foreach ($gamesData as $gameDatum) {
            $gamesArray[] = $gameDatum[$key];
        }
        // Return the array
        return $gamesArray;
    }

    /**
     * Get the number of earned and total achievements.
     * @param $userId : The Steam ID of the user.
     * @param $gameId : The Steam ID of the game.
     * @return array : An array of size two containing the number of earned and total achievements.
     */
    private function getAchievementRatio($userId, $gameId) : array
    {
        // Create the URL.
        $url = $this->baseAPIUrl . 'ISteamUserStats/GetPlayerAchievements/v0001/';
        $parameters1 = '?key=' . $this->apiKey . '&steamid=' . $userId . '&appid=' . $gameId;
        $url = $url . $parameters1;
        // Make the request to get a JSON object.
        $jsonObject = $this->performRequest($url);
        // Check if the JSON object has errors. Return an empty object if so.
        if ($this->hasErrors($jsonObject)) {
            return array(-1 , -1);
        }
        // Check if the provided game ID was valid. Return an empty object if not.
        $success = $jsonObject['playerstats']['success'];
        if ($success == false) {
            $this->errorLog['getAchievementRatio(' . $userId . ', ' . $gameId . ')'] =
                'The Steam game ID is invalid or the user has not played this game.';
            return array(-1, -1);
        }
        // Get the JSON array of achievements.
        $achievements = $jsonObject['playerstats']['achievements'] ?? [];
        $total = count($achievements);
        // Iterate over the array to count the number of earned achievements.
        $earned = 0;
        foreach ($achievements as $achievement) {
            $achieved = $achievement['achieved'];
            if ($achieved == 1) {
                $earned++;
            }
        }
        // Return the number of earned and total achievements in an array of size two.
        return array($earned, $total);
    }

    /**
     * Get the number of hours played for the specified user and game.
     * @param $userId : The Steam ID of the user.
     * @param $gameId : The Steam ID of the game.
     * @return int : The number of hours played.
     */
    private function getPlaytime($userId, $gameId) : int
    {
        // Create the URL.
        $url = $this->baseAPIUrl . 'IPlayerService/GetOwnedGames/v0001/';
        $parameters = '?key=' . $this->apiKey . '&steamid=' . $userId;
        $url = $url . $parameters;
        // Make the request to get a JSON object.
        $jsonObject = $this->performRequest($url);
        // Check if the JSON object has errors. Return -1 if so.
        if ($this->hasErrors($jsonObject)) {
            return -1;
        }
        // Parse the JSON object to get the playtime.
        $gamesData = $jsonObject['response']['games'];
        // Find the corresponding game ID to get the correct playtime.
        foreach ($gamesData as $gamesDatum) {
            $curGameId = $gamesDatum['appid'];
            if ($curGameId == $gameId) {
                return $gamesDatum['playtime_forever'] / 60;
            }
        }
        // The corresponding game ID was not found. Return -1.
        return -1;
    }

    /**
     * Load the list of achievements given the JSON arrays of the user's and the game's achievements.
     * @param $playerAchievements : A JSON array of the user's achievements.
     * @param $gameAchievements : A JSON array of the game's achievements.
     * @return AchievementList : The list of achievements.
     */
    private function loadAchievements($playerAchievements, $gameAchievements) : AchievementList
    {
        // Iterate over the lists of achievements and create Achievement objects.
        $achievementList = new AchievementList();
        $lastIndex = count($playerAchievements) - 1;
        for ($i = 0; $i <= $lastIndex; $i++) {
            // Get the player and game achievements.
            $playerAchievement = $playerAchievements[$i];
            $gameAchievement = $gameAchievements[$i];
            // Get each attribute to construct an Achievement object.
            $name = $gameAchievement['displayName'];
            $description = $gameAchievement['description'];
            $earned = $this->getBooleanValue($playerAchievement['achieved']);
            $dateEarned = $playerAchievement['unlocktime'];
            $dateEarned = $this->convertUnixEpochTimeToDate($dateEarned);
            $achievement = new Achievement($name, $description, $earned, $dateEarned);
            // Add the Achievement object to the AchievementList object.
            $achievementList->addAchievement($achievement);
        }
        // Return the AchievementList object.
        return $achievementList;
    }

    /**
     * Convert 1s to true and 0s to false.
     * @param $x : A 1 or 0 integer.
     * @return bool
     */
    private function getBooleanValue($x) : bool
    {
        if ($x == 1) {
            return true;
        }
        return false;
    }

    /**
     * Convert the format of the provided date string into MM/DD/YYYY.
     * @param $dateString
     * @return false|string
     */
    private function changeDateFormat($dateString)
    {
        $date = date_create($dateString);
        if(is_bool($date)) {
            $date = gmdate('r', 0);
        }
        return date_format($date,"m/d/Y");
    }

    /**
     * Convert the given Unix Epoch time into a human-readable date string.
     * @param $time
     * @return false|string
     */
    private function convertUnixEpochTimeToDate($time)
    {
        // Check if the time is zero. Return a zero if so.
        if ($time == 0) {
            return 0;
        }
        // Convert the time into a readable date and return it.
        $date = gmdate('r', $time);
        return $this->changeDateFormat($date);
    }
}
