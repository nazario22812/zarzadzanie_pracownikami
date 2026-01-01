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

            
            return $this->db->insert($sql);
        }
        public function getUserByUsername($username) {
            $mysqli = $this->db->getMysqli();
            $username = $mysqli->real_escape_string($username);
        
            $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        
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
        
        public function getUserId($username) {
            $mysqli = $this->db->getMysqli();
            $username = $mysqli->real_escape_string($username);
            $sql = "SELECT id FROM users WHERE username = '$username'";
            $result = $mysqli->query($sql);

            if ($row = $result->fetch_assoc()) {
                return (int)$row['id']; 
            }

            return null; 
         }

        public function getUserByPhone($phone) {
            $mysqli = $this->db->getMysqli();
            $phone = $mysqli->real_escape_string($phone);
        
            $sql = "SELECT * FROM users WHERE phone = '$phone' LIMIT 1";
        
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

        public function getUserById($id) {
            $mysqli = $this->db->getMysqli();
            $id = $mysqli->real_escape_string($id);

            $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";

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

        public function updatePassword($phone, $newPassword) {
            $mysqli = $this->db->getMysqli();
            $phone = $mysqli->real_escape_string($phone);
    
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
            $sql = "UPDATE users SET password = '$hashedPassword' WHERE phone = '$phone'";
    
            return $this->db->insert($sql); 
        }

        public function getUserStatus($username) {
            $mysqli = $this->db->getMysqli();
            $username = $mysqli->real_escape_string($username);
        
            $sql = "SELECT status FROM users WHERE username = '$username' LIMIT 1";
        
            $result = $mysqli->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                return $row['status'];
            }
            return null;
        }
        public function getUserStatusById($id) {
            $mysqli = $this->db->getMysqli();
            $id = (int)$id;
        
            $sql = "SELECT status FROM users WHERE id = $id LIMIT 1";
        
            $result = $mysqli->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                return $row['status'];
            }
            return null;
        }

        public function getUserData($username) {
            $mysqli = $this->db->getMysqli();
            $username = $mysqli->real_escape_string($username);
        
            $sql = "SELECT date FROM users WHERE username = '$username' LIMIT 1";
        
            $result = $mysqli->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                return $row['date'];
            }
            return null;
        }

        public function getAllUsers() {
            $mysqli = $this->db->getMysqli();
            $sql = "SELECT * FROM users";
            $result = $mysqli->query($sql);
            $users = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row; 
                }
            }
            return $users;
        }

        public function updateUserEmail($id, $newEmail) {
            $mysqli = $this->db->getMysqli();
            $id = (int)$id; // Переконуємось, що це число
            $newEmail = $mysqli->real_escape_string($newEmail);

            $sql = "UPDATE users SET email = '$newEmail' WHERE id = $id";

            return $mysqli->query($sql); 
        }

        public function updateUserPhone($id, $newPhone) {
            $mysqli = $this->db->getMysqli();
            $id = (int)$id;
            $newPhone = $mysqli->real_escape_string($newPhone);

            $sql = "UPDATE users SET phone = '$newPhone' WHERE id = $id";

            return $mysqli->query($sql);
        }

        public function updateUserStatus($id, $newStatus) {
            $mysqli = $this->db->getMysqli();
            $id = (int)$id;
            $newStatus = (int)$newStatus;

            $sql = "UPDATE users SET status = $newStatus WHERE id = $id";

            return $mysqli->query($sql);
        }
    };

?>