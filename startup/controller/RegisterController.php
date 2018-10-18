<?php
    namespace controller;
    
    class RegisterController {
        private $view;
        private $layoutView;
        private $manager;

        public function __construct($view, $layoutView, \model\RegisterManager $manager) {
            $this->view = $view;
            $this->layoutView = $layoutView;
            $this->manager = $manager;
        }

        public function initializeRegistration () {
            $username = $this->view->getRequestUserName();
            $password = $this->view->getRequestPassWord();
            $passwordRepeat = $this->view->getRequestPassWordRepeat();

            if($username && $password && $passwordRepeat) {
                if($password == $passwordRepeat) {
                    echo 'correct';
                    $this->manager->insertUser($username, $password);
                    header('Location: /Lab3_1DV610_vf222cg/startup/');
                }
            }
        }

    }