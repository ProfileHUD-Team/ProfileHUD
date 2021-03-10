<?php

namespace App\GameAPIs;

/**
 * Class GameObject: This class implements a video game object.
 * This version of a game object contains information such as the release date, developer, and
 * publisher of the game. Note that this object is not connected to a user and so it does not
 * store information such as playtime or achievements/trophies. This game object is what a
 * Game Web API should return upon a request.
 * when it is requested.
 * Date Created: 3/6/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class GameObject
{
    //============================ CLASS PROPERTIES ============================

    /**
     * Identifier for this game object.
     * @var string
     */
    private $id;

    /**
     * Name of the video game.
     * @var String
     */
    private $name;

    /**
     * Name of the game's developer.
     * @var String
     */
    private $developer;

    /**
     * Name of the game's publisher.
     * @var String
     */
    private $publisher;

    /**
     * Release date of the game in MM/DD/YYYY format.
     * @var String
     */
    private $releaseDate;

    //============================ CONSTRUCTOR ============================

    /**
     * GameObject constructor.
     * @param string $id
     * @param String $name
     * @param string $developer
     * @param string $publisher
     * @param string $releaseDate
     */
    public function __construct(string $id, string $name, string $developer, string $publisher, string $releaseDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->developer = $developer;
        $this->publisher = $publisher;
        $this->releaseDate = $releaseDate;
    }

    //============================ FUNCTIONS ============================

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getDeveloper(): string
    {
        return $this->developer;
    }

    /**
     * @return String
     */
    public function getPublisher(): string
    {
        return $this->publisher;
    }

    /**
     * @return String
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function toString() : string
    {
        return 'Name: ' . $this->name . '<br>'
            . 'ID: ' . $this->id . '<br>'
            . 'Developer: ' . $this->developer . '<br>'
            . 'Publisher: ' . $this->publisher . '<br>'
            . 'Release Date: ' . $this->releaseDate . '<br>';
    }
}
