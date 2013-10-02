Frågor:

View beror på view ?
interface/observer, gå igenom?


modell::Login

    /**
     * @var String
     */
    private $randomSalt = "DR#ms66MC!";
    
        
    /**
     * Get random code for temporary passwords
     * @return String
     */
    public function getRandomCode() {
        return sha1(mt_rand().$this->randomSalt.time());
    }
    
        
    /**
     * Login user with just a username
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
    
view::Login

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
   private static $keepLoggedIn = "keepLoggedIn";
   
      
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
   
   
   -- ((Ersätt $this->messageHolder->setMessage("Inloggning lyckades"); med detta))
               if ($this->userWantsCookie()) {
               $this->setCookie();
               $this->messageHolder->setMessage("Inloggning lyckades och vi kommer ihåg dig nästa gång");
            }
            else {
               $this->messageHolder->setMessage("Inloggning lyckades");
            }
            
            
---

   
   /**
    * Check if user wants to use cookies for login in the future
    * @return BOOL
    */
   private function userWantsCookie() {
      if (isset($_POST[self::$keepLoggedIn])) {
         return true;
      }
      return false;
   }
   
   /**
    * Set a cookie with username and temporary password
    */
   private function setCookie() {
      //echo "sätter kaka!";
      $timeout = time() + 60;
      $randomAuth = $this->loginModel->getRandomCode();
      setcookie(self::$cookieUsername, $_POST[self::$postUsername], $timeout);
      setcookie(self::$cookiePassword, $randomAuth, $timeout);
      
      file_put_contents(self::$cookieFolder."/".$_POST[self::$postUsername].".txt",
                        "$timeout,$randomAuth");
   }
   
   --- Ersött hela andra funktionen
   
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
                     $this->loginModel->loginUser($_COOKIE[self::$cookieUsername]);
                     $this->saveUserToSession();
                     $this->messageHolder->setMessage("Inloggning lyckades via cookie");
                  }
               }
            }
         }
      }
      else {
         $this->messageHolder->setMessage("Manipulerad sessionskaka");
      }
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
    * Removes cookies
    */
   public function removeCookies() {
      setcookie(self::$cookieUsername, "", -3600);
      setcookie(self::$cookiePassword, "", -3600);
   }
   
   
   -- Ersätt hela
    /**
   * Unset cookies, sessiona and LoginModels userID
   */
   public function logoutUser() {
      if (!isset($_SESSION[self::$sessionUserID])) {
          throw new \Exception("Tries to logout without being logged in");
      }
      //Logout user by removing session and userID from model::Login
      unset($_SESSION[self::$sessionUserID]);
      $this->removeCookies();
      if ($this->loginModel->isLoggedIn()) {
          $this->loginModel->setUserID(null);
          $this->messageHolder->setMessage("Du är nu utloggad");
      }
   }
   
   
   --
   <input type=\"checkbox\" name=\"" . self::$keepLoggedIn . "\" value=\"keep\" /> Håll mig inloggad