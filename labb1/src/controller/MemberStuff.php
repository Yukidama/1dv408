<?php

namespace controller;

require("src/view/MemberView.php");


class MemberStuff {
    
    /**
     * @var \model\Login
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
     * constructor which takes objects and set them as member variables
     * @param \model\Login $aLoginModel
     * @param \view\Login $aLoginView
     * @param \view\MessageHolder $aMessageHolder
     * @param \view\SessionsAndCookies $aMessageHolder
     */
    public function __construct(\model\Login                $aLoginModel,
                                \view\Login                 $aLoginView,
                                \view\MessageHolder         $aMessageHolder,
                                \view\SessionsAndCookies    $aSessionsAndCookies) {
        
        $this->loginModel = $aLoginModel;
        $this->loginView = $aLoginView;
        $this->messageHolder = $aMessageHolder;
        $this->sessionsAndCookies = $aSessionsAndCookies;
    }
    
    /**
     * Check if user wants to logout and returns html
     * @return String HTML
     */
    public function loggedInPage() {
        $this->memberView = new \view\memberView($this->loginModel,
                                                 $this->loginView,
                                                 $this->messageHolder);
        
        $reloading = false;
        
        if ($this->loginView->userWantsLogout()) {
            $this->loginView->logoutUser();
            $this->sessionsAndCookies->removeSessionsAndCookies();
            $reloading = true;
        }
        if (!$reloading) {
            $title = $this->memberView->getTitle();
            $body = $this->memberView->getMemberPage();
            $HTMLOutput = new \model\HTMLPage($title, $body);
            return $HTMLOutput;
        }
        else {
            \view\Navigation::reloadPage();
        }
        return new \model\HTMLPage();
    }
}