<?php
    namespace controller;

    class BlogController {
        private $view;
        private $layoutView;
        private $manager;

        public function __construct($view, $layoutView, \model\BlogManager $manager) {
            $this->view = $view;
            $this->layoutView = $layoutView;
            $this->manager = $manager;
        }

        //Byt namn flytta på Post och Session-variabel
        public function initializeBlogPost () {
            $username = $_SESSION['username'];
            $blogContent = $this->view->getBlogPost();

            if($username && $blogContent) {
                $this->manager->addBlogPost($username, $_POST['BlogView::BlogContent'], $_POST['blogTitle']);

            }
        }

        public function getBlogPostArray () {
            $this->manager->getBlogPosts();
        }
    }