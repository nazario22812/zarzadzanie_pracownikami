<div class="parent">
    <div class="div1">
        
        <!-- <?php include 'app/views/layout/sidebar.php'; ?> -->
            <h2 style="margin: 0px; background-color: rgb(47, 61, 98); color: white; padding: 10px; border-radius: 8px;">Menu Główne</h2>
            <!-- <ul class="sidebar-menu">
                <li><a href="?page=dashboard">Dashboard</a></li>
                <li><a href="?page=logout">Wyloguj się</a></li>
            </ul> -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <li>
                        <a href="?page=dashboard">
                        <i class="icon-home"></i>
                        <span>Dashboard</span>
                        </a>   
                    </li>
                    <li>
                        <a href="?page=produkty">
                        <i class="icon-box"></i>
                        <span>Produkty</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=koszyk">
                        <i class="icon-zamow"></i>
                        <span>Koszyk</span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 2): ?>                    <li>
                        <a href="?page=uzytkownicy">
                        <i class="icon-users"></i>
                        <span>Użytkownicy</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 2): ?>                    <li>
                        <a href="?page=zamowienia">
                        <i class="icon-users"></i>
                        <span>Zamowienia</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li id="logoutli">
                        <a href="?page=logout">
                        <i class="icon-logout"></i>
                        <span style="color: rgb(230, 115, 117);">Wyloguj się</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </aside>

    </div>
    <div class="div2">
        <div class="users-box">
            <h2>Lista użytkowników</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nazwa użytkownika</th>
                    <th>Imię i nazwisko</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Status</th>
                </tr>
                <?php 
                include_once '../app/models/UserRepository.php';
                $ur = new UserRepository();
                $users = $ur->getAllUsers();
                foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td>
                        <?php 
                            if ($user['status'] == 1) {
                                echo 'Użytkownik';
                            } elseif ($user['status'] == 2) {
                                echo 'Administrator';
                            } else {
                                echo 'Nieznany';
                            }
                        ?>
                        
                    </td>
                    <td>
                        <?php if ($_SESSION['user'] != $user['username']): ?>
                        <button class="btn-info" onclick="
                                <?php    
                                    echo 'window.location.href=\'?page=user_details&id=' . $user['id'] . '\''; 
                                ?>
                            ">
                            Szczegóły
                        </button>
                        <?php else: ?>
                            <span class="badge-me">To Ty</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
            

    </div>
</div>