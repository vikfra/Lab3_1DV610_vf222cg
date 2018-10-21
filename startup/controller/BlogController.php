<?php
    namespace controller;

    class BlogController {
        private $blogView;
        private $layoutView;
        private $blogManager;
        private $logInManager;

        public function __construct(\view\BlogView $blogView, \view\LayoutView $layoutView, \model\BlogManager $blogManager, \model\LogInManager $logInManager) {
            $this->blogView = $blogView;
            $this->layoutView = $layoutView;
            $this->blogManager = $blogManager;
            $this->logInManager = $logInManager;

            if ($blogView->newBlogPostRequest()) {
                $this->insertBlogPost();
            }
            
            $this->getBlogPosts();
        }

        public function insertBlogPost(): void {
            $username = $this->logInManager->getUsername();
            $blogContent = $this->blogView->getBlogContent();
            $blogTitle = $this->blogView>getBlogTitle();
            
            if($username && $blogContent && $blogTitle) {
                $this->blogManager->addBlogPost($username, $blogContent, $blogTitle);

            }
        }

        public function getBlogPosts(): void {
            $this->blogManager->getBlogPosts();
        }
    }