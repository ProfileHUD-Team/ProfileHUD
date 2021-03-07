<?php

namespace App\GameAPIs;

/**
 * Interface GameAPIInterface: This interface defines the main functionality of a video game
 * API class.
 * Date Created: 3/6/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
interface GameAPIInterface
{

    /**
     * Get the games owned by the specified user.
     * @param $userId : The user's ID.
     * @return mixed
     */
    public function getGamesOwned($userId);

    /**
     * Get profile information for the specified user.
     * @param $userId : The user's ID.
     * @return mixed
     */
    public function getProfileInfo($userId);

    /**
     * Get game information for the specified user. Such information includes playtime,
     * achievements/trophies earned, etc.
     * @param $userId : The user's ID.
     * @param $gameId : The game's ID.
     * @return mixed
     */
    public function getGameInfoForUser($userId, $gameId);
}
