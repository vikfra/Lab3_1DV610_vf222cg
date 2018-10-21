<?php
    namespace view;

    class BlogView {
        private static $blogContent = 'BlogView::BlogContent';
        private static $blogTitle = 'BlogView::BlogTitle';
        private static $blog = 'BlogView::Blog';
        private static $createBlogPost = 'BlogView::CreateBlogPost';

        private $manager;

        public function __construct(\model\BlogManager $manager) {
            $this->manager = $manager;
        }

        public function response (): string {
            $response = $this->getBackButton();
            if (isset($_GET[self::$blog])) {
                $blogPosts = $this->manager->blogPosts;
                $response .= $this->generateAllBlogs($blogPosts);

            } else if (isset($_GET[self::$createBlogPost])) {
                $response .= $this->generateCreateBlogHTML();
            }

            return $response;

        }

        public function generateCreateBlogHTML (): string {
            return '
                    <form action="?' . self::$blog . '&' . self::$createBlogPost . '" method="post" enctype="multipart/form-data" id="blogForm name="blogForm">
                        <input type="text" name="' . self::$blogTitle . '" placeholder="Title"><br>
                        <textarea rows="4" cols="50" id="Area" name="' . self::$blogContent . '"></textarea><br>
                        <input type="file" name="blogPic" accept="image/*">
                        <input type="submit">
                    </form>';
        }

        public function generateAllBlogs ($blogPosts): string {
            $response = '<div>';
            
            foreach ($blogPosts as $blogPost) {
                $response .= '<h1>' . $blogPost['blog_title'] . '</h1>' . '<img src="data:image/png;base64, '.base64_encode($blogPost['blog_img']).'" />' . '<p>' . $blogPost['blog_content'] . '</p>' . '<div>' . $blogPost['blog_date'] . '</div>' . '<div>' . $blogPost['blog_creator'] . '</div>';
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

        public function newBlogPostRequest (): bool {
            if(isset($_GET[self::$createBlogPost])) {
                return true;
            } else {
                return false;
            }
        }

        public function getBackButton () {
            return "<a href='?'>Back to My Page</a>";
        }
    }