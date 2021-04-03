<?php

namespace App\GameAPIs;

/**
 * Class SteamUser: This class implements the basic information that is associated with a Steam user.
 * Date Created: 3/12/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class SteamUser
{
    //============================ CLASS PROPERTIES ============================

    /**
     * The Steam ID of the user.
     * @var string
     */
    private $id;

    /**
     * The Steam username.
     * @var string
     */
    private $username;

    /**
     * An array of containing the Steam ID numbers of the games owned by the user.
     * @var array
     */
    private $gameListSimple;

    /**
     * The list of games owned by the Steam user.
     * @var GameList
     */
    private $gameList;

    /**
     * URL string for the profile image of this Steam User.
     * @var string
     */
    private $profileImage;

    //============================ CONSTRUCTOR ============================

    /**
     * SteamUser constructor. Note that the GameList property is not required for this constructor.
     * Loading this property is optional as it requires many requests to the Steam Web API.
     * @param string $id
     * @param string $username
     * @param array $gameListSimple
     */
    public function __construct(string $id, string $username, array $gameListSimple)
    {
        $this->id = $id;
        $this->username = $username;
        $this->gameListSimple = $gameListSimple;
    }

    //============================ STATIC FUNCTIONS ============================

    /**
     * Load and get a SteamUser object from the provided data.
     * @param array $steamData : An associative array containing Steam User data.
     * @return SteamUser
     */
    public static function loadSteamUser(array $steamData) : SteamUser
    {
        $steamID = $steamData['steamID'];
        $username = $steamData['username'];
        $gameList = $steamData['gameList'];
        return new SteamUser($steamID, $username, $gameList);
    }

    //============================ CLASS FUNCTIONS ============================

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function getGameListSimple(): array
    {
        return $this->gameListSimple;
    }

    /**
     * @return GameList
     */
    public function getGameList(): GameList
    {
        return $this->gameList;
    }

    /**
     * Get the URL string for the cover image.
     * @return string
     */
    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    /**
     * Set the URL string for the profile image of this Steam User.
     * @param string $url
     */
    public function setProfileImage(string $url) : void
    {
        $this->profileImage = $url;
    }

    /**
     * Load the list of games owned by this Steam User using the provided SteamAPIConnector object.
     * Note that this operation calls SteamAPIConnector::getGamesOwned, which may require several
     * Steam API requests.
     * @param SteamAPIConnector $connector : Connector to be used to make the request to the Steam API.
     */
    public function loadGameList(SteamAPIConnector $connector): void
    {
        $gameList = $connector->getGamesOwned($this->id);
        $this->gameList = $gameList;
    }

    /**
     * Return an associative array representation of this SteamUser object.
     * @return array
     */
    public function toDataArray() : array
    {
        $data = [];
        $data['steamID'] = $this->id;
        $data['username'] = $this->username;
        $data['gameList'] = $this->gameListSimple;
        return $data;
    }

    /**
     * Return a string representation of this object.
     * @return string
     */
    public function toString() : string
    {
        // Create a string for the simple array of game IDs.
        $gamesStr = $this->arrayToString($this->gameListSimple);
        $gamesStr = '[' . $gamesStr . ']';
        // Return the string representation.
        return 'ID: ' . $this->id . '<br>'
            . 'Username: ' . $this->username . '<br>'
            . 'Games Owned: ' . $gamesStr . '<br>';
    }

    private function arrayToString($array) : string
    {
        $str = '';
        $lastIndex = count($array) - 1;
        for ($i = 0; $i <= $lastIndex; $i++) {
            if ($i != $lastIndex) {
                $str = $str . $array[$i] . ', ';
            } else {
                $str = $str . $array[$i];
            }
        }
        return $str;
    }
}
