<?php

//Show all errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

//Require neccesary classes
require("src/controller/MasterController.php");


$masterController = new \controller\MasterController();

$html = $masterController->runApplicationGetHTML();
    
echo $html;
