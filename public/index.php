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
    !in_array($page, ['login', 'register'])
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

    default:
        echo "404 – strona nie istnieje";
}
