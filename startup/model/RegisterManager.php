<?php
    namespace model;

    require_once('model/DBconnection.php');

    class RegisterManager {
        public $username = '';

        public function ConnectToDatabase () {
            $database = new \model\DatabaseHelper();
            $conn = $database->DBconnection();

            return $conn;
        }

        public function insertUser (string $username, string $password): void {
            $conn = $this->ConnectToDatabase();
            
            $sql = "INSERT INTO users VALUES (?, ?)";
            
            $stmt = mysqli_prepare($conn, $sql);
            $stmt->bind_param("ss", $username, md5($password));
            $stmt->execute();

        }
    }