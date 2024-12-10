<head>
    <title>Borbo | Авторизация</title>
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div class="container">
    <form method="post" class="login-form" action="/login">
        <h2>Вход</h2>
        <div id="error" class="error" style="color: red; margin-bottom: 10px;"><?php  if(isset($_SESSION['error']) && !empty($_SESSION['error'])) echo $_SESSION['error']; unset($_SESSION['error']) ?></div>
        <input id="username" type="text" name="username" placeholder="Имя пользователя">
        <input id="password" type="password" name="password" placeholder="Пароль">

        <button type="submit" id="login-btn" type="button">Войти</button>
        <a href="register" class="register-link">
            <button type="button" class="second-btn">Зарегистрироваться</button>
        </a>
    </form>
</div>

