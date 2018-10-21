<?php

//INCLUDE THE FILES NEEDED...
require_once('controller/MainController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
$cookieParams = session_get_cookie_params();
$ID = session_id();
setcookie('PHPSESSID', $ID, 0, $cookieParams['path'], $cookieParams['domain'], true);
if(!isset($_SESSION['browser'])) {
    $_SESSION['browser'] = $_SERVER['HTTP_USER_AGENT'];
} 

$mainController = new \controller\MainController();

