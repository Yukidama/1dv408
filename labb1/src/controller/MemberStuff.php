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
     * constructor which takes objects and set them as member variables
     * @param \model\Login $aLoginModel
     * @param \view\Login $aLoginView
     * @param \view\MessageHolder $aMessageHolder
     */
    public function __construct(\model\Login            $aLoginModel,
                                \view\Login             $aLoginView,
                                \view\MessageHolder     $aMessageHolder) {
        
        $this->loginModel = $aLoginModel;
        $this->loginView = $aLoginView;
        $this->messageHolder = $aMessageHolder;
    }
    
    /**
     * Check if user wants to logout and returns html
     * @return String HTML
     */
    public function loggedInPage() {
        $this->memberView = new \view\memberView($this->loginView,
                                                 $this->messageHolder);
        
        $reloading = false;
        
        if ($this->loginView->userWantsLogout()) {
            $this->loginView->logoutUser();
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