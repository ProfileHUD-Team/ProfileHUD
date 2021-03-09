<?php

namespace App\GameAPIs;

/**
 * Class UserObject: This class implements a user object, a user of ProfileHUD.
 * Date Created: 3/6/2021
 * @author Fernando Villarreal
 * @package App\GameAPIs
 */
class UserObject
{
    //============================ CLASS PROPERTIES ============================

    /**
     * The ProfileHUD username of the user.
     * @var String
     */
    private $userName;

    /**
     * The user's email address.
     * @var String
     */
    private $email;

    /**
     * The user's password.
     * @var String
     */
    private $password;

    //============================ CONSTRUCTOR ============================

    /**
     * UserObject constructor.
     * @param String $userName
     * @param String $email
     * @param String $password
     */
    public function __construct(string $userName, string $email, string $password)
    {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    //============================ FUNCTIONS ============================

    /**
     * @return String
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return String
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
