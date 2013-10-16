<?php

namespace register\model;

require("login/model/UserName.php");
require("login/model/Password.php");

class RegisterModel {
    
    private $username;
    private $password;
    private $userlist;
    private $observer;
    
    public function __Construct(\login\model\UserList $userlist) {
        $this->userlist = $userlist;
    }
    
    public function tryCreateNewUser($username, $password, $passwordAgain) {
        $userAvaliable = $this->avaliableUser($username);
        if ($userAvaliable) {
            $userValid = $this->validateUsername($username);
            $passwordValid = $this->validatePassword($password);
            $passwordMatch = $this->isSamePassword($password, $passwordAgain);
            
            if ($userValid && $passwordValid && $passwordMatch && $userAvaliable) {
                $this->userlist->addUser($this->username, $this->password);
                return true;
            }
        }
        return false;
    }
    
    
    private function validateUsername($username) {
        try {
            $this->username = new \login\model\UserName($username, $this->observer);
        }
        catch(\Exception $e) {
            return false;
        }
        return true;
    }
    
    private function avaliableUser($user) {     
        $exists = $this->userlist->userExists($user);
        if ($exists) {
            $this->observer->usernameTaken();
            return false;
        }
        return true;
    }
    
    private function validatePassword($password) {
        try {
            $this->password = \login\model\Password::fromCleartext($password, $this->observer);
        }
        catch (\Exception $e) {
            return false;
        }
        return true;
    }
    
    private function isSamePassword($password1, $password2) {
        if ($password1 !== $password2) {
            $this->observer->passwordDoesNotMatch();
            return false;
        }
        return true;
    }
    
    public function getUserNameInText() {
        return $this->username->__toString();
    }
    
    public function setObserver(\register\model\RegisterObserver $observer) {
        $this->observer = $observer;
    }
}
