<?php
    namespace model;

    require_once('model/DBconnection.php');

    class BlogManager {

        public function addBlogPost ($username, $blogContent) {
            $conn = DatabaseHelper::DBconnection();
           
            $sql = "INSERT INTO blogposts (blog_creator, blog_content) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            $stmt->bind_param("ss", $username, $blogContent);
            $stmt->execute();

        }
    }