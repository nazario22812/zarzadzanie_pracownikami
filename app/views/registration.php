<div class="register-box">
    <h2>Rejestracja</h2>

    <form method="post" action="?page=register">

        <input type="text" name="username" placeholder="Nazwa użytkownika" required>

        <input type="password" name="password" placeholder="Hasło" required>

        <input type="number" name="age" placeholder="Wiek" min="18" max="120" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="text" name="first_name" placeholder="Imię" required>

        <input type="text" name="last_name" placeholder="Nazwisko" required>

        <input type="tel" name="phone" placeholder="Numer telefonu">

        <button type="submit">Zarejestruj się</button>

        <div class="linki_pod_logowaniem">
            <a href="?page=login">Masz konto? Zaloguj się</a>
        </div>

    </form>
</div>
