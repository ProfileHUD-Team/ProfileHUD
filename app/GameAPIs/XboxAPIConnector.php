<?php

namespace App\GameAPIs;
use Illuminate\Support\Facades\Http as Http;

/**
 * Class XboxAPIConnector: This class can make Xbox Web API requests and return parsable objects
 * defined in the GameAPIs package.
 * Date Created: 4/6/2021
 * @author Gregory Dwyer, Fernando Villarreal
 * @package App\GameAPIs
 */
class XboxAPIConnector implements GameAPIInterface
{
    //============================ STATIC PROPERTIES ============================

    /**
     * Null string to be used when returning empty objects.
     * @var string
     */
    public static $nullValue = 'NULL';

    //============================ CLASS PROPERTIES ============================

    /**
     * Xbox Web API key to be used for making API requests with this connector.
     * @var string
     */
    private $apiKey;

    /**
     * Base URL where to make Xbox API requests.
     * @var string
     */
    private $baseAPIUrl;

    /**
     * A list of any errors encountered when making requeFsts with this connector object.
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
     * XboxAPIConnector constructor.
     * @param String $apiKey : API key to be used for making requests.
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->requestRateLimited = false;
        $this->baseAPIUrl = 'https://xapi.us/v2/';
        $this->errorLog = array();
    }

    //============================ PUBLIC FUNCTIONS ============================
    /**
     * Get the XboxUser object that corresponds to the provided Xbox user ID.
     * @param $gamertag : The Xbox gamertag of the user.
     * @return array : The Xbox user as an array.
     */
    public function getXboxUser($gamertag) : array
    {
        $dataArray = [];
        //This call uses a different API from the other calls
        $url = $this->baseAPIUrl . 'xuid/' . $gamertag;
        $xuid = $this->performRequest($url);
        if(count($xuid) == 1){
            $xuid = $xuid['result'];
        }
        $profileUrl = $this->baseAPIUrl . $xuid . '/new-profile';
        $jsonObject = $this->performRequest($profileUrl);
        $dataArray['platform_id'] = $xuid;
        $dataArray['platform'] = 'xbl';
        $dataArray['platform_username'] = $gamertag;
        $dataArray['profile_image'] = $jsonObject["displayPicRaw"];
        return $dataArray;
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
        $url360 = $this->baseAPIUrl . $userId . '/xbox360games';
        $urlOne = $this->baseAPIUrl . $userId . '/xboxonegames';
        $x360Data = $this->performRequest($url360);
        $xOneData = $this->performRequest($urlOne);
        $gameIDs = array();
        foreach ($x360Data['titles'] as $gamesDatum) {
            $gameIDs[] = $gamesDatum['titleId'];
        }
        foreach ($xOneData['titles'] as $gamesDatum) {
            $gameIDs[] = $gamesDatum['titleId'];
        }
        return $gameIDs;
    }


