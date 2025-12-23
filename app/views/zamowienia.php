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
                        <a href="">
                        <i class="icon-box"></i>
                        <span>Produkty</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=zamowienia">
                        <i class="icon-zamow"></i>
                        <span>Zamówienia</span>
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
        <div class="div2">
            <div class="checkout-container">
                <h2 class="section-title">Dodaj nowy przedmiot do zamówienia</h2>

                <div class="checkout-section" style="max-width: 600px; margin: 0 auto;">
                    <h3><i class="icon-plus"></i> Wpisz dane produktu</h3>
            
                    <form action="?page=zamowienia" method="POST" class="manual-add-form">
                        <div class="form-group">
                            <label>Nazwa produktu</label>
                            <input type="text" name="custom_name" placeholder="np. Młotek, Gwoździe..." required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Cena za sztukę (zł)</label>
                                <input type="number" step="0.01" name="custom_price" placeholder="0.00" required>
                            </div>
                            <div class="form-group">
                                <label>Ilość</label>
                                <input type="number" name="custom_quantity" value="1" min="1" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-order" style="width: 100%; margin-top: 10px;">
                            <i class="icon-add"></i> Dodaj do koszyka
                        </button>
                    </form>
                </div>
            </div>
        </div>
        

    </div>
</div>