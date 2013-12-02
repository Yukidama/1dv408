<?php

namespace model;

require_once("UserList.php");

class Login {
    
    /**
     * @var String
     */
    private $randomSalt = "DR#ms66MC!";
    
    /**
     * @var model/User
     */
    private $loggedInUser;
    
    /**
     * @var String
     */
    private static $sessionUser = "model::Login::UserObject";
    
    /**
     * User for protecting the application from session hijacks
     * @var String
     */
    private static $sessionUserAgent = "view::Login::user_agent";
    
    /**
     * User for protecting the application from session hijacks
     * @var String
     */
    private static $sessionIP = "view::Login::ip_address";
    
    /**
     * List of User's
     * @var UserList
     */
    private $userList;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->userList = new UserList();
    }
    
    /**
     * Check if username och password are correct
     * @param String @aUsername
     * @param String @aPassword
     * @return BOOL
     */
    public function validateUser($aUsername, $aPassword) {
        assert(isset($aUsername) && isset($aPassword));
        try {
            $this->loggedInUser = $this->userList->tryLoginUser($aUsername, $aPassword);
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Check if username och temppassword are correct
     * @param String @aUsername
     * @return BOOL
     */
    public function LoginCookieUser($aUsername) {
        assert(isset($aUsername));
        try {
            $this->loggedInUser = $this->userList->tryLoginCookieUser($aUsername);
            $this->saveToSession();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Check if user is logged in. Is loggedInID set, user is logged in
     * @return BOOL
     */
    public function isLoggedIn() {
        if (isset($this->loggedInUser)) {
            return true;
        }
        return false;
    }
    
    /**
     * Saves current logged in User to session
     */
    public function saveToSession() {
        try {
            $_SESSION[self::$sessionUser] = $this->loggedInUser;
            $_SESSION[self::$sessionUserAgent] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION[self::$sessionIP] = $_SERVER['SERVER_ADDR'];
        }
            catch(\Exception $e) {
            //User is not logged in.
        }
    }
    
    /**
     * Sets user to the one in Session if correct
     * @return BOOL
     */
    public function trySessionLogin() {
        if (!$this->checkSessionHijack()) {
            if (isset($_SESSION[self::$sessionUser])) {
                $this->loggedInUser = $_SESSION[self::$sessionUser];
                return true;
            }
        }
        return false;
    }
    
    /**
     * Checks if session cookie have been manipulated by checking user agent and ip address
     * @return BOOL
     */
    private function checkSessionHijack() {

        if (isset($_SESSION[self::$sessionUserAgent]) && isset($_SESSION[self::$sessionIP])) {
            if ($_SERVER['HTTP_USER_AGENT'] == $_SESSION[self::$sessionUserAgent] &&
                $_SERVER['SERVER_ADDR'] == $_SESSION[self::$sessionIP]) {
                return false;
            }
            else {
                return true;
            }
        }
        else {
            $_SESSION[self::$sessionUserAgent] = $_SERVER["HTTP_USER_AGENT"];
            $_SESSION[self::$sessionIP] = $_SERVER["SERVER_ADDR"];
            return false;
        }
    }
    
    /**
     * Returns current users username
     * @return String
     */
    public function getUsername() {
        return $this->loggedInUser->getUsername();
        //return "AnvŠndare";
    }
    
    /**
     * Logs the user out by unseting the member variable and session
     */
    public function logoutUser() {
        unset($this->loggedInUser);
        unset($_SESSION[self::$sessionUser]);
    }
    
    /**
     * Get random code for temporary passwords
     * @return String
     */
    public function getRandomCode() {
        return sha1(mt_rand().$this->randomSalt.time());
    }
}