    /**
     * @inheritDoc
     */
    public function getGameInfo($gameId) : GameObject
    {
        //convert the id into hex
        $hexId = dechex(intval($gameId));
        // Create the URL.
        $url = $this->baseAPIUrl . 'game-details-hex/' . $hexId;
        // Make the request to get a JSON object.
        $data = $this->performRequest($url);
        // Check if the JSON object has errors. Return an empty object if so.
        if ($this->hasErrors($data) or !array_key_exists('Items', $data)) {
            $nil = XboxAPIConnector::$nullValue;
            return new GameObject($nil, $nil, $nil, $nil, $nil);
        }
        $data = $data['Items'][0];
        // Parse the JSON object.
        $name = $data['Name'] ;
        $developer = $data['DeveloperName'] ?? "Not Listed";
        $publisher = $data['PublisherName'] ?? "Not Listed";
        $releaseDate = $data['ReleaseDate'] ?? '/Date(1483228800)/';
        $releaseDate = $this->changeDateFormat($releaseDate);
        $images = $data['Images'] ?? [];
        $coverImage = "/svg/default_image.png";
        foreach($images as $image){
            if($image['Purpose'] == "BoxArt"){
                $coverImage = $image['Url'];
            }
        }
        // Set the cover image. Create and return the GameObject.
        $gameObject = new GameObject($gameId, $name, $developer, $publisher, $releaseDate);
        $gameObject->setCoverImage($coverImage);
        return $gameObject;
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
     * @inheritDoc
     */
    public function getGameInfoForUser($userId, $gameId) : UserGameObject
    {
        // Get the information to create the user-game object.
        $game = $this->getGameInfo($gameId);
        $hoursPlayed = null;
        $achievementRatio = null;
        $earnedAchievements = $achievementRatio[0];
        $totalAchievements = $achievementRatio[1];
        // Create and return the UserGameObject.
        return new UserGameObject($game, 'xbl', $hoursPlayed, $earnedAchievements, $totalAchievements);
    }

    /**
     * Get the list of achievements for the specified user and game.
     * @param $userId : The Xbox ID of the user.
     * @param $gameId : The Xbox ID of the game.
     * @return AchievementList
     */
    public function getAchievements($userId, $gameId) : AchievementList
    {
        // Create the URL to get the list of achievements.
        $url = $this->baseAPIUrl . $userId . '/achievements/' . $gameId;
        // Make the requests to get JSON objects.
        $achievements = $this->performRequest($url);
        // Check if the JSON objects have errors. Return an empty object if so.
        if ($this->hasErrors($achievements)) {
            return new AchievementList();
        }
        if (count($achievements) == 0) {
            return new AchievementList();
        }
        return $this->loadAchievements($achievements);
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
     * Load the list of achievements given the JSON arrays of the user's and the game's achievements.
     * @param $playerAchievements : An array of the user's achievements.
     * @return AchievementList : The list of achievements.
     */
    private function loadAchievements($achievements) : AchievementList
    {
        // Iterate over the lists of achievements and create Achievement objects.
        $achievementList = new AchievementList();
       foreach($achievements as $currentAchievement){
           if(array_key_exists('platform',$currentAchievement)){
               $arrayData = $this->parse360Achievement($currentAchievement);
           }
           else{
               $arrayData = $this->parseOneAchievement($currentAchievement);
           }
           $achievement = new Achievement($arrayData['name'], $arrayData['description'], $arrayData['is_earned'], $arrayData['date_earned']);
           $achievement->setIconImage($arrayData['icon']);
           $achievementList->addAchievement($achievement);
       }
        // Return the AchievementList object.
        return $achievementList;
    }
    /**
     * Parses the array of a 360 achievement and formats the keys.
     * @param array $achievement
     * @return array
     */
    private function parse360Achievement($achievement) : array
    {
        $array =[];
        $array['name'] = $achievement['name'];
        $array['description'] = $achievement['description'];
        $array['is_earned'] = $achievement['unlocked'];
        $date = $achievement['timeUnlocked'];
        $date = $this->changeDateFormat($date);
        $array['date_earned'] = $date;
        $array['icon'] = $achievement['imageUnlocked'] ?? "/svg/default_image.png";
        return $array;
    }
    /**
     * Parses the array of a One achievement and formats the keys.
     * @param array $achievement
     * @return array
     */
    private function parseOneAchievement($achievement) : array
    {
        $array =[];
        $array['name'] = $achievement['name'];
        $array['description'] = $achievement['description'];
        $array['is_earned'] = $achievement['progressState'] == "Achieved";
        $date = $achievement['progression']['timeUnlocked'];
        $date = $this->changeDateFormat($date);
        $array['date_earned'] = (string) $date;
        $array['icon'] = $achievement['mediaAssets'][0]['url'] ?? "/svg/default_image.png";
        return $array;
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
     * Perform an HTTP request using the provided URL string. Returns an JSON object on success.
     * @param $url
     * @return array
     */
    private function performRequest($url) : array {
        try {
            // Perform the request.
            $result =  Http::withHeaders(['X-Auth'=>$this->apiKey])->get($url)->json();
            // Check if the request succeeded or failed.
            if(!is_array($result)){
                return array('result'=>$result);
            }
            return $result;
        } catch (\Exception $ex) {
            // Add the error to the error log.
            $this->errorLog[$url] = $ex->getMessage();
            return array();
        }
        return array();
    }


    private function changeDateFormat($dateString)
    {
        if(str_contains($dateString, "/Date")){
            $tempDate = substr($dateString, 6, strlen($dateString)-11);
            $dateString = date('c', $tempDate);
        }
        $date = date_create($dateString);
        if(!($date instanceof \DateTimeInterface)) {
            $date = new \DateTime('0');
        }
        return date_format($date,"m/d/Y");
    }

    /**
     * Get the game info for the specified game and return it as an array. Used for troubleshooting in development.
     * @param $gameId
     * @return array
     */
    private function getGameInfoArr($gameId) : array
    {
        //convert the id into hex
        $hexId = dechex(intval($gameId));
        // Create the URL.
        $url = $this->baseAPIUrl . 'game-details-hex/' . $hexId;
        // Make the request to get a JSON object.
        $data = $this->performRequest($url);
        return $data;
    }
}
