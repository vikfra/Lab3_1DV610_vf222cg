<?php
    namespace model;

    require_once('model/DBconnection.php');

    class BlogManager {
        public $blogPosts = array();

        public function addBlogPost (string $username, string $blogContent, string $blogTitle): void {
            $conn = DatabaseHelper::DBconnection();
        
            if($this->hasImage()) {
                $img = file_get_contents ($_FILES['blogPic']['tmp_name']);

                $sql = "INSERT INTO blogposts (blog_title, blog_creator, blog_content, blog_img) VALUES (?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);
                $stmt->bind_param("ssss", $blogTitle, $username, $blogContent, $img);

            } else {
                $sql = "INSERT INTO blogposts (blog_title, blog_creator, blog_content) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                $stmt->bind_param("sss", $blogTitle, $username, $blogContent);
                
            }

            $stmt->execute();
            $conn->close();
        }

        public function getBlogPosts (): void {
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

        public function hasImage (): bool {
            $imageSize = getimagesize($_FILES["blogPic"]["tmp_name"]);

            if($imageSize !== false) {
                return true;
            } else {
                return false;
            }
        }
    }