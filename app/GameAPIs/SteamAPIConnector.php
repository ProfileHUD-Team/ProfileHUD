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

    //============================ CONSTRUCTOR ============================

    /**
     * SteamAPIConnector constructor.
     * @param String $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    //============================ FUNCTIONS ============================

    /**
     * @inheritDoc
     */
    public function getGamesOwned($userId)
    {
        // TODO: Implement getGamesOwned() method.
    }

    /**
     * @inheritDoc
     */
    public function getProfileInfo($userId)
    {
        // TODO: Implement getProfileInfo() method.
    }

    /**
     * @inheritDoc
     */
    public function getGameInfoForUser($userId, $gameId)
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
}
