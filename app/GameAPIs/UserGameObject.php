<?php

namespace App\GameAPIs;

/**
 * Class UserGameObject: This class implements a user's game object. This version of a game object
 * stores information such as the playtime and a list of achievements/trophies.
 * Date Created: 3/6/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class UserGameObject
{
    //============================ CLASS PROPERTIES ============================

    /**
     * The GameObject associated with this UserGameObject.
     * @var GameObject
     */
    private $game;

    /**
     * The platform/service on which the game is owned.
     * @var String
     */
    private $platform;

    /**
     * The number of hours the game has been played.
     * @var int
     */
    private $hoursPlayed;

    /**
     * The number of achievements/trophies earned for this game.
     * @var int
     */
    private $earnedAchievements;

    //============================ CONSTRUCTOR ============================

    /**
     * UserGameObject constructor.
     * @param GameObject $game
     * @param String $platform
     * @param int $hoursPlayed
     * @param int $earnedAchievements
     */
    public function __construct(GameObject $game, string $platform, int $hoursPlayed, int $earnedAchievements)
    {
        $this->game = $game;
        $this->platform = $platform;
        $this->hoursPlayed = $hoursPlayed;
        $this->earnedAchievements = $earnedAchievements;
    }

    //============================ FUNCTIONS ============================

    /**
     * @return GameObject
     */
    public function getGame(): GameObject
    {
        return $this->game;
    }

    /**
     * @return String
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return int
     */
    public function getHoursPlayed(): int
    {
        return $this->hoursPlayed;
    }

    /**
     * @return int
     */
    public function getEarnedAchievements(): int
    {
        return $this->earnedAchievements;
    }
}
