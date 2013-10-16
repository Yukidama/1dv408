<?php

namespace controller;

class Login {
    
    /**
     * @var \view\Login
     */
    private $loginModel;
    
    /**
     * @var \view\Login
     */
    private $loginView;
    
    /**
     * @var \view\SessionsAndCookies
     */
    private $sessionsAndCookies;
    
    /**
     * Get LoginModel and LoginView and set them to member variables
     * @param \model\Login $aLoginModel
     * @param \view\Login $aLoginView
     */
    public function __construct(\model\Login                $aLoginModel,
                                 \view\Login                $aLoginView,
                                 \view\SessionsAndCookies   $aSessionsAndCookies) {
        $this->loginModel = $aLoginModel;
        $this->loginView = $aLoginView;
        $this->sessionsAndCookies = $aSessionsAndCookies;
    }
    
    /*
     * Check if user wants to login and returns correct html
     * @return String HTML
     */
    public function loginPage() {
        
        $reloading = false;

        if ($this->loginView->userWantsLogin()) {

            //User successfully logged in
            if ($this->loginView->loginProcedure()) {
                $this->sessionsAndCookies->saveUserToSession();
                if ($this->loginView->userWantsCookie()) {
                    $this->sessionsAndCookies->setCookie($this->loginModel->getUsername());
                }
                //--Reload needed
                $reloading = true;
            }
        }
        if (!$reloading) {
            $title = $this->loginView->getTitle();
            $body = $this->loginView->getForm();
            $HTMLOutput = new \model\HTMLPage($title, $body);
            return $HTMLOutput;
        }
        else {
            \view\Navigation::reloadPage();
        }
        //If reloading, return an empty htmlobject
        return new \model\HTMLPage();
    }
}
