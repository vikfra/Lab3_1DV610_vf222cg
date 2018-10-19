<?php
    namespace model;

    require_once('model/DBconnection.php');

    class LogInManager {
        public $loggedIn = false;
        public $message;

        public function authenticateLogIn($username, $password, $willBeRemembered, $authWithCookie) {
            if ($this->isAuthenticated($username, $password)) {
                $this->loggedIn = true;
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                $this->setWelcomeMsg($authWithCookie, $willBeRemembered);

            } else {
                // Kan vara fel, Om Admin är rätt och pw fel.
                $this->setErrorMsg($authWithCookie, $willBeRemembered);
                $this->loggedIn = null;
                $_SESSION['loggedIn'] = null;
                $this->unsetCookies();
            }
        }

        public function validateLogIn ($username, $password) {
            if (empty($username)) {
                $this->message = 'Username is missing';
            } else if (empty($password)) {
                $this->message = 'Password is missing';
            } 
        }

        public function isAuthenticated($username, $password) {
            if ($this->hasAuthUser($username, $password) || $this->hasAuthAdmin($username, $password)) {
                return true;
            } else {
                return false;
            }
        }

        public function hasAuthUser ($username, $password) {
            if($this->isSessionHijacked()) {
                return false;
            }
    
            $conn = DatabaseHelper::DBconnection();
            $sql = "SELECT * FROM users WHERE username=? and password=?";
            $stmt = mysqli_prepare($conn, $sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows == 1) {
                echo 'Logged in!';
                return true;
            } else {
                echo 'Not Logged in';
                return false;
            }

            $stmt->close();
            mysqli_close($conn);
        }

        public function hasAuthAdmin ($username, $password) {
            if($this->isSessionHijacked()) {
                return false;
            } else if($username == 'Admin' && $password == 'Password') {
                return true;
            } else if ($username == 'Admin' && $password == md5('Password')) {
                return true;
            } else {
                return false;
            }
        }

        public function isSessionHijacked() {
            if(isset($_SESSION['browser']) && $_SESSION['browser'] !== $_SERVER['HTTP_USER_AGENT']) {
                $this->message = '';
                $_SESSION['loggedIn'] = null;
                $this->loggedIn = null;
                session_destroy();
                header('Location: /Lab3_1DV610_vf222cg/startup/'); ///Flytta till controller
                return true;
            } else {
                return false;
            }
        }

        public function setWelcomeMsg ($authWithCookie, $willBeRemembered) {
            
            if ($willBeRemembered == true) {
                $this->message = 'Welcome and you will be remembered';
            } else if($authWithCookie == false) {
                $this->message = 'Welcome';
            } else {
                $this->message = 'Welcome back with cookie';
            }
        }

        public function setErrorMsg($authWithCookie, $willBeRemembered) {
            if ($authWithCookie == true) {
                $this->message = 'Wrong information in cookies';
            } else {
                $this->message = 'Wrong name or password';
            }
        }

        public function unsetCookies () {
            unset($_COOKIE['username']);
            unset($_COOKIE['CookieName']);
            unset($_COOKIE['CookiePassword']);
            setcookie ('CookieName', '', time() - (86400 * 30));
            setcookie ('CookiePassword', '', time() - (86400 * 30));
            setcookie ('username', '', time() - (86400 * 30));
        }
    }