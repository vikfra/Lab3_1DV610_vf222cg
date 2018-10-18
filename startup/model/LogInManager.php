<?php
    namespace model;
    
    require_once('model/DBconnection.php');

    class LogInManager {
        public $loggedIn = false;
        public $message;

        public function authenticateLogIn($username, $password, $willBeRemembered, $encryptedPassword) {
            if(isset($_SESSION['browser']) && $_SESSION['browser'] !== $_SERVER['HTTP_USER_AGENT']) {
                $this->message = '';
                $_SESSION['loggedIn'] = null;
                $this->loggedIn = null;
                session_destroy();
                header('Location: /Lab3_1DV610_vf222cg/startup/');
            }
            else if ($username == 'Admin' && $password == 'Password' && $willBeRemembered == false && $encryptedPassword == false) {
                //Börja här
                $this->loggedIn = true;
                $_SESSION['loggedIn'] = true;
                $this->message = 'Welcome';

            } else if ($username == 'Admin' && $password == md5('Password') && $willBeRemembered == false && $encryptedPassword == true) {
                $this->loggedIn = true;
                $_SESSION['loggedIn'] = true;
                $this->message = 'Welcome back with cookie';

            } else if ($username == 'Admin' && $password !== md5('Password') && $encryptedPassword == true) {
                $this->message = 'Wrong information in cookies';
                $this->loggedIn = null;
                $_SESSION['loggedIn'] = null;

                unset($_COOKIE['username']);
                unset($_COOKIE['CookieName']);
                unset($_COOKIE['CookiePassword']);
                setcookie ('CookieName', '', time() - (86400 * 30));
                setcookie ('CookiePassword', '', time() - (86400 * 30));
                setcookie ('username', '', time() - (86400 * 30));

            } else if ($username == 'Admin' && $password == 'Password' && $willBeRemembered == true && $encryptedPassword == false) {
                $this->loggedIn = true;
                $_SESSION['loggedIn'] = true;
                $this->message = 'Welcome and you will be remembered';

            } else if ($username && $password) {
                $this->message = 'Wrong name or password';
            } 
        }

        public function validateLogIn ($username, $password) {
            if (empty($username)) {
                $this->message = 'Username is missing';
            } else if (empty($password)) {
                $this->message = 'Password is missing';
            } 
        }

        public function hasAuthUser () {

        }
    }