<?php

namespace view;

class SessionsAndCookies {

    /**
     * @var String
     */
    private static $sessionUserID = "view::Login::userID";
    
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
     * @var String
     */
    private static $cookieUsername = "view::Login::Username";
    
    /**
     * @var String
     */
    private static $cookiePassword = "view::Login::Password";
    
    /**
     * @var \model\Login
     */
    private $loginModel;
    
    /**
    * @var \model\MessageHolder
    */
    private $messageHolder;
    
    /**
     * @var String
     */
    private static $cookieFolder = "cookieSecretFolder";
    
    /**
     * Constructor
     * @param \model\Login $aLoginModel
     * @param \model\MessageHolder $aMessageHolder
     */
        
    public function __construct(\model\Login $aLoginModel,
                                \model\MessageHolder $aMessageHolder) {
        $this->loginModel = $aLoginModel;
        $this->messageHolder = $aMessageHolder;
        
    }
    
    /**
     * Try to login with Session or Cookie
     */
    public function trySessionCookieLogin() {
        if (!$this->checkSessionHijack()) {
            if (isset($_SESSION[self::$sessionUserID])) {
                $this->loginModel->setUserID($_SESSION[self::$sessionUserID]);
            }
            else {
                if (isset($_COOKIE[self::$cookieUsername])) {
                    $this->tryCookie();
                }
            }
        }
        else {
            //Manipulated session - do nothing
        }
    }
    
    /**
     * Try to use Cookies to login
     */
    private function tryCookie() {
        $fileData = file_get_contents(self::$cookieFolder."/".$_COOKIE[self::$cookieUsername].".txt");
        if ($fileData) {
            $persistanceArray = explode(',', $fileData);
            if ($persistanceArray[0] < time()) {
                $this->removeSessionsAndCookies();
                $this->messageHolder->setMessage("Felaktig information i cookie");
            }
            else if ($persistanceArray[1] != $_COOKIE[self::$cookiePassword]) {
                $this->removeSessionsAndCookies();
                $this->messageHolder->setMessage("Felaktig information i cookie");
            }
            else {
                $this->loginModel->loginUser($_COOKIE[self::$cookieUsername]);
                $this->saveUserToSession();
                $this->messageHolder->setMessage("Inloggning lyckades via cookie");
            }
        }
    }
    

   
    /**
     * Removes cookies and session
     */
    public function removeSessionsAndCookies() {
        setcookie(self::$cookiePassword, "", -3600);
        setcookie(self::$cookieUsername, "", -3600);
        unset($_SESSION[self::$sessionUserID]);
    }
   
   
    /**
     * Save current user to session
     */
    /*
    public function saveUserToSession() {
        try {
            $_SESSION[self::$sessionUserID] = $this->loginModel->getUserID();
        }
            catch(\Exception $e) {
            //User is not logged in.
        }
    }
    */
   
    /**
    * Set a cookie with username and temporary password
    */ 
    public function setCookie($aUsername) {

        $timeout = time() + 60;
        $randomAuth = $this->loginModel->getRandomCode();
        setcookie(self::$cookieUsername, $aUsername, $timeout);
        setcookie(self::$cookiePassword, $randomAuth, $timeout);
        
        file_put_contents(self::$cookieFolder."/$aUsername.txt",
                          "$timeout,$randomAuth");
        $this->messageHolder->setMessage("Inloggning lyckades och vi kommer ihåg dig nästa gång");
    }
}