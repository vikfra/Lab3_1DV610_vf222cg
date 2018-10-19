<?php
    namespace controller;

    class LogInController {
        private $view;
        private $layoutView;
        private $manager;

        public function __construct($view, $layoutView, \model\LogInManager $manager) {
            $this->view = $view;
            $this->layoutView = $layoutView;
            $this->manager = $manager;
        }
        public function initializeLogIn () {
            $username = $this->view->getRequestUserName();
            $password = $this->view->getRequestPassWord();
            $encryptedPassword = md5($password);

            if (isset($_COOKIE['CookieName']) && isset($_COOKIE['CookiePassword']) && !$this->view->userHasLogOut()) {
                $this->manager->authenticateLogIn($_COOKIE['CookieName'], $_COOKIE['CookiePassword'], false, true);
                

            } else if ($this->view->userHasLogIn() && !$this->view->userWillBeRemembered()) {
                setcookie('username', $username);

                if(isset($_COOKIE['username'])) {
                    $_COOKIE['username'] = $username;
                }

                $validLogIn = $this->manager->validateLogIn($username, $password);
                $authenticatedUser = $this->manager->authenticateLogIn($username, md5($password), false, false);

            } else if ($this->view->userWillBeRemembered()) {
                $validLogIn = $this->manager->validateLogIn($username, $password);
                $authenticatedUser = $this->manager->authenticateLogIn($username, md5($password), true, false);
                setcookie('CookieName', $username, time() + (86400 * 30));
                setcookie('CookiePassword', $encryptedPassword, time() + (86400 * 30));
                

            } else if ($this->view->userHasLogOut()) {
                $_SESSION['loggedIn'] = null;
                $_SESSION['refreshed'] = null;
                //session_destroy();
                unset($_COOKIE['username']);
                unset($_COOKIE['CookieName']);
                unset($_COOKIE['CookiePassword']);
                setcookie ('CookieName', '', time() - (86400 * 30));
                setcookie ('CookiePassword', '', time() - (86400 * 30));
                setcookie ('username', '', time() - (86400 * 30));
                
                $this->manager->message = 'Bye bye!';
            } 

        }
    }