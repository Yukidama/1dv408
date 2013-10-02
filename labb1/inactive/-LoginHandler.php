<?php

namespace view;

//require_once("src/model/loginHandler.php");

class loginHandler {
    private $message;
    private $userId;
    private $users = array(1 => "Admin", 2 => "Tester");
    private $passwords = array(1 => "Password", 2 => "Tester");
                              
    function tryLogin($username, $password) {
        //Username filled in
        if (strlen($username) > 0) {
            if (strlen($password) > 0) {
                $key = array_search($username, $this->users);
                //Username exists
                if ($key > 0) {
                    //Correct password
                    if ($this->passwords[$key] == $password) {
                        $this->userId = $key;
                        return "Inloggning lyckades";
                    }
                    //Correct username but wrong password
                    else {
                        return "Felaktigt användarnamn och/eller lösenord";
                    }
                }
                //Wrong username
                else {
                    return "Felaktigt användarnamn och/eller lösenord";
                }
            }
            //No password filled in
            else {
                return "Lösenord saknas";
            }

        } //No username filled in
        else {
            return "Användarnamn saknas";
        }
    }
    function loggedIn() {
        if ($this->userId > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    function getUserId() {
        return $this->userId;
    }
    function getUsername() {
        return $this->users[$this->userId];
    }
    function setUserId($userId) {
        $this->userId = $userId;
    }
    function logOut() {
        if ($this->loggedIn()) {
            $this->userId = 0;
            return "Du har nu loggat ut.";
        }
    }
    function getForm() {
        return "<form method=\"post\" action=\"index.php\">
            <fieldset>
                <legend>Logga in</legend>
                <label for=\"r_user\">Namn:</label><input type=\"text\" name=\"username\" placeholder=\"Ange användarnamn\" id=\"r_user\" value=\"\" />
                <label for=\"r_pass\">Lösenord:</label><input type=\"password\" name=\"password\" placeholder=\"Ange lösenord\" id=\"r_pass\" />
            </fieldset>
            <input type=\"hidden\" name=\"login_atempt\" value=\"1\" />
            <input type=\"submit\" value=\"Logga in\" />
        </form>";
    }
}

?>