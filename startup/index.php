<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/LogInManager.php');
require_once('controller/LogInController.php');
require_once('model/RegisterManager.php');
require_once('view/RegisterView.php');
require_once('controller/RegisterController.php');
require_once('model/BlogManager.php');
require_once('view/BlogView.php');
require_once('controller/BlogController.php');

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


//CREATE OBJECTS OF THE VIEWS
$dtv = new DateTimeView();
$logInManager = new \model\LogInManager();
$v = new LoginView($logInManager);
$lv = new LayoutView($logInManager);
$app = new \controller\LogInController($v, $lv, $logInManager);

$app->initializeLogIn();


if (isset($_GET['register'])) {
    $registerManager = new \model\RegisterManager();
    $rv = new RegisterView($registerManager);
    $rc = new \controller\RegisterController($rv, $lv, $registerManager);
    $rc->initializeRegistration();
    $lv->render(false, $rv, $dtv);

} else if (isset($_GET['blog'])) {
    $blogManager = new \model\BlogManager();
    $bv = new BlogView($blogManager);
    $bc = new \controller\BlogController($bv, $lv, $blogManager);
    $bc->initializeBlogPost();
    $lv->render(false, $bv, $dtv);

} else {
    $lv->render(false, $v, $dtv);
}