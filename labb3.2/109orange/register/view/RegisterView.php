<?php

namespace register\view;

require("register/model/RegisterObserver.php");

class RegisterView implements \register\model\RegisterObserver {
    
    private static $registerLink = "register";
    private static $formUsername = "theUsername";
    private static $formPassword = "thePassword";
    private static $formPasswordAgain = "thePasswordAgain";
    
    private $model;
    
    private $messages = array();
    
    public function __construct(\register\model\RegisterModel $registerModel) {
        $this->model = $registerModel;
    }
    
    public function getRegisterButton() {
        return "<p><a href=\"?" . self::$registerLink . "\">Registrera</a></p>"; //@TODO '?' dynamic?
    }
    
    public function wantsToRegister() {
        if (isset($_GET[self::$registerLink])) {
            return true;
        }
    }
    
    private function getMessages() {
        $toReturn = "<p>";
        foreach ($this->messages as $key => $message) {
            $toReturn .= $message."<br />";
        }
        $toReturn .= "</p>";
        return $toReturn;
    }
    
    public function getRegistrationForm() {
        $_POST[self::$formUsername] = \Common\Filter::sanitizeString($_POST[self::$formUsername]);
        $messages = $this->getMessages();
        return "<form action='?" . self::$registerLink . "' method='post'>
                <fieldset>
                        $messages
                        <legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
                        <label for='UserNameID' >Användarnamn :</label>
                        <input type='text' size='20' name='" . self::$formUsername . "' id='UserNameID' value='" . (isset($_POST[self::$formUsername]) ? $_POST[self::$formUsername] : "") . "' /><br /><br />
                        <label for='PasswordID' >Lösenord  :</label>
                        <input type='password' size='20' name='" . self::$formPassword . "' id='PasswordID' value='' /><br /><br />
                        <label for='PasswordAgainID' >Repetera lösenord  :</label>
                        <input type='password' size='20' name='" . self::$formPasswordAgain . "' id='PasswordAgainID' value='' /><br /><br />
                        <label for='SubmitButton' >Skicka  :</label>
                        <input type='submit' name='' id='SubmitButton' value='Registrera' />
                </fieldset>
        </form>";
    }
    
    public function getBackButton() {
        return "<p><a href=\"./\">Tillbaka</a></p>";
    }
    
    public function registrationFormSent() {
        if (isset($_POST[self::$formUsername])) {
            return true;
        }
    }
    
    public function validateData() {
        return $this->model->tryCreateNewUser($_POST[self::$formUsername], $_POST[self::$formPassword], $_POST[self::$formPasswordAgain]);
    }
    
    public function getSuccessMessage() {
        return "Registrering av ny användare lyckades";
    }
    
    //Interface implementation
    
    public function usernameIsTooShort() {
        $this->messages[] = "Användarnamnet har för få tecken. Minst 3 tecken";
    }
    public function usernameIsTooLong() {
        $this->messages[] = "Användarnamnet har för många tecken";
    }
    public function usernameHasBadCharacters() {
        $this->messages[] = "Användarnamnet innehållet ogiltliga tecken";
    }
    public function passwordIsTooShort() {
        $this->messages[] = "Lösenordet har för få tecken. Minst 6 tecken";
    }
    public function passwordIsTooLong() {
        $this->messages[] = "Lösenordet har för många tecken";
    }
    public function passwordHasBadCharacters() {
        $this->messages[] = "Lösenordet innehållet ogiltliga tecken";
    }
    public function passwordDoesNotMatch() {
        $this->messages[] = "Lösenorden matchar inte.";
    }
    public function usernameTaken() {
        $this->messages[] = "Användarnamnet är redan upptaget";
    }
    
}
