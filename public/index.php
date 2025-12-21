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

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
*/
require_once '../app/controllers/PageController.php';
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

    default:
        echo "404 – strona nie istnieje";
}
