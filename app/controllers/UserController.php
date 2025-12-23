<?php
    require_once '../app/helpers/funkcje.php';
    require_once '../app/models/UserRepository.php';

    class UserController {
        public function details(){
            if (isset($_GET['id'])) {
                $userId = (int)$_GET['id']; 
        
            // 1. Отримуємо дані користувача з бази через репозиторій
                $ur = new UserRepository();
                $userData = $ur->getUserById($userId); // Отримуємо масив або об'єкт

                if ($userData) {
                // 2. Підключаємо вигляд
                    require '../app/views/layout/header_back.php';
                // Файл називається просто, без &id=...
                    require '../app/views/userdetails.php'; 
                    require '../app/views/layout/footer.php';
                } else {
                echo "Користувача не знайдено!";
                }
            } else {
                echo "ID користувача не вказано!";
            }
        }
    };
?>