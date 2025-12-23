<div class="profile-container">
    <?php 
        require_once '../app/models/UserRepository.php';
        $ur = new UserRepository();

        // 1. Отримуємо ID користувача з URL (наприклад, ?page=user_details&id=5)
        if (isset($_GET['id'])) {
            $userId = (int)$_GET['id'];
            
            // 2. Отримуємо об'єкт User через новий метод (або існуючий, якщо він шукає за ID)
            // Якщо у вас є метод getUserById, краще використати його
            $targetUser = $ur->getUserById($userId); 
        }

        if (!$targetUser): ?>
            <p>Nie znaleziono użytkownika.</p>
    <?php else: ?>
    
    <div class="profile-header">
        <h2>Profil użytkownika: <?php echo htmlspecialchars($targetUser->getUserName()); ?></h2>
        <span class="badge" style="margin-left: 15px;">
            <?php 
                 
                $user = $ur->getUserById((int)$_GET['id']);

            
                echo ($ur->getUserStatusById((int)$_GET['id']) == 2) ? 'Administrator' : 'Pracownik'; 
            
            ?>
        </span>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <label>Nazwa użytkownika</label>
            <span><?php echo htmlspecialchars($targetUser->getUserName()); ?></span>
        </div>
        <div class="info-item">
            <label>Adres E-mail</label>
            <span><?php echo htmlspecialchars($targetUser->getEmail()); ?></span>
        </div>
        <div class="info-item">
            <label>Imię i Nazwisko</label>
            <span><?php echo htmlspecialchars($targetUser->getFirstName() . " " . $targetUser->getLastName()); ?></span>
        </div>
        <div class="info-item">
            <label>Wiek</label>
            <span><?php echo (int)$targetUser->getWiek(); ?> lat</span>
        </div>
        <div class="info-item">
            <label>Numer telefonu</label>
            <span><?php echo htmlspecialchars($targetUser->getPhone()); ?></span>
        </div>
        <div class="info-item">
            <label>Data rejestracji</label>
            <span><?php echo htmlspecialchars($targetUser->getDate()); ?></span>
        </div>
    </div>
    <div class="info-change">
    <form action="?page=user_details&id=<?php echo $_GET['id']; ?>" method="POST">
        <input type="hidden" name="userId" value="<?php echo $_GET['id']; ?>">
        
        <div class="change-item">
            <label>Zmień E-mail</label>
            <input type="email" name="newEmail" value="<?php echo htmlspecialchars($targetUser->getEmail()); ?>">
            <button type="submit" name="update_type" value="email">Zmień E-mail</button>
        </div>

        <div class="change-item">
            <label>Zmień numer telefonu</label>
            <input type="text" name="newPhone" value="<?php echo htmlspecialchars($targetUser->getPhone()); ?>">
            <button type="submit" name="update_type" value="phone">Zmień numer telefonu</button>
        </div>

        <div class="change-item">
            <label>Zmień status</label>
            <select name="newStatus">
                <option value="1" <?php if ($targetUser->getStatus() == 1) echo 'selected'; ?>>Użytkownik</option>
                <option value="2" <?php if ($targetUser->getStatus() == 2) echo 'selected'; ?>>Administrator</option>
            </select>
            <button type="submit" name="update_type" value="status">Zmień status</button>
        </div>
    </form>
</div>
    
    <?php endif; ?>
    </div>
</div>