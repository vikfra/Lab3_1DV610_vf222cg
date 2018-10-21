<?php
    namespace controller;

    class LogInController {
        private $logInView;
        private $layoutView;
        private $logInManager;

        public function __construct(\view\LogInView $logInView, \view\LayoutView $layoutView, \model\LogInManager $logInManager) {
            $this->logInView = $logInView;
            $this->layoutView = $layoutView;
            $this->logInManager = $logInManager;
            
            $this->initializeSession();
        }

        public function initializeSession() {
            session_start();

            $cookieParams = session_get_cookie_params();
            $ID = session_id();

            setcookie('PHPSESSID', $ID, 0, $cookieParams['path'], $cookieParams['domain'], true);

            if(!isset($_SESSION['browser'])) {
                $_SESSION['browser'] = $_SERVER['HTTP_USER_AGENT'];
            } 
        }

        public function initializeLogIn (): void {
            $username = $this->logInView->getRequestUserName();
            $password = $this->logInView->getRequestPassWord();
            $hashedPassword = $this->logInManager->hashPassword($password);

            $userWillBeRemembered = $this->logInView->userWillBeRemembered();
            $logInWithCookie = $this->cookieLogIn();

            if ($logInWithCookie) {
                $username = $this->logInView->getUsernameCookie();
                $hashedPassword = $this->logInView->getPasswordCookie();

                $this->logInManager->authenticateLogIn($username, $hashedPassword, $userWillBeRemembered, $logInWithCookie);

            } else if ($this->logInView->userHasLogIn() && !$userWillBeRemembered) {
                $authenticatedUser = $this->logInManager->authenticateLogIn($username, $password, $userWillBeRemembered, $logInWithCookie);

            } else if ($userWillBeRemembered) {
                $authenticatedUser = $this->logInManager->authenticateLogIn($username, $password, $userWillBeRemembered, $logInWithCookie);

                $this->logInManager->rememberUser($username, $hashedPassword);

            } else if ($this->logInView->userHasLogOut()) {
                $this->logInManager->destroySession();
                $this->logInView->unsetCookie();

            } 
        }

        public function cookieLogIn(): bool {
            $hasUsernameCookie = $this->logInView->hasUsernameCookie();
            $hasPasswordCookie = $this->logInView->hasPasswordCookie();

            if ($hasUsernameCookie && $hasPasswordCookie && !$this->logInView->userHasLogOut()) {
                return true;
            } else {
                return false;
            }
        }
    }