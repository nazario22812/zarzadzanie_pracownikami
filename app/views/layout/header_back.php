<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mój Magazyn</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topbar">
    <div class="navigacja" >
        <h1><a href="?page=uzytkownicy"> Mój Magazyn </a></h1>
        <h1>  <a href="?page=konto">  Cześć, <?php echo $_SESSION['user']; ?>! </a></h1>
    
    </div>
    
</header>

<main class="container1">
