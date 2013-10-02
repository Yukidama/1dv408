<?php

namespace controller;

//Require nessesary classes
require("src/controller/Login.php");
require("src/controller/MemberStuff.php");

require("src/model/HTMLPage.php");
require("src/view/HTMLPage.php");

require("src/model/Login.php");
require("src/view/Login.php");

require("src/model/DateAndTime.php");
require("src/view/DateAndTime.php");

require("src/view/Navigation.php");

require("src/view/MessageHolder.php");


class MasterController {
    
    /**
     * @var \view\HTMLPage
     */
    private $HTMLPage;
    
    /**
     * @var \view\Login
     */
    private $loginView;
    
    /**
     * @var \model\Login
     */
    private $loginModel;
    
    /**
     * @var \view\MessageHolder
     */
    private $messageHolder;
    
    /**
     * constructor which creates object needed
     */
    public function __construct() {
        $this->loginModel = new \model\Login();
        $this->messageHolder = new \view\MessageHolder();
        
        $this->loginView = new \view\Login($this->loginModel,
                                           $this->messageHolder);
        
        $this->HTMLPage = new \view\HTMLPage();
    }
    
    /**
     * Main function to run the whole application
     * @return String HTML
     */
    public function runApplicationGetHTML() {

        //Try to find session-cookie for user
        $this->loginView->trySessionCookieLogin();
        
        $HTMLOutput = new \model\HTMLPage();
            
        if ($this->loginModel->isLoggedIn()) {
            $memberController = new \controller\MemberStuff($this->loginModel,
                                                            $this->loginView,
                                                            $this->messageHolder);
            $HTMLOutput = $memberController->loggedInPage();
            //User is logged in
        }
        else {
            $loginController = new \controller\Login($this->loginModel,
                                                     $this->loginView);
            $HTMLOutput = $loginController->loginPage();
            //User is not logged in
        }      
        $dateAndTime = new \view\dateAndTime(new \model\dateAndTime());   
        //Adds the dateAndTime to the footer
        $HTMLOutput->setFooter($dateAndTime->getString(), true);   
        return $this->HTMLPage->getHTMLPage($HTMLOutput);
    }
}
