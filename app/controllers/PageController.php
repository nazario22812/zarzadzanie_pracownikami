<?php
require_once '../app/helpers/funkcje.php';
require_once '../app/models/UserRepository.php';


class PageController {

    public function login() {
        require '../app/views/layout/header.php';
        require '../app/views/login.php';
        require '../app/views/layout/footer.php';
    }
    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $dane = walidacja();
            if($dane === null) {
                echo "<script>
                        alert('Błędne dane podczas rejestracji. Spróbuj ponownie.');
                        window.location.href='?page=register';
                    </script>";
                exit;
            }
            // Tutaj można dodać kod do zapisania danych użytkownika do bazy danych
            $ur = new UserRepository();
            $ur->addUser($dane);
            echo "<script>
                    alert('Rejestracja zakończona sukcesem. Możesz się teraz zalogować.');
                    window.location.href='?page=login';
                </script>";
            exit;
            


        }
        require '../app/views/layout/header.php';
        require '../app/views/registration.php';
        require '../app/views/layout/footer.php';
    }


    public function dashboard() {
        $_SESSION['user'] = 'admin'; // symulacja logowania

        require '../app/views/layout/header.php';
        require '../app/views/dashboard.php';
        require '../app/views/layout/footer.php';
    }
}
