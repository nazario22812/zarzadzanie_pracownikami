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

        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/dashboard.php';
        require '../app/views/layout/footer.php';
    }

    public function zapomniales_haslo() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, [
                'options' => [
                    'regexp' => '/^\+?[0-9\s\-]{7,20}$/'
                ]
            ]);

            if (empty($phone)) {
                echo "<script>
                        alert('Proszę podać numer telefonu.');
                        window.location.href='?page=reset';
                    </script>";
                exit;
            }

            $ur = new UserRepository();
            $user = $ur->getUserByPhone($phone);

            if ($user) {
                // Tutaj można dodać kod do wysłania e-maila z instrukcjami resetu hasła
                echo "<script>
                        alert('Instrukcje resetu hasła zostały wysłane na podany adres numer telefonu.');
                        window.location.href='?page=login';
                    </script>";
                exit;
            } else {
                echo "<script>
                        alert('Nie znaleziono użytkownika z podanym adresem e-mail.');
                        window.location.href='?page=reset';
                    </script>";
                exit;
            }
        }

        require '../app/views/layout/header.php';
        require '../app/views/zapomnialeshaslo.php';
        require '../app/views/layout/footer.php';
    }
    public function konto() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        // 2. Pobranie danych z bazy
        $ur = new UserRepository();
        $user = $ur->getUserByUsername($_SESSION['user']);

        // 3. Sprawdzenie czy użytkownik w ogóle istnieje
        if (!$user) {
            echo "Błąd: Nie znaleziono danych użytkownika.";
            exit;
        }

        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/konto.php';
        require '../app/views/layout/footer.php';
    }
}
