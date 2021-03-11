<?php

namespace App\GameAPIs;

/**
 * Class GameList: This class may be used to store and manage lists of either GameObjects or
 * UserGameObjects.
 * @package App\GameAPIs
 */
class GameList
{
    //============================ CLASS PROPERTIES ============================

    /**
     * An array of GameObjects or UserGameObjects.
     * @var array
     */
    private $list;

    //============================ CONSTRUCTOR ============================

    /**
     * GameList constructor.
     */
    public function __construct()
    {
        $this->list = array();
    }

    //============================ FUNCTIONS ============================

    /**
     * Add a game object to the list.
     * @param $game mixed
     */
    public function addGame($game)
    {
        $this->list[] = $game;
    }

    /**
     * Get the game object at the specified index.
     * @param $index
     * @return mixed
     */
    public function getGame($index)
    {
        return $this->list[$index];
    }

    /**
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
