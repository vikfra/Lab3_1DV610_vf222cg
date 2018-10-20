<?php
    class BlogView {
        private static $blogContent = 'BlogView::BlogContent';
        private $manager;

        public function __construct($manager){
            $this->manager = $manager;
        }

        public function response () {
            $response = $this->generateBlogHTML();
            $blogPosts = $this->manager->blogPosts;
            $response .= $this->generateAllBlogs($blogPosts);
            return $response;

        }

        public function generateBlogHTML () {
            return '
                    <form action="?blog" method="post" enctype="multipart/form-data id="blogForm name="blogForm">
                        <textarea rows="4" cols="50" id="Area" name="' . self::$blogContent . '"></textarea><br>
                        <input type="submit">
                    </form>';
        }

        public function generateAllBlogs ($blogPosts) {
            $response = '<div>';

            foreach ($blogPosts as $value) {
                $response .= '<h1>' . $value['blog_creator'] . '</h1>' . '<p>' . $value['blog_content'] . '</p>' . '<p>' . $value['blog_date'] . '</p>';
            }
            $response .= '</div>';

            return $response;
        }

        public function getBlogPost () {
            return isset($_POST[self::$blogContent]);
        }
    }