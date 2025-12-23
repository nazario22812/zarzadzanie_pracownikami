<?php
session_start();

/*
|--------------------------------------------------------------------------
| Routing – wybór strony
|--------------------------------------------------------------------------
*/
$page = $_GET['page'] ?? 'login';

/*
|--------------------------------------------------------------------------
| Prosta ochrona – bez logowania tylko login
|--------------------------------------------------------------------------
*/
if (
    !isset($_SESSION['user']) &&
    !in_array($page, ['login', 'register', 'reset', 'verify_code', 'new_password'])
) {
    $page = 'login';
}

// // Тимчасово додайте це в index.php для тесту:
// if (isset($_SESSION['user']) && $_SESSION['user'] == 'ytka') {
//     $_SESSION['status'] = 2; 
// }

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
*/
require_once '../app/controllers/PageController.php';
require_once '../app/controllers/UserController.php';
$usercontrl = new UserController();
$controller = new PageController();

switch ($page) {
    case 'login':
        $controller->login();
        break;

    case 'register':
        $controller->register();
        break;

    case 'dashboard':
        $controller->dashboard();
        break;
    case 'konto':
        $controller->konto();
        break;
    case 'logout':
        session_destroy();
        echo "<script>
                window.location.href='?page=login';
            </script>";
        exit;
        break;
    case 'reset':
        $controller->zapomniales_haslo();
        break;
    case 'verify_code':
        $controller->verify_code();
        break;
    case 'new_password':
        $controller->set_new_password();
        break;

    case 'uzytkownicy':
        $controller->uzytkowniki();
        break;
    case 'user_details':
        $usercontrl->details();
        break;
    case 'zamowienia':
        $controller->zamowienia();
        break;
    case 'koszyk':
        $controller->koszyk();
        break;
    default:
        echo "404 – strona nie istnieje";
}
