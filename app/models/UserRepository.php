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
        public function getUserByUsername($username) {
            $mysqli = $this->db->getMysqli();
            $username = $mysqli->real_escape_string($username);
        
            $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        
            // Twoja Baza::select zwraca HTML, więc musimy pobrać dane bezpośrednio z mysqli
            $result = $mysqli->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                require_once '../app/models/User.php';
                $user = new User(
                    $row['username'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['age'],
                    $row['phone'],
                    $row['email'],
                    $row['password'],
                    true
                );
           
                return $user;
            }
            return null;
        }
        
        public function getUserByPhone($phone) {
            $mysqli = $this->db->getMysqli();
            $phone = $mysqli->real_escape_string($phone);
        
            $sql = "SELECT * FROM users WHERE phone = '$phone' LIMIT 1";
        
            // Twoja Baza::select zwraca HTML, więc musimy pobrać dane bezpośrednio z mysqli
            $result = $mysqli->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                require_once '../app/models/User.php';
                $user = new User(
                    $row['username'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['age'],
                    $row['phone'],
                    $row['email'],
                    $row['password'],
                    true
                );
           
                return $user;
            }
            return null;
        }
    };

?>