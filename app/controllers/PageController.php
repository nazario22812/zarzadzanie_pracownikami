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
            $_SESSION['status'] = (int)$ur->getUserStatus($user->getUserName());
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
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        $db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
        $mysqli = $db->getMysqli();

        $status = $_SESSION['status'];
        $userName = $_SESSION['user'];

        if ($status == 2) {
        // --- ЛОГІКА ДЛЯ АДМІНА ---
            $lowStock = $mysqli->query("SELECT name, stock FROM products WHERE stock < 5")->fetch_all(MYSQLI_ASSOC);
            $activeOrders = $mysqli->query("SELECT * FROM orders WHERE status = 'W trakcie' ORDER BY order_date DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
            $totalOrders = $mysqli->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
            $pendingCount = $mysqli->query("SELECT COUNT(*) as count FROM orders WHERE status = 'W trakcie'")->fetch_assoc()['count'];
        } else {
        // --- ЛОГІКА ДЛЯ ПРАЦІВНИКА (КОРИСТУВАЧА) ---
        // Отримуємо ID поточного користувача
            $userQuery = $mysqli->query("SELECT id FROM users WHERE username = '$userName'");
            $userData = $userQuery->fetch_assoc();
            $userId = $userData['id'];

        // Останнє замовлення для картки статусу
            $lastOrderResult = $mysqli->query("SELECT id, tracking_number, status FROM orders WHERE user_id = $userId ORDER BY order_date DESC LIMIT 1");
            $lastOrder = $lastOrderResult->fetch_assoc();

        // Історія замовлень для таблиці
            $userOrders = $mysqli->query("SELECT id, order_date, total_price FROM orders WHERE user_id = $userId ORDER BY order_date DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
        }
        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/dashboard.php';
        //require '../app/views/layout/footer.php';
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

    public function uzytkowniki() {
        if (!isset($_SESSION['user']) || $_SESSION['status'] != 2) {
            header("Location: ?page=login");
            exit;
        }

        

        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/uzytkowniki.php';
       // require '../app/views/layout/footer.php';
    }

    public function produkty() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        $db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
        $mysqli = $db->getMysqli();

    // --- ОБРОБКА ДОДАВАННЯ В КОШИК ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $ur = new UserRepository();
            $userId = $ur->getUserId($_SESSION['user']);

            if (!$userId) {
                die("Uzytkownik nie znaleziony.");
            }

            $productId = (int)$_POST['product_id'];
            $qty = (int)$_POST['quantity'];

        // Додаємо товар, який вже існує в таблиці products
            $stmtCart = $mysqli->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmtCart->bind_param("iii", $userId, $productId, $qty);
        
            if ($stmtCart->execute()) {
                header("Location: ?page=koszyk");
                exit;
            }
        }

    // --- ОТРИМАННЯ ТОВАРІВ ДЛЯ КАТАЛОГУ ---
        $result = $mysqli->query("SELECT * FROM products");
        $allProducts = $result->fetch_all(MYSQLI_ASSOC);

        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/produkty.php';
       // require '../app/views/layout/footer.php';
        
    }

    public function koszyk() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ur = new UserRepository();
            $userId = $ur->getUserId($_SESSION['user']);
        
            $address = $_POST['shipping_address'] ?? '';
            $zipCode = $_POST['zip_code'] ?? '';
            $city = $_POST['city'] ?? '';
            $fullAddress = trim($address) . ", " . trim($zipCode) . " " . trim($city);
        
            $phone = $_POST['phone'] ?? '';
        // Перетворюємо в float, щоб уникнути помилок з типами даних у базі
            $totalAmount = (float)($_POST['total_amount'] ?? 0); 
            $trackingnumber = "TN" . rand(100000, 999999);
        
            $db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
            $mysqli = $db->getMysqli();
        
        // 1. ВСТАВЛЯЄМО ЗАМОВЛЕННЯ (status поставиться автоматично 'W trakcie')
            $stmtOrder = $mysqli->prepare("INSERT INTO orders (user_id, total_price, tracking_number, shipping_address, phone_number) VALUES (?, ?, ?, ?, ?)");
            $stmtOrder->bind_param("idsss", $userId, $totalAmount, $trackingnumber, $fullAddress, $phone);
        
            if ($stmtOrder->execute()) {
                $orderId = $mysqli->insert_id; // Отримуємо ID нового замовлення

            // 2. ПЕРЕНОСИМО ТОВАРИ З cart В order_items
            // Використовуємо INSERT INTO ... SELECT для швидкості та точності
            // 2. ПЕРЕНОСИМО ТОВАРИ, отримуючи назву та ціну з таблиці products
                $sqlTransfer = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price_at_purchase)
                    SELECT ?, c.product_id, p.name, c.quantity, p.price 
                    FROM cart c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.user_id = ?";

                $stmtTransfer = $mysqli->prepare($sqlTransfer);
                $stmtTransfer->bind_param("ii", $orderId, $userId);
                $stmtTransfer->execute();

            // 3. ОЧИЩАЄМО КОШИК
                $stmClearCart = $mysqli->prepare("DELETE FROM cart WHERE user_id = ?");
                $stmClearCart->bind_param("i", $userId);
                $stmClearCart->execute();

                echo "<script>alert('Zamówienie zostało złożone pomyślnie.'); window.location.href='?page=dashboard';</script>";
                exit;
            }
        }

        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/koszyk.php';
       // require '../app/views/layout/footer.php';
    }

    public function zamowienia() {
        if (!isset($_SESSION['user']) || $_SESSION['status'] != 2) {
            header("Location: ?page=login");
            exit;
        }
        $db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
        $mysqli = $db->getMysqli();
        $sql = "SELECT o.*, u.username as login_uzytkownika, 
            GROUP_CONCAT(CONCAT(oi.product_name, ' (x', oi.quantity, ')') SEPARATOR ', ') AS list_produktow
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            LEFT JOIN order_items oi ON o.id = oi.order_id
            GROUP BY o.id
            ORDER BY o.order_date DESC";
        
        $result = $mysqli->query($sql);
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        
        

        require '../app/views/layout/header_zalogowany.php';
        require '../app/views/zamowienia.php';
       // require '../app/views/layout/footer.php';
    }

    public function update_status() {
        $orderId = $_POST['order_id'];
        $newStatus = $_POST['new_status'];

        $db = new Baza('127.0.0.1', 'root', '', 'mojmagazyn');
        $mysqli = $db->getMysqli();

    // 1. Оновлюємо статус замовлення
        $stmt = $mysqli->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $orderId);
        $stmt->execute();

    // 2. Якщо замовлення виконано, зменшуємо кількість продуктів на складі
        if ($newStatus == 'Dostarczono') {
        // Отримуємо всі товари з цього замовлення
            $items = $mysqli->query("SELECT product_id, quantity FROM order_items WHERE order_id = $orderId");
        
            while ($item = $items->fetch_assoc()) {
                $pId = $item['product_id'];
                $qty = $item['quantity'];
            // Зменшуємо stock у таблиці products
                $mysqli->query("UPDATE products SET stock = stock + $qty WHERE id = $pId");
            }
        }

        header("Location: ?page=zamowienia");
    }
}
