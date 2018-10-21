<?php
    namespace view;

    class LayoutView {

        private $manager;
        private static $blog = 'BlogView::Blog';
        private static $createBlogPost = 'BlogView::CreateBlogPost';
        private static $register = 'register';

        public function __construct(\model\LogInManager $manager) {
          $this->manager = $manager;
        }
        
        public function render(bool $isLoggedIn, $view, DateTimeView $dtv) {
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
        
        private function renderIsLoggedIn(bool $isLoggedIn, $view): string {
          if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
          }
          else {
            return $view->getButton() . '<h2>Not logged in</h2>';
          }
        }

        private function generateCreateBlogButtonHTML(bool $isLoggedIn): string {
          if($isLoggedIn) {
            return "<a href='?" . self::$createBlogPost . "'>Create new blog post</a>";
          } else {
            return '';
          }

        }

        private function generateBlogFeedButtonHTML(bool $isLoggedIn): string {
          if($isLoggedIn) {
            return "<a href='?" . self::$blog . "'>Check all blog posts</a>";
          } else {
            return '';
          }
        }

        public function hasRegistration (): bool {
          if(isset($_GET[self::$register])) {
              return true;
          } else {
              return false;
          }
        }

        public function hasCheckBlogPosts (): bool {
          if(isset($_GET[self::$blog])) {
              return true;
          } else {
              return false;
          }
      }

      public function hasCreateBlogPosts (): bool {
        if(isset($_GET[self::$createBlogPost])) {
            return true;
        } else {
            return false;
        }
    }
    }
