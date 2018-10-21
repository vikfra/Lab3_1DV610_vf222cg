<?php

    namespace controller;

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

    class MainController {
        private $logInManager;
        private $dateTimeView;
        private $layoutView;

        public function __construct () {
            $this->logInManager = new \model\LogInManager();
            $this->dateTimeView = new \view\DateTimeView();
            $this->layoutView = new \view\LayoutView($this->logInManager);

            $isLoggedIn = $this->logInManager->isLoggedIn();

            if ($this->layoutView->hasRegistration()) {
                $this->runRegistrationMVC();

            } else if ($this->layoutView->hasCheckBlogPosts() || $this->layoutView->hasCreateBlogPosts() && $isLoggedIn) {
                $this-runBlogPostMVC();

            } else {
                $this->runLogInMVC();
            }
        }

        public function runRegistrationMVC () {
            $registerManager = new \model\RegisterManager();
            $registerView = new \view\RegisterView($registerManager);
            $registerController = new \controller\RegisterController($registerView, $this->layoutView, $registerManager);

            $registerController->initializeRegistration();

            $this->layoutView->render($isLoggedIn, $registerView, $this->dateTimeView);
        }

        public function runBlogPostMVC () {
            $blogManager = new \model\BlogManager();
            $blogView = new \view\BlogView($blogManager);
            $blogController = new \controller\BlogController($blogView, $this->layoutView, $blogManager);

            $blogController->initializeBlogPost();
            $blogController->getBlogPostArray();

            $this->layoutView->render($isLoggedIn, $blogView, $this->dateTimeView);
        }

        public function runLogInMVC () {
            $logInView = new \view\LoginView($this->logInManager);
            $logInController = new \controller\LogInController($logInView, $this->layoutView, $this->logInManager);

            $logInController->initializeLogIn();
            $isLoggedIn = $this->logInManager->isLoggedIn();

            $this->layoutView->render($isLoggedIn, $logInView, $this->dateTimeView);
        }
    }