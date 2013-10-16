<?php

namespace register\controller;

class RegisterController {
    
    /**
     * @var register\view\RegisterView
     */
    private $registerView;
    
    private $success = false;
    
    /*
     * Constructor
     * @param register\view\RegisterView $registerView
     */
    public function __construct(\register\view\RegisterView $registerView) {
        $this->registerView = $registerView;
    }
    
    public function doingRegistration() {
        if ($this->registerView->wantsToRegister()) {
            return true;
        }
        return false;
    }
    
    
    public function didRegisterUser() {
        return $this->success;
    }
    
    
    public function handleRegistrationIfNeeded() {
        if ($this->registerView->registrationFormSent()) {
            if ($this->registerView->validateData()) {
                //User has been created
                $this->success = true;
            }
        }
    }
}
