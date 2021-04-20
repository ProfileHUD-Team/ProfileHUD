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
     * A list of any errors encountered when making requests with this connector object.
     * @var array
     */
    private $errorLog;

    /**
     * Boolean value to manage whether the rate of request is limited or not. True if it is limited,
     * false if not.
     * @var bool
     */
    private $requestRateLimited;

    //============================ CONSTRUCTOR ============================

    /**
     * SteamAPIConnector constructor.
     * @param String $apiKey : API key to be used for making requests.
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->requestRateLimited = false;
        $this->baseAPIUrl = "http://api.steampowered.com/";
        $this->errorLog = array();
        // Initialize timer and number of requests for the session if necessary.
        if (is_null(session('stmRqt'))) {
            session(['stmRqt' => ['num' => 0, 'time' => 0]]);
        }
    }

    //============================ PUBLIC FUNCTIONS ============================

    /**
     * @inheritDoc
     */
    public function getGameInfo($gameId) : GameObject
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
            $gameObject = new GameObject(self::$nullValue, self::$nullValue, self::$nullValue, self::$nullValue, self::$nullValue);
            $gameObject->setCoverImage("/svg/default_image.png");
            return $gameObject;
        }
        // Parse the JSON object.
        $data = $jsonObject[$gameId]['data'];
        $name = $data['name'];
        $developer = $data['developers'][0];
        $publisher = $data['publishers'][0];
        $releaseDate = $data['release_date']['date'];
        $releaseDate = $this->changeDateFormat($releaseDate);
        $coverImage = $data['header_image'];
        if($coverImage == null) {
            echo 'this is null';
            $coverImage = "/svg/default_image.png";
        }
        // Set the cover image. Create and return the GameObject.
        $gameObject = new GameObject($gameId, $name, $developer, $publisher, $releaseDate);
        $gameObject->setCoverImage($coverImage);
        return $gameObject;

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
        $imageURL = $player['avatarfull'];
        // Load the simple array of games owned.
        $gamesArray = $this->getGamesOwnedSimple($userId);
        // Set the profile image. Create and return the SteamUser object.
        $steamUser = new SteamUser($userId, $username, $gamesArray);
        $steamUser->setProfileImage($imageURL);
        return $steamUser;
    }

    /**
     * @inheritDoc
     */
    public function getGamesOwned($userId) : GameList
    {
        $gamesData = $this->getGameIdsAndPlaytimes($userId);
        $num = count($gamesData);
        return $this->getSelectGamesOwnedPrivate($gamesData, $userId, 1, $num);
    }

    /**
     * Get the games owned by the specified user from index first to last.
     * @param $userId : The Steam ID of the user.
     * @param int $first : The index of the first game.
     * @param int $last : The index of the last game.
     * @return GameList
     */
    public function getSelectGamesOwned($userId, int $first, int $last) : GameList
    {
        $gamesData = $this->getGameIdsAndPlaytimes($userId);
        return $this->getSelectGamesOwnedPrivate($gamesData, $userId, $first, $last);
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
        $gamesData = $this->getGameIdsAndPlaytimes($userId);
        $gameIDs = array();
        foreach ($gamesData as $gamesDatum) {
            $gameIDs[] = $gamesDatum['appid'];
        }
        return $gameIDs;
    }

    /**
     * Get the number of games owned by the specified user.
     * @param $userId : The Steam ID of the user.
     * @return int : The number of games owned by the specified user.
     */
    public function getNumberOfGamesOwned($userId) : int
    {
        return count($this->getGameIdsAndPlaytimes($userId));
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
        $playerAchievements = $jsonObject1['playerstats']['achievements'] ?? [];
        $gameAchievements = $jsonObject2['game']['availableGameStats']['achievements'] ?? [];
        return $this->loadAchievements($playerAchievements, $gameAchievements);
    }

    /**
     * Get the number of Steam API requests made with this connector object so far.
     * @return int
     */
    public function getRequestsMade() : int
    {
        return session('stmRqt')['num'];
    }

    /**
     * Set the limit for the rate of requests. If enabled (true), the request rate is managed so that
     * no more than 65 requests can be made in a minute. This property is disabled (false) by default.
     * @param bool $limit
     */
    public function setRequestRateLimit(bool $limit) : void
    {
        $this->requestRateLimited = $limit;
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
            $this->checkNumberOfRequests();
            $result = fopen($url, 'r');
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
     * Get a list of tuples containing the IDs of games owned and their playtimes in minutes.
     * Game IDs will be at index 'appid' and playtimes will be at index 'playtime_forever' of each tuple.
     * @param $userId : The Steam ID of the user.
     * @return array : Array containing tuples of game IDs and playtimes.
     */
    private function getGameIdsAndPlaytimes($userId) : array
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
            $gamesArray[] = ['appid' => $gameDatum['appid'], 'playtime_forever' => $gameDatum['playtime_forever']];
        }
        // Return the array
        return $gamesArray;
    }

    /**
     * Get the games owned by the specified user over a given range of indexes. The indexes are inclusive
     * and must be valid.
     * @param array $gamesData : Array containing game IDs and playtimes.
     * @param string $userId : The Steam ID of the user.
     * @param int $first : The index of the first game in the list to return.
     * @param int $last : The index of the last game in the list to return.
     * @return GameList : The GameList object containing the games owned.
     */
    private function getSelectGamesOwnedPrivate(array $gamesData, string $userId, int $first, int $last) : GameList
    {
        // Check and then modify the range of indexes.
        $num = count($gamesData);
        if ($this->isRangeValid($first, $last, $num)) {
            $first = $first - 1;
            $last = $last - 1;
        } else {
            $first = 0;
            $last = 0;
        }
        // Load game information for each game ID.
        $gameListObject = new GameList();
        for ($i = $first; $i <= $last; $i++) {
            $gameDatum = $gamesData[$i];
            $gameID = $gameDatum['appid'];
            $playtime = $gameDatum['playtime_forever'];
            $game = $this->getGameInfo($gameID);
            // If the game object is empty, create an empty user-game object.
            if ($game->getId() == self::$nullValue) {
                $this->errorLog['getGameInfo(' . $gameID . ')'] = 'The Steam game ID is invalid or
                    belongs to a delisted game.';
                $userGame = new UserGameObject($game, self::$nullValue, -1, -1, -1);
                $gameListObject->addGame($userGame);
            }
            // Else, load the rest of the information.
            else {
                $hoursPlayed = $playtime / 60;
                $achievementsRatio = $this->getAchievementRatio($userId, $gameID);
                $earnedAchievements = $achievementsRatio[0];
                $totalAchievements = $achievementsRatio[1];
                $userGame = new UserGameObject($game, 'Steam', $hoursPlayed, $earnedAchievements, $totalAchievements);
                $gameListObject->addGame($userGame);
            }
        }
        // Return the GameList.
        return $gameListObject;
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
        // Get the list of game IDs and playtimes.
        $gamesData = $this->getGameIdsAndPlaytimes($userId);
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
     * Get the number of hours played for all of the user's games.
     * @param $userId : The Steam ID of the user.
     * @param $gameId : The Steam ID of the game.
     * @return int : The number of hours played.
     */
    public function getPlaytimeAll($userId) : array
    {
        // Get the list of game IDs and playtimes.
        $gamesData = $this->getGameIdsAndPlaytimes($userId);
        $playtimesArray = [];
        // Find the corresponding game ID to get the correct playtime.
        foreach ($gamesData as $gameDatum) {
            $playtimesArray[] = ['id' => $gameDatum['appid'], 'playtime' => (int)($gameDatum['playtime_forever']/60)];
        }

        return $playtimesArray;
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
            $description = $gameAchievement['description'] ?? 'No Description';
            $earned = $this->getBooleanValue($playerAchievement['achieved']);
            $dateEarned = $playerAchievement['unlocktime'];
            $dateEarned = $this->convertUnixEpochTimeToDate($dateEarned);
            $iconImage = $gameAchievement['icon'] ?? "/svg/default_image.png";

            // Create and add the Achievement object to the AchievementList object.
            $achievement = new Achievement($name, $description, $earned, $dateEarned);
            $achievement->setIconImage($iconImage);
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
        if(!($date instanceof \DateTimeInterface)) {
            $date = new \DateTime('0');
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

    /**
     * Manages and checks the number of Steam API requests. This method is called right before
     * making a HTTPS request to the Steam API. First, the counter for the number of
     * requests is incremented. Secondly, the request is checked to see if it is a '65th' request.
     * If it is and less than minute has elapsed since the last '65th' request, the execution of the
     * program is put to sleep for the remainder of the minute.
     */
    private function checkNumberOfRequests() : void
    {
        // Increment the number of requests. If the request rate is not limited, return.
        $numRequests = $this->getRequestsMade() + 1;
        if (!$this->requestRateLimited) {
            $this->setRequestNumAndTime($numRequests, time());
            return;
        }
        // If this is the first request, set its time to the current time.
        if ($numRequests == 1) {
            $this->setRequestNumAndTime($numRequests, time());
        }
        // Else if this is a '65th' request, compare the current and last times and sleep accordingly.
        else if ($numRequests % 65 == 0) {
            $curTime = time();
            $lastTime = $this->getLastRequestTime();
            $timeElapsed = $curTime - $lastTime;
            // If less than 60 seconds have elapsed since the last '65th' request, sleep.
            if ($timeElapsed < 60) {
                ini_set('max_execution_time', 360);
                sleep(60 - $timeElapsed);
                $this->setRequestNumAndTime($numRequests, time());
            } else {
                $this->setRequestNumAndTime($numRequests, $curTime);
            }
        }
        // Else, leave the time the same.
        else {
            $this->setRequestNumAndTime($numRequests, $this->getLastRequestTime());
        }
    }

    /**
     * Set the number and the time for the Steam requests.
     * @param $num : The total number of Steam API requests made so far.
     * @param $time : The time of the last '65th' request made.
     */
    private function setRequestNumAndTime($num, $time) : void
    {
        session(['stmRqt' => ['num' => $num, 'time' => $time]]);
    }

    /**
     * Get the time of the last '65th' request made. A '65th' request is the ith request such that
     * i is divisible by 65. 65 is a limit to the number of requests that can be made in a minute
     * to the Steam API. The maximum limit allowed is 69.4 requests per minute.
     * @return mixed
     */
    private function getLastRequestTime() {
        return session('stmRqt')['time'];
    }

    /**
     * Check if the range of provided first and last indexes is valid. If the range exceeds 50 or
     * either the first or last index is less than 0, then the range is invalid.
     * @param int $first
     * @param int $last
     * @param int $num
     * @return bool
     */
    private function isRangeValid(int $first, int $last, int $num) : bool
    {
        $rangeNum = $last - $first;
        if ($first <= 0 || $last <= 0 || $first > $num || $last > $num) {
            return false;
        } else if ($rangeNum > 49) {
            return false;
        }
        return true;
    }
}
