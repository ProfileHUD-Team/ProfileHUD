<?php

namespace App\GameAPIs;

/**
 * Class SteamAPIConnector: This class can make Steam Web API requests and return parsable objects
 * defined in the GameAPIs package.
 * Date Created: 3/6/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class SteamAPIConnector implements GameAPIInterface
{

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

    //============================ CONSTRUCTOR ============================

    /**
     * SteamAPIConnector constructor.
     * @param String $apiKey : API key to be used for making requests.
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->baseAPIUrl = "http://api.steampowered.com/";
    }

    //============================ FUNCTIONS ============================

    /**
     * Get game information using the provided identifier in a GameObject.
     * @inheritDoc
     */
    public function getGameInfo($gameId): GameObject
    {
        // Create the URL.
        $url = "https://store.steampowered.com/api/appdetails?appids=" . $gameId;
        // Make the request to get a JSON object.
        $jsonObject = $this->performRequest($url);
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
     * @inheritDoc
     */
    public function getGamesOwned($userId) : GameList
    {
        // TODO: Implement getGamesOwned() method.
    }

    /**
     * @inheritDoc
     */
    public function getUserProfile($userId) : UserObject
    {
        // TODO: Implement getProfileInfo() method.
    }

    /**
     * @inheritDoc
     */
    public function getGameInfoForUser($userId, $gameId) : UserGameObject
    {
        // TODO: Implement getGameInfoForUser() method.
    }

    /**
     * Perform an HTTP request using the provided URL string. Returns an JSON object on success.
     * @param $url
     * @return mixed|string
     */
    public function performRequest($url) {
        // Perform the request.
        $result = fopen($url, 'r');
        // Check if the request succeeded or failed.
        if ($result == false) {
            return "Error on making request!!";
        } else {
            $str = stream_get_contents($result);
            return json_decode($str, true);
        }
    }

    /**
     * Convert the format of the provided date string into MM/DD/YYYY.
     * @param $dateString
     * @return false|string
     */
    private function changeDateFormat($dateString)
    {
        $date = date_create($dateString);
        return date_format($date,"m/d/Y");
    }
}
