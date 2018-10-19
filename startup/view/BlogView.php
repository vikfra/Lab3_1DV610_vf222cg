<?php
    class BlogView {
        private static $blogContent = 'BlogView::BlogContent';

        public function response () {
            $response = $this->generateBlogHTML();
            return $response;

        }

        public function generateBlogHTML () {
            return '
                    <form action="?blog" method="post" enctype="multipart/form-data id="blogForm name="blogForm">
                        <input type="text" size="20" name="derp" id="" value="" />
                        <textarea rows="4" cols="50" id="Area" name="' . self::$blogContent . '"></textarea><br>
                        <input type="submit">
                    </form>';
        }

        public function getBlogPost () {
            return isset($_POST[self::$blogContent]);
        }
    }