<?php
    namespace view;

    class LayoutView {

        private $manager;

        public function __construct($manager) {
          $this->manager = $manager;
        }
        
        public function render($isLoggedIn, $view, DateTimeView $dtv) {
          echo '<!DOCTYPE html>
            <html>
              <head>
                <meta charset="utf-8">
                <title>Login Example</title>
              </head>
              <body>
                <h1>Assignment 3</h1>
                ' . $this->renderIsLoggedIn($isLoggedIn, $view) . '
                <div class="container">
                  <div=class"header">' 
                    . $this->generateBlogFeedButtonHTML($isLoggedIn) 
                    . $this->generateCreateBlogButtonHTML($isLoggedIn) 
                  . '</div>
                    ' . $view->response() . '
                    
                    ' . $dtv->show() . '
                </div>
              </body>
            </html>
          ';
        }
        
        private function renderIsLoggedIn($isLoggedIn, $view) {
          if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
          }
          else {
            return $view->getButton() . '<h2>Not logged in</h2>';
          }
        }

        private function generateCreateBlogButtonHTML($isLoggedIn) {
          if($isLoggedIn) {
            return "<a href='?createBlog'>Create new blog post</a>";
          } else {
            return '';
          }

        }

        private function generateBlogFeedButtonHTML($isLoggedIn) {
          if($isLoggedIn) {
            return "<a href='?blog'>Check all blog posts</a>";
          } else {
            return '';
          }
        }

        public function hasRegistration () {
          if(isset($_GET['register'])) {
              return true;
          } else {
              return false;
          }
        }

        public function hasCheckBlogPosts () {
          if(isset($_GET['blog'])) {
              return true;
          } else {
              return false;
          }
      }

      public function hasCreateBlogPosts () {
        if(isset($_GET['createBlog'])) {
            return true;
        } else {
            return false;
        }
    }
    }
