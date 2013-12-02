<?php

namespace view;

class Login {
   
   /**
    * @var \model\Login
    */
   private $loginModel;
   
   /**
    * @var String
    */
   private static $getLogout = "logout";

   /**
    * @var String
    */
   private static $postUsername = "username";
   
   /**
    * @var String
    */
   private static $postPassword = "password";
   
   /**
    * @var String
    */
   private $title = "Logga in tack";
   
   /**
    * @var String
    */
   private static $keepLoggedIn = "keepLoggedIn";
   
   /**
    * @var \model\MessageHolder
    */
   private $messageHolder;

    /**
     * @var String
     */
    private static $cookieUsername = "view::Login::Username";
    
    /**
     * @var String
     */
    private static $cookiePassword = "view::Login::Password";
   
    /**
     * @var String
     */
    private static $cookieFolder = "cookieSecretFolder";
    
   /**
    * Constructor takes two objects and sets them to member variables
    * @param \model\Login $aLoginModel
    * @param \model\MessageHolder $aMessageHolder
    */
   public function __construct(\model\Login        $aLoginModel,
                               \model\MessageHolder $aMessageHolder) {
      $this->loginModel = $aLoginModel;
      
      $this->messageHolder = $aMessageHolder;
   }
   
   /**
    * Returns html for a login-form
    * @return String HTML
    */
   public function getForm() {
      $message = "";
      if ($this->messageHolder->messageExists()) {
         $message = "<p class=\"errorMessage\">" . $this->messageHolder->getMessageOnce() . "</p>";
      }
      return "
         <form method=\"post\" action=\"index.php\">
            <fieldset>
               <legend>Logga in</legend>
               $message
               <label for=\"r_user\">Användarnamn:</label><input type=\"text\" name=\"" .
                  self::$postUsername ."\" placeholder=\"Ange användarnamn\" id=\"r_user\" value=\"" . (isset($_POST[self::$postUsername]) ? $_POST[self::$postUsername] : '') . "\" />
               <label for=\"r_pass\">Lösenord:</label><input type=\"password\" name=\"" .
                  self::$postPassword . "\" placeholder=\"Ange lösenord\" id=\"r_pass\" />
                  <input type=\"checkbox\" name=\"" . self::$keepLoggedIn . "\" value=\"keep\" /> Håll mig inloggad
            </fieldset>
            <input type=\"submit\" value=\"Logga in\" />
         </form>";
   }
   
   /**
    * Checks if user tries to login
    * @return BOOL
    */
   public function userWantsLogin() {
      return isset($_POST[self::$postUsername]);
   }
   
   /**
    * Returns the static title set for this view
    * @return String
    */
   public function getTitle() {
      return $this->title;
   }
   
   /**
   * Tries to login user by validating the username och password.
   * @return BOOL
   */
   public function inputLooksGood() {
      //First things first, check if values are entered for both username and password
   
      if (strlen($_POST[self::$postUsername]) < 1) {
         $this->messageHolder->setMessage("Användarnamn saknas");
      }
      else if (strlen($_POST[self::$postPassword]) < 1) {
         $this->messageHolder->setMessage("Lösenord saknas");
      }
      else {
         return true;
      }
      return false;
   }
   
   /**
    * Tries to login user
    * @return BOOL
    */
   public function loginUser() {
      assert($_POST[self::$postUsername] && $_POST[self::$postPassword]);
      if ($this->loginModel->validateUser($_POST[self::$postUsername],
                                          $_POST[self::$postPassword])) {
         $this->messageHolder->setMessage("Inloggning lyckades");
         return true;
      }
      else {
         $this->messageHolder->setMessage("Felaktigt användarnamn och/eller lösenord");
      }
      return false;
   }

   /**
    * Check if user wants to log out
    * @return BOOL
    */
   public function userWantsLogout() {
      return isset($_GET[self::$getLogout]);
   }
   
   /**
    * Set proper message for logout
    */
   public function setLogoutMessage() {
      $this->messageHolder->setMessage("Du är nu utloggad");
   }
   
   /**
    * Return a log out link
    * @return String
    */
   public function getLogoutLink() {
      return "<a href=\"?" . self::$getLogout . "\">Logga ut</a>";
   }
   
   /**
    * Check if user wants to use cookies for login in the future
    * @return BOOL
    */
   public function userWantsCookie() {
      if (isset($_POST[self::$keepLoggedIn])) {
         return true;
      }
      return false;
   }
   
   // -- Cookie stuff! --- //
   
   public function tryCookieLogin() {
      if (isset($_COOKIE[self::$cookieUsername])) {
         return $this->tryCookie();
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
            $this->removeCookies();
            $this->messageHolder->setMessage("Felaktig information i cookie");
         }
         else if ($persistanceArray[1] != $_COOKIE[self::$cookiePassword]) {
            $this->removeCookies();
            $this->messageHolder->setMessage("Felaktig information i cookie");
         }
         else {
            $this->loginModel->loginCookieUser($_COOKIE[self::$cookieUsername]);
            $this->messageHolder->setMessage("Inloggning lyckades via cookie");
            return true;
         }
      }
      return false;
   }
    

   
   /**
    * Removes cookies and session
    */
   public function removeCookies() {
      setcookie(self::$cookiePassword, "", -3600);
      setcookie(self::$cookieUsername, "", -3600);
   }

   
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
