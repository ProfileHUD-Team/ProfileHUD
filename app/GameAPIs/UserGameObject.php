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

    /**
     * The total number of achievements/trophies that can be earned for this game.
     * @var int
     */
    private $totalAchievements;

    /**
     * The list of achievements for this UserGameObject.
     * @var AchievementList
     */
    private $achievementList;

    //============================ CONSTRUCTOR ============================

    /**
     * UserGameObject constructor. The list of achievements is empty by default and must be manually
     * loaded if needed.
     * @param GameObject $game
     * @param String $platform
     * @param int $hoursPlayed
     * @param int $earnedAchievements
     * @param int $totalAchievements
     */
    public function __construct(GameObject $game, string $platform, int $hoursPlayed, int $earnedAchievements, int $totalAchievements)
    {
        $this->game = $game;
        $this->platform = $platform;
        $this->hoursPlayed = $hoursPlayed;
        $this->earnedAchievements = $earnedAchievements;
        $this->totalAchievements = $totalAchievements;
        $this->achievementList = new AchievementList();
    }

    //============================ FUNCTIONS ============================

    /**
     * Set the list of achievements.
     * @param AchievementList $achievementList
     */
    public function setAchievementList(AchievementList $achievementList): void
    {
        $this->achievementList = $achievementList;
    }

    /**
     * Load the list of achievements for this UserGameObject using a SteamAPIConnector object.
     * @param $userId : Steam ID of the user.
     * @param SteamAPIConnector $connector : Steam API connector to be used to load the achievements.
     */
    public function loadAchievementList($userId, SteamAPIConnector $connector) : void
    {
        $this->achievementList = $connector->getAchievements($userId, $this->game->getId());
    }

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

    /**
     * @return int
     */
    public function getTotalAchievements(): int
    {
        return $this->totalAchievements;
    }

    /**
     * @return AchievementList
     */
    public function getAchievementList() : AchievementList
    {
        return $this->achievementList;
    }

    public function toString() : string
    {
        return 'Game: ' . $this->game->getName() . '<br>'
            . 'Platform: ' . $this->platform . '<br>'
            . 'Hours Played: ' . $this->hoursPlayed . '<br>'
            . 'Achievements Earned: ' . $this->earnedAchievements . ' | '
            . $this->totalAchievements . '<br>';
    }
}
