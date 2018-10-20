<?php
    namespace model;

    require_once('model/DBconnection.php');

    class BlogManager {
        public $blogPosts = array();

        public function addBlogPost ($username, $blogContent) {
            $conn = DatabaseHelper::DBconnection();
           
            $sql = "INSERT INTO blogposts (blog_creator, blog_content) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            $stmt->bind_param("ss", $username, $blogContent);
            $stmt->execute();

            $conn->close();
        }

        public function getBlogPosts () {
            $conn = DatabaseHelper::DBconnection();
            $sql = "SELECT * FROM blogposts ORDER BY blog_date DESC LIMIT 20";
            $stmt = mysqli_prepare($conn, $sql);
            $stmt->execute();
            $result = $stmt->get_result();


            if($result->num_rows) {
                while ($row = $result->fetch_assoc()) {
                    array_push($this->blogPosts, $row);
                }
            }

            $conn->close();
        }
    }