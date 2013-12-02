<?php

namespace model;

class User {
    /**
     * @var String
     */
    private $username;
    
    /**
     * @var String
     */
    private $password;
    
    /**
     * Constructor
     * @param String $a_username
     * @param String $a_password
     */
    public function __construct($a_username, $a_password) {
        $this->username = $a_username;
        $this->password = $a_password;
    }
    
    /**
     * Creates instance with username and password
     * @param String $a_username
     * @param String $a_password
     * @return User
     */
    public static function createFromPlainPassword($a_username, $a_password) {
        return new User($a_username, self::encryptPassword($a_password));
    }
    
    /**
     * Creates instance from just username
     * @param String $a_username
     * @return User
     */
    public static function createFromUsername($a_username) {
        return new User($a_username, "");
    }
    
    /**
     * Returns username
     * @return String
     */
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * Checks if instance has same username as $compare which also is a User
     * @param User $compare
     * @return BOOL
     */
    public function hasSameUsername(User $compare) {
        if ($this->username == $compare->username) {
            return true;
        }
        return false;
    }
    
    /**
     * Encrypt password
     * @return String
     */
    private static function encryptPassword($plainPassword) {
        return sha1("mmA221" . $plainPassword . "194FDA");
    }
    
    /**
     * Checks if $compare is same as instance
     * @param User $compare
     * $return BOOL
     */
    public function isSameUser(User $compare) {
        if ($this->username == $compare->username) {
            if ($this->password == $compare->password) {
                return true;
            }
        }
        return false;
    }
}