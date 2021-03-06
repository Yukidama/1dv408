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
   public function loginProcedure() {
      //First things first, check if values are entered for both username and password
      //If ok, check with model if username and password are valid.
   
      if (strlen($_POST[self::$postUsername]) < 1) {
         $this->messageHolder->setMessage("Användarnamn saknas");
      }
      else if (strlen($_POST[self::$postPassword]) < 1) {
         $this->messageHolder->setMessage("Lösenord saknas");
      }
      else {
         if ($this->loginModel->validateUser($_POST[self::$postUsername],
                                             $_POST[self::$postPassword])) {
            $this->messageHolder->setMessage("Inloggning lyckades");
            return true;
         }
         else {
            $this->messageHolder->setMessage("Felaktigt användarnamn och/eller lösenord");
         }
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
   
   /**
   * Unset cookies, sessiona and LoginModels userID
   */
   public function logoutUser() {
      $this->loginModel->setUserID(null);
      $this->messageHolder->setMessage("Du är nu utloggad");
   }
}
