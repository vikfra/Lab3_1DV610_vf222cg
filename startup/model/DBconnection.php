<?php
    namespace model;

    class DatabaseHelper {
        
        public static function DBconnection() {
/*             $servername = "localhost";
            $username = "cruduser";
            $password = "user123";
            $dbname = 'lab3_1dv610_vf222cg'; */
            $servername = "localhost";
            $username = "id7287948_users";
            $password = "user123";
            $dbname = 'id7287948_lab31dv610';

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            return $conn;
        }
    }     