<?php
    namespace model;

    class DatabaseHelper {
  
        
        public static function DBconnection() {
            $servername = "localhost";
            $username = "cruduser";
            $password = "user123";
            $dbname = 'lab3_1dv610_vf222cg';

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            echo "Connected successfully";
            return $conn;
        }
    }     