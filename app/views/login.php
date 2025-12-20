<div class="login-box">
    <h2>Logowanie</h2>

    <form method="post" action="?page=login">

        <input 
            type="text" 
            name="username"
            placeholder="Nazwa użytkownika"
            required
        >

        <input 
            type="password" 
            name="password"
            placeholder="Hasło"
            required
        >

        <button type="submit">Zaloguj się</button>

        <div class="linki_pod_logowaniem">
            <a href="?page=register">Nie masz konta? Zarejestruj się</a>
            <a href="?page=reset">Zapomniałeś hasła?</a>
        </div>

    </form>
</div>
