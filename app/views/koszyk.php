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
        
        <div class="checkout-container">
            <h2 class="section-title">Finalizacja zamówienia</h2>

            <form action="?page=koszyk" method="POST" class="checkout-form">
                <div class="checkout-grid">
            
                    <div class="checkout-section">
                        <h3><i class="icon-truck"></i> Dane do dostawy</h3>
                
                        <div class="form-group">
                            <label>Pełne imię i nazwisko</label>
                            <input type="text" name="full_name" placeholder="Jan Kowalski" required>
                        </div>

                        <div class="form-group">
                            <label>Adres zamieszkania</label>
                            <input type="text" name="shipping_address" placeholder="ul. Marszałkowska 1/22" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Kod pocztowy</label>
                                <input type="text" name="zip_code" placeholder="00-001" required>
                            </div>
                            <div class="form-group">
                                <label>Miasto</label>
                                <input type="text" name="city" placeholder="Warszawa" required>
                            </div>
                    </div>

                    <div class="form-group">
                        <label>Numer telefonu</label>
                        <input type="tel" name="phone" placeholder="+48 123 456 789" required>
                    </div>
                </div>

                <div class="checkout-section summary-section">
                    <h3><i class="icon-basket"></i> Twoje zamówienie</h3>
                
                    <div class="order-summary">
                        <?php 
                            include_once '../app/models/OrdersRepository.php';
                            include_once '../app/models/UserRepository.php'; // Додаємо, щоб отримати ID
    
                            $cr = new OrdersRepository();
                            $ur = new UserRepository();

                            $username = $_SESSION['user'] ?? '';
                            $currentUserId = $ur->getUserId($username); 
    
                            $cartItems = $currentUserId ? $cr->getCartItems($currentUserId) : [];
                            $total = 0; 
                        ?>

                        <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): 
                            $itemTotal = $item['price'] * $item['quantity'];
                            $total += $itemTotal; 
                        ?>
                        <div class="summary-item" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span class="item-name">
                                <?php echo htmlspecialchars($item['product_name']); ?> 
                                <small style="color: #666;">(x<?php echo (int)$item['quantity']; ?>)</small>
                            </span>
                            <span class="item-price">
                                <?php echo number_format($itemTotal, 2, ',', ' '); ?> zł
                            </span>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: #888;">Twój koszyk jest pusty.</p>
                        <?php endif; ?>
    
                        <hr>
    
                        <div class="summary-total" style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2em;">
                            <span>Razem do zapłaty:</span>
                            <span class="total-amount" style="color: #27ae60;">
                                <?php echo number_format($total, 2, ',', ' '); ?> zł
                            </span>
                        </div>  
                    </div>

                    <div class="payment-methods">
                        <h4>Metoda płatności</h4>
    
                        <label class="radio-container">
                            <input type="radio" name="payment" value="cod" checked onchange="toggleCardDetails()">
                            <span class="checkmark"></span> Za pobraniem (gotówka)
                        </label>
    
                        <label class="radio-container">
                            <input type="radio" name="payment" value="transfer" onchange="toggleCardDetails()">
                            <span class="checkmark"></span> Przelew bankowy
                        </label>

                        <label class="radio-container">
                            <input type="radio" name="payment" value="card" id="card-radio" onchange="toggleCardDetails()">
                            <span class="checkmark"></span> Karta płatnicza
                        </label>
                    </div>

                    <div id="card-input-box" class="checkout-section" style="display: none; margin-top: 20px; border-left: 4px solid #2688d1;">
                        <h3><i class="icon-credit-card"></i> Dane karty</h3>
                        <div class="form-group">
                            <label>Numer karty</label>
                            <input type="text" name="card_number" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Data ważności</label>
                                <input type="text" name="card_expiry" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" name="card_cvv" placeholder="123">
                            </div>
                        </div>
                    </div>
                    <script>
                        function toggleCardDetails() {
                            const cardBox = document.getElementById('card-input-box');
                            const cardRadio = document.getElementById('card-radio');

                            if (cardRadio.checked) {
                                cardBox.style.display = 'block'; // Показуємо, якщо вибрана карта
                            } else {
                                cardBox.style.display = 'none';  // Ховаємо для інших методів
                            }
                        }
                    </script>
                    <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                    
                    <?php if (!empty($cartItems)): ?>
                    <button type="submit" class="btn-order">Potwierdzam zamówienie</button>
                    <?php else: ?>
                    <script>
                        alert('Twój koszyk jest pusty. Dodaj produkty przed złożeniem zamówienia.');
                    </script>
                    <?php endif; ?>
                </div>
                </div>
            </form>
        </div>

    </div>
</div>