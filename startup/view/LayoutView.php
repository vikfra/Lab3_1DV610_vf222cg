<?php


class LayoutView {

  private $manager;

  public function __construct($manager) {
    $this->manager = $manager;
  }
  
  public function render($isLoggedIn, $v, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 3</h1>
          ' . $this->renderIsLoggedIn(isset($_SESSION['loggedIn']), $v) . '
          <div class="container">
            <div=class"header">' . $this->generateBlogFeedButtonHTML(isset($_SESSION['loggedIn'])) . $this->generateCreateBlogButtonHTML(isset($_SESSION['loggedIn'])) . '</div>
              ' . $v->response() . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn, $v) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return $v->getButton() . '<h2>Not logged in</h2>';
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
}
