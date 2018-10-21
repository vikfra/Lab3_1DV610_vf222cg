<?php
    namespace controller;
    
    class RegisterController {
        private $registerView;
        private $layoutView;
        private $registerManager;

        public function __construct(\view\RegisterView $registerView, \view\LayoutView $layoutView, \model\RegisterManager $registerManager) {
            $this->registerView = $registerView;
            $this->layoutView = $layoutView;
            $this->registerManager = $registerManager;

            if ($registerView->registrationRequest()) {
                $this->initializeRegistration();
            }
        }

        public function initializeRegistration (): void {
            $username = $this->registerView->getRequestUserName();
            $password = $this->registerView->getRequestPassWord();
            $passwordRepeat = $this->registerView->getRequestPassWordRepeat();

            if($username && $password && $passwordRepeat) {
                if($password == $passwordRepeat) {
                    $this->registerManager->insertUser($username, $password);
                    header('Location: /Lab3_1DV610_vf222cg/startup/');
                }
            }
        }
    }