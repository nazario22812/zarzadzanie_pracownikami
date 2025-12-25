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
        <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 2): ?>
            <div class="admin-dashboard">
                <header class="dashboard-header">
                    <h1>Panel administratora</h1>
                    <p>Stan magazynu i zamówień</p>
                </header>

                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-label">Wszystkie zamówienia</span>
                        <span class="stat-value"><?php echo $totalOrders; ?></span>
                    </div>
                    <div class="stat-card highlight">
                        <span class="stat-label">Oczekują obrobki</span>
                        <span class="stat-value"><?php echo $pendingCount; ?></span>
                    </div>
                </div>

                

                <div class="orders-section">
                    <h3>📦Aktywne zamówienia (W trakcie)</h3>
                    <table class="minimal-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Razem</th>
                                <th>Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activeOrders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo date('d.m.Y', strtotime($order['order_date'])); ?></td>
                                <td><?php echo number_format($order['total_price'], 2, ',', ' '); ?> zł</td>
                                <td><a href="?page=zamowienia" class="btn-link">Szczegóły</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($activeOrders)): ?>
                                <tr><td colspan="4">Aktywnych zamówień nie ma</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


                <div class="inventory-check">
                    <h3><i class="icon-package"></i> Stan magazynu</h3>
    
                    <?php if (!empty($lowStock)): ?>
                        <div class="alert-box warning">
                            <p><strong>⚠️ Uwaga:</strong> Następujące towary kończą się:</p>
                            <ul class="stock-list">
                            <?php foreach ($lowStock as $item): ?>
                                <li>
                                    <?php echo htmlspecialchars($item['name']); ?> 
                                    <span class="stock-count">(Zostało: <?php echo $item['stock']; ?> szt.)</span>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                            <a href="?page=produkty" class="btn-manage">Uzupełnij magazyn</a>
                        </div>
                    <?php else: ?>
                    <div class="alert-box success">
                        <p><i class="icon-check"></i> <strong>Wszystko w komplecie:</strong>W magazynie znajduje się wystarczająca liczba sztuk każdego produktu.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>


       <?php else: ?>
            <div class="user-dashboard">
                <header class="welcome-section">
                    <p class="subtitle">Dashboard Użytkownika</p>
                    <h1>Cześć, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
                </header>

            <?php if ($lastOrder): ?>
            <div class="status-card-green">
                <h3>Status Twojego Ostatniego Zamówienia</h3>
                <div class="status-row">
                    <p>Numer Przesyłki: <br><strong><?php echo $lastOrder['tracking_number']; ?></strong></p>
                    <span class="status-label-yellow">Status: <?php echo $lastOrder['status']; ?></span>
                </div>
        </div>
        <?php endif; ?>

        <div class="action-grid">
            <a href="?page=produkty" class="btn-blue">📦 Przeglądaj Produkty</a>
            <a href="?page=koszyk" class="btn-white">🛒 Mój Koszyk</a>
        </div>

        <div class="history-section">
            <h3>Moje Ostatnie Zamówienia</h3>
            <table class="user-history-table">
                <thead>
                    <tr><th>ID Zamówienia</th><th>Data</th><th>Kwota</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($userOrders as $o): ?>
                    <tr>
                        <td>#<?php echo $o['id']; ?></td>
                        <td><?php echo date('d.m', strtotime($o['order_date'])); ?></td>
                        <td><?php echo number_format($o['total_price'], 2); ?> zł</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>