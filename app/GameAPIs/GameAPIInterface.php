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
     * Get game information using the provided game ID.
     * @param $gameId : The game's ID.
     * @return GameObject
     */
    public function getGameInfo($gameId): GameObject;

    /**
     * Get the games owned by the specified user.
     * @param $userId : The user's ID.
     * @return GameList
     */
    public function getGamesOwned($userId): GameList;

    /**
     * Get game information for the specified user. Such information includes playtime,
     * achievements/trophies earned, etc.
     * @param $userId : The user's ID.
     * @param $gameId : The game's ID.
     * @return UserGameObject
     */
    public function getGameInfoForUser($userId, $gameId): UserGameObject;
}
