<?php

namespace App\GameAPIs;

/**
 * Class AchievementList: This class contains and manages a list of Achievement objects.
 * Date Created: 3/9/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class AchievementList
{
    //============================ CLASS PROPERTIES ============================

    /**
     * An array of Achievement objects.
     * @var array
     */
    private $list;

    //============================ CONSTRUCTOR ============================

    /**
     * AchievementList constructor.
     */
    public function __construct()
    {
        $this->list = array();
    }

    //============================ FUNCTIONS ============================

    /**
     * Get the achievement at the specified index.
     * @param $index
     * @return mixed
     */
    public function getAchievement($index)
    {
        return $this->list[$index];
    }

    /**
     * Add an Achievement object to the end of this list.
     * @param $achievement : The Achievement object to be added.
     */
    public function addAchievement($achievement)
    {
        $this->list[] = $achievement;
    }

    /**
     * Get an array of the Achievement objects in this list.
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * Get the size of this list.
     * @return int
     */
    public function getSize(): int
    {
        return count($this->list);
    }
}
