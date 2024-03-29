<?php

namespace App\GameAPIs;

/**
 * Class Achievement: This class contains the information for an achievement or trophy.
 * Date Created: 3/9/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class Achievement
{
    //============================ CLASS PROPERTIES ============================

    /**
     * The name of the achievement/trophy.
     * @var string
     */
    private $name;

    /**
     * Description for the requirements to earn this achievement/trophy.
     * @var string
     */
    private $description = "No Description";

    /**
     * Had the achievement/trophy been earned? True if so, false otherwise.
     * @var boolean
     */
    private $earned;

    /**
     * The date (MM/DD/YYYY) on which the achievement/trophy was earned if applicable.
     * @var string
     */
    private $dateEarned;

    /**
     * URL string for the icon image of this achievement.
     * @var string
     */
    private $iconImage;

    //============================ CONSTRUCTOR ============================

    /**
     * Achievement constructor.
     * @param string $name
     * @param string $description
     * @param bool $earned
     * @param string $dateEarned
     */
    public function __construct(string $name, string $description, bool $earned, string $dateEarned)
    {
        $this->name = $name;
        $this->description = $description;
        $this->earned = $earned;
        $this->dateEarned = $dateEarned;
    }

    //============================ FUNCTIONS ============================

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isEarned(): bool
    {
        return $this->earned;
    }

    public function isEarnedStr() : string
    {
        if ($this->earned) {
            return "Yes";
        }
        return "No";
    }

    /**
     * @return string
     */
    public function getDateEarned(): string
    {
        return $this->dateEarned;
    }

    /**
     * Get the URL for the icon image of this achievement.
     * @return string
     */
    public function getIconImage(): string
    {
        return $this->iconImage;
    }

    /**
     * Set the URL for the icon image of this achievement.
     * @param string $iconImage
     */
    public function setIconImage(string $iconImage): void
    {
        $this->iconImage = $iconImage;
    }

    /**
     * Get the contents of this achievement object as an array.
     * @return array
     */
    public function toDataArray(): array
    {
        $data = [];
        $data['name'] = $this->name;
        $data['description'] = $this->description;
        $data['is_earned'] = $this->earned;
        $data['date_earned'] = $this->dateEarned;
        $data['image'] = $this->iconImage;
        return $data;
    }

    public function toString() : string
    {
        $earnedStr = '1';
        if ($this->earned == false) {
            $earnedStr = '0';
        }
        return 'Name: ' . $this->name . '<br>'
            . 'Description: ' . $this->description . '<br>'
            . 'Earned: ' . $earnedStr . '<br>'
            . 'Date Earned: ' . $this->dateEarned . '<br>'
            . 'Img:' . $this->iconImage . '<br>';
    }

}
