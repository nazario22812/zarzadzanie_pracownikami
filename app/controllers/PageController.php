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
                echo "<script>alert('Proszę podać numer telefonu.'); window.location.href='?page=reset';</script>";
                exit;
            }

            $ur = new UserRepository();
            $user = $ur->getUserByPhone($phone);

            if ($user) {
            // 1. GENERUJEMY LOSOWY KOD
                $code = rand(100000, 999999);

            // 2. ZAPISUJEMY W SESJI (aby sprawdzić go na następnej stronie)
                $_SESSION['reset_code'] = $code;
                $_SESSION['reset_phone'] = $phone; // pamiętamy dla kogo robimy reset

            // 3. PRZYGOTOWUJEMY E-MAIL
                $to = $user->getEmail(); 
                $subject = "Kod resetowania hasla";
                $message = "Witaj " . $user->getFirstName() . "!\n\n";
                $message .= "Twój kod do zresetowania hasła to: " . $code . "\n";
                $message .= "Wprowadź go na stronie, aby móc ustawić nowe hasło.";
            
                $headers = "From: topytka2006@gmail.com\r\n"; // Musi być zgodny z loginem SMTP
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
                $headers .= "Content-Transfer-Encoding: 8bit\r\n";
            // 4. WYSYŁKA
                if (mail($to, $subject, $message, $headers)) {
                    echo "<script>
                            alert('Kod został wysłany na Twój adres e-mail.');
                            window.location.href='?page=verify_code'; // PRZEKIEROWANIE DO WERYFIKACJI
                        </script>";
                } else {
                    // Jeśli serwer nie wysyła maili (np. na localhost), wyświetlamy kod w alercie do testów
                    echo "<script>
                            alert('Błąd serwera poczty. Kod do testów: $code');
                            window.location.href='?page=verify_code';
                        </script>";
                }
                exit;
            } else {
                echo "<script>alert('Nie znaleziono użytkownika z tym numerem.'); window.location.href='?page=reset';</script>";
                exit;
            }
        }

        require '../app/views/layout/header.php';
        require '../app/views/zapomnialeshaslo.php';
        require '../app/views/layout/footer.php';
    }


    public function verify_code() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_code = $_POST['code'] ?? '';

            // Sprawdzamy czy kod z formularza zgadza się z tym z sesji
            if (isset($_SESSION['reset_code']) && $user_code == $_SESSION['reset_code']) {
                // Kod poprawny!
                echo "<script>alert('Kod poprawny. Możesz zmienić hasło.'); window.location.href='?page=new_password';</script>";
                exit;
            } else {
                echo "<script>alert('Błędny kod! Spróbuj ponownie.'); window.location.href='?page=verify_code';</script>";
                exit;
            }
        }

        require '../app/views/layout/header.php';
        require '../app/views/verify_code.php'; // Tutaj będzie formularz na kod
        require '../app/views/layout/footer.php';
    }


    public function set_new_password() {
    // Zabezpieczenie: jeśli ktoś wejdzie tu bez kodu, wyrzuć go
        if (!isset($_SESSION['reset_phone'])) {
            header("Location: ?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pass1 = $_POST['nowe_haslo1'] ?? '';
            $pass2 = $_POST['nowe_haslo2'] ?? '';

            if ($pass1 === $pass2 && strlen($pass1) >= 8) {
                $ur = new UserRepository();
            // Wywołujemy metodę w modelu, którą zaraz dopiszemy
                $ur->updatePassword($_SESSION['reset_phone'], $pass1);

            // CZYŚCIMY SESJĘ RESETU
                unset($_SESSION['reset_code'], $_SESSION['reset_phone']);

                echo "<script>alert('Hasło zostało zmienione. Możesz się zalogować.'); window.location.href='?page=login';</script>";
                exit;
            } else {
                echo "<script>alert('Hasła muszą być identyczne i mieć min. 8 znaków.'); window.location.href='?page=new_password';</script>";
                exit;
            }
        }

        require '../app/views/layout/header.php';
        require '../app/views/new_password.php'; // Formularz na nowe hasło
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
