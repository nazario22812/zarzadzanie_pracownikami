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
    <div class="div2" style="margin: 20px;">
        <div class="orders-box">
            <h2>Lista zamówień</h2>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Zamówienia</th>
                        <th>Użytkownik</th>
                        <th>Data Zamówienia</th>
                        <th>Kwota Całkowita</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['login_uzytkownika']); ?></td>
                            <td><?php echo htmlspecialchars($order['list_produktow'] ?: 'Brak produktów'); ?></td>
                            <td><?php echo number_format($order['total_price'], 2, ',', ' '); ?> zł</td>
                            <td>
                                <form method="POST" action="?page=update_status">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="new_status" onchange="this.form.submit()">
                                        <option value="W trakcie" <?php echo $order['status'] == 'W trakcie' ? 'selected' : ''; ?>>W trakcie</option>
                                        <option value="Dostarczono" <?php echo $order['status'] == 'Dostarczono' ? 'selected' : ''; ?>>Dostarczono</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
            

    </div>
</div>