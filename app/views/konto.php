
<?php
   
?>


<div class="profile-container">
    <div class="profile-header">
        <h2>Mój Profil</h2>
        <span class="badge" style="margin-left: 15px;">
            <?php 
                require_once '../app/models/UserRepository.php';
                $ur = new UserRepository();
                $user = $ur->getUserByUsername($_SESSION['user']);

            
                echo ($ur->getUserStatus($_SESSION['user']) == 2) ? 'Administrator' : 'Pracownik'; 
            ?>
        </span>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <label>Nazwa użytkownika</label>
            <span><?php echo $user->getUserName(); ?></span>
        </div>
        <div class="info-item">
            <label>Adres E-mail</label>
            <span><?php echo $user->getEmail(); ?></span>
        </div>
        <div class="info-item">
            <label>Imię i Nazwisko</label>
            <span><?php echo $user->getFirstName() . " " . $user->getLastName(); ?></span>
        </div>
        <div class="info-item">
            <label>Wiek</label>
            <span><?php echo $user->getWiek(); ?> lat</span>
        </div>
        <div class="info-item">
            <label>Numer telefonu</label>
            <span><?php echo $user->getPhone(); ?></span>
        </div>
        <div class="info-item">
            <label>Data rejestracji</label>
            <span>
                <?php 
                    echo $ur->getUserData($_SESSION['user']); 
                ?>
            </span>
        </div>
    </div>
</div>