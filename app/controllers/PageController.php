<?php
require_once '../app/helpers/funkcje.php';
require_once '../app/models/UserRepository.php';


class PageController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nie używamy walidacja(), bo ona wymaga imienia, nazwiska itd.
        // Pobieramy tylko to, co jest w formularzu logowania
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            echo "<script>alert('Wypełnij wszystkie pola!'); window.location.href='?page=login';</script>";
            exit;
        }

        $ur = new UserRepository();
        $user = $ur->getUserByUsername($username);

        // Sprawdzamy czy użytkownik istnieje i czy hasło pasuje do hasza z bazy
        if ($user && password_verify($password, $user->getPasswd())) {
            $_SESSION['user'] = $user->getUserName();
            $_SESSION['status'] = $user->getStatus();
            echo "<script>
                    alert('Logowanie zakończone sukcesem.');
                    window.location.href='?page=dashboard';
                </script>";
            exit;
        } else {
            echo "<script>
                    alert('Nieprawidłowa nazwa użytkownika lub hasło.');
                    window.location.href='?page=login';
                </script>";
            exit;
        }
    }
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

        require '../app/views/layout/header.php';
        require '../app/views/dashboard.php';
        require '../app/views/layout/footer.php';
    }
}
