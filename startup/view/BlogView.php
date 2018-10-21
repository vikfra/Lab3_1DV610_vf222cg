<?php
    namespace view;

    class BlogView {
        private static $blogContent = 'BlogView::BlogContent';
        private static $blogTitle = 'BlogView::BlogTitle';

        private $manager;

        public function __construct($manager){
            $this->manager = $manager;
        }

        public function response () {

            if (isset($_GET['blog'])) {
                $blogPosts = $this->manager->blogPosts;
                $response = $this->generateAllBlogs($blogPosts);
            } else if (isset($_GET['createBlog'])) {
                $response = $this->generateCreateBlogHTML();
            }

            return $response;

        }

        public function generateCreateBlogHTML () {
            return '
                    <form action="?blog&addBlogPostConfirmed" method="post" enctype="multipart/form-data" id="blogForm name="blogForm">
                        <input type="text" name="' . self::$blogTitle . '" placeholder="Title"><br>
                        <textarea rows="4" cols="50" id="Area" name="' . self::$blogContent . '"></textarea><br>
                        <input type="file" name="blogPic" accept="image/*">
                        <input type="submit">
                    </form>';
        }

        public function generateAllBlogs ($blogPosts) {
            $response = '<div>';
            
            foreach ($blogPosts as $value) {
                $response .= '<h1>' . $value['blog_title'] . '</h1>' . '<img src="data:image/png;base64, '.base64_encode($value['blog_img']).'" />' . '<p>' . $value['blog_content'] . '</p>' . '<div>' . $value['blog_date'] . '</div>' . '<div>' . $value['blog_creator'] . '</div>';
            }
            $response .= '</div>';

            return $response;
        }

        public function getBlogContent () {
            if(isset($_POST[self::$blogContent])) {
                return $_POST[self::$blogContent];
            } else {
                return false;
            }
        }

        public function getBlogTitle () {
            if(isset($_POST[self::$blogTitle])) {
                return $_POST[self::$blogTitle];
            } else {
                return false;
            }
        }

        public function newBlogPostRequest () {
            if(isset($_GET['addBlogPostConfirmed'])) {
                return true;
            } else {
                return false;
            }
        }



    }