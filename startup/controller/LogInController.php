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

                $this->logInManager->message = 'Bye bye!';
            } 

        }

        public function cookieLogIn() {
            if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && !$this->logInView->userHasLogOut()) {
                return true;
            } else {
                return false;
            }
        }
    }