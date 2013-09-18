<?php

    //Show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();
    
    //Require neccesary classes
    require_once("src/view/dateAndTime.php");
    require_once("src/view/HTMLPage.php");
    require_once("src/view/loginHandler.php");
    
    $dateAndTime = new \view\dateAndTime();
    $HTMLPage = new \view\HTMLPage();
    $loginHandler = new \view\loginHandler();
    
    
    if (isset($_SESSION['userId'])) {
        $loginHandler->setUserId($_SESSION['userId']);
    }
    
    //Used for login-messages and status-messages
    $message = "";
    
    //Take care of login atempt
    if (isset($_POST['login_atempt']) && !$loginHandler->loggedIn()) {
        $message = $loginHandler->tryLogin($_POST['username'], $_POST['password']);
        //Successful login
        if ($loginHandler->loggedIn()) {
            $_SESSION['userId'] = $loginHandler->getUserId();
        } //Unsuccessful login
    }
    
    //Take care of sign out requests
    
    if (isset($_GET['logout'])) {
        $message = $loginHandler->logOut();
        unset($_SESSION['userId']);
    }
    
    
    
    //Not logged in
    if (!$loginHandler->loggedIn()) {
        echo $HTMLPage->getHTMLPage("Laboration 1 - 1DV408", "
        <h1>Välkommen</h1>
        <p class=\"errorMsg\">$message</p>
        ".$loginHandler->getForm()
        , $dateAndTime->getString(new \model\dateAndTime()));
    } //Logged in
    else {
        echo $HTMLPage->getHTMLPage("Laboration 1 - 1DV408", "
        <h1>" . $loginHandler->getUsername() . " är inloggad!</h1>
        <p class=\"loginMessage\">$message</p>
        <a href=\"?logout=1\">Logga ut</a>
        ", $dateAndTime->getString(new \model\dateAndTime()));
    }
?>

