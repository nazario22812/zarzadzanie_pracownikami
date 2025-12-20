<?php
    require_once '../app/models/Baza.php';

    class UserRepository {
        private $db;

        public function __construct() {
            $this->db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
        }
        public function addUser($user) {
            $mysqli = $this->db->getMysqli();

            $username   = $mysqli->real_escape_string($user->getUserName());
            $first_name = $mysqli->real_escape_string($user->getFirstName());
            $last_name  = $mysqli->real_escape_string($user->getLastName());
            $age        = $mysqli->real_escape_string($user->getWiek());
            $phone      = $mysqli->real_escape_string($user->getPhone());
            $email      = $mysqli->real_escape_string($user->getEmail());
            $password   = $mysqli->real_escape_string($user->getPasswd());
            $data = $mysqli->real_escape_string($user->getDate());
            $status     = $mysqli->real_escape_string($user->getStatus());
            $sql = "
                INSERT INTO users (username, first_name, last_name, age, phone, password, email, `date`, status)
                VALUES ('$username', '$first_name', '$last_name', $age, '$phone','$password', '$email', '$data', '$status')
            ";

            // var_dump($sql);
            // exit;
            return $this->db->insert($sql);
        }
    }
?>