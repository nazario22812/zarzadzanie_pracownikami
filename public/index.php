<?php
session_start();


$page = $_GET['page'] ?? 'login';


if (
    !isset($_SESSION['user']) &&
    !in_array($page, ['login', 'register', 'reset', 'verify_code', 'new_password'])
) {
    $page = 'login';
}


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
    case 'produkty':
        $controller->produkty();
        break;
    case 'koszyk':
        $controller->koszyk();
        break;

    case 'zamowienia':
        $controller->zamowienia();
        break;
    case 'update_status':
        $controller->update_status();
        break;  
    default:
        echo "404 – strona nie istnieje";
}
