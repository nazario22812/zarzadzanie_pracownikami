<?php
    require_once '../app/helpers/funkcje.php';
    require_once '../app/models/UserRepository.php';

    class UserController {
        public function details(){
            if (isset($_GET['id'])) {
                $userId = (int)$_GET['id']; 
        
                $ur = new UserRepository();
                $userData = $ur->getUserById($userId); 
                

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_type'])) {
                    $id = (int)$_POST['userId'];
                    $type = $_POST['update_type'];

                    if ($type === 'email' && !empty($_POST['newEmail'])) {
                        $newEmail = filter_input(INPUT_POST, 'newEmail', FILTER_VALIDATE_EMAIL);
                        if (!$newEmail) {
                            echo "<script>alert('Błędny format adresu e-mail.'); window.history.back();</script>";
                            exit;
                        }
                        $ur->updateUserEmail($id, $newEmail);

                    } elseif ($type === 'phone' && !empty($_POST['newPhone'])) {
                        $phone = filter_input(INPUT_POST, 'newPhone', FILTER_VALIDATE_REGEXP, [
                            'options' => ['regexp' => '/^\+?[0-9\s\-]{7,20}$/']
                        ]);

                        if (!$phone) {
                            echo "<script>alert('Proszę podać poprawny numer telefonu.'); window.history.back();</script>";
                            exit;
                        }
                        $ur->updateUserPhone($id, $phone);

                    } elseif ($type === 'status' && isset($_POST['newStatus'])) {
                        $ur->updateUserStatus($id, $_POST['newStatus']);
                    }

                    header("Location: ?page=user_details&id=" . $id);
                    exit;
                }

                $targetUser = null;
                if (isset($_GET['id'])) {
                    $userId = (int)$_GET['id'];
                    $targetUser = $ur->getUserById($userId); 
                }


                if ($userData) {
                    require '../app/views/layout/header_back.php';
                    require '../app/views/userdetails.php'; 
                    require '../app/views/layout/footer.php';
                } else {
                echo "Uzytkownik nie znaleziony!";
                }
            } else {
                echo "ID korzystwania nie wskazano!";
            }
        }
    };
?>