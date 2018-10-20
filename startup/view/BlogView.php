<?php
    class BlogView {
        private static $blogContent = 'BlogView::BlogContent';
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
                    <form action="?blog" method="post" enctype="multipart/form-data id="blogForm name="blogForm">
                        <input type="text" name="blogTitle" placeholder="Title"><br>
                        <textarea rows="4" cols="50" id="Area" name="' . self::$blogContent . '"></textarea><br>
                        <input type="file" name="blogPic" accept="image/*">
                        <input type="submit">
                    </form>';
        }

        public function generateAllBlogs ($blogPosts) {
            $response = '<div>';

            foreach ($blogPosts as $value) {
                $response .= '<h1>' . $value['blog_title'] . '</h1>' . '<p>' . $value['blog_content'] . '</p>' . '<div>' . $value['blog_date'] . '</div>' . '<div>' . $value['blog_creator'] . '</div>';
            }
            $response .= '</div>';

            return $response;
        }

        public function getBlogPost () {
            return isset($_POST[self::$blogContent]);
        }

    }