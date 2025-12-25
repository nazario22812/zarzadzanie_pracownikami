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
    <div class="div2" style="overflow-y: auto;">
            <div class="checkout-container">
                <h2 class="section-title">Dostępne Produkty</h2>

                <div class="product-grid">
                    <?php if (!empty($allProducts)): ?>
                        <?php foreach ($allProducts as $product): ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if (!empty($product['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="product" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <i class="icon-tools" style="font-size: 50px; color: #ddd;"></i>
                                    <?php endif; ?>
                                </div>
                    
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p class="product-price"><?php echo number_format($product['price'], 2, ',', ' '); ?> zł</p>
                                    <p class="prodeuct-count"><?php echo htmlspecialchars($product['stock']); ?> w magazynie</p>
                        
                                    <form action="?page=produkty" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            
                                        <div class="quantity-controls">
                                            <label>Ilość:</label>
                                            <input type="number" name="quantity" value="1" min="1" required>
                                        </div>

                                        <button type="submit" class="btn-add-cart">
                                            <i class="icon-cart"></i> Dodaj do koszyka
                                        </button>
                                    </form>
                                </div>
                            </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                        Brak dostępnych produktów.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
        

</div>