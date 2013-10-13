<?php

namespace model;

class Login {
    
    /**
     * @var Int
     */
    private $loggedInID;
    
    /**
     * @var String
     */
    private $randomSalt = "DR#ms66MC!";
    
    /**
     * Temporary array as datasource for usernames.
     * UserID will always be 1 or higher when running a database
     * @var Array Usernames
     */
    private static $username = array("",
                                     "Firsthere",
                                     "Admin",
                                     "OtherUser");
    
    /**
     * Temporary array as datasource for password.
     * UserID will always be 1 or higher when running a database
     * @var String Passwords
     */ 
    private static $password = array("",
                                     "Somethingelse here",
                                     "Password",
                                     "OtherPassword");
    
    /**
     * Check if username och password are correct
     * @param String @aUsername
     * @param String @aPassword
     * @return BOOL
     */
    public function validateUser($aUsername, $aPassword) {
        assert(isset($aUsername) && isset($aPassword));
        
        $key = array_search($aUsername, self::$username);
        if ($key > 0) {
            if (self::$password[$key] == $aPassword) {
                $this->loggedInID = $key;
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if user is logged in. Is loggedInID set, user is logged in
     * @return BOOL
     */
    public function isLoggedIn() {
        if ($this->loggedInID > 0) {
            return true;
        }
        return false;
    }
    
    /**
     * returns users ID
     * @return Int;
     * @throws Exception when method used in wrong situation
     */
    public function getUserID() {
        if ($this->loggedInID < 1) {
            throw new \Exeption("User is not logged in");
        }
        return $this->loggedInID;
    }
    
    /**
     * Set UserID
     * @param Int $aUserID
     */
    public function setUserID($aUserID) {
        $this->loggedInID = $aUserID;
    }
    
    /**
     * Login user with just a username
     * @throws Exception if username cant be find.
     */
    public function loginUser($aUsername) {
        $userID = array_search($aUsername, self::$username);
        if (is_numeric($userID) && $userID > 0) {
            $this->setUserID($userID);
        }
        else {
            throw new \Exception("Something wrong when using Username-login");
        }
    }
    
    /**
     * Returns current users username
     * @return String
     */
    public function getUsername() {
        return self::$username[$this->loggedInID];
    }
    
    /**
     * Get random code for temporary passwords
     * @return String
     */
    public function getRandomCode() {
        return sha1(mt_rand().$this->randomSalt.time());
    }
}
