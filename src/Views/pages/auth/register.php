<head>
    <title>Borbo | Регистрация</title>
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div class="container">
    <form class="login-form" method="post" action="/register">
        <h2>Регистрация</h2>
        <div id="error" class="error" style="color: red; margin-bottom: 10px;"><?php  if(isset($_SESSION['error']) && !empty($_SESSION['error'])) echo $_SESSION['error']; unset($_SESSION['error']) ?></div>
        <input id="username" type="text" name="username" placeholder="Имя пользователя">
        <select id="gender" name="gender">
            <option value="" disabled selected>Выберите пол</option>
            <option value="Male">Мужчина</option>
            <option value="Female">Женщина</option>
        </select>

        <input id="birthday" type="date" name="birthday" placeholder="Дата рождения">
        <input id="name" type="text" name="name" placeholder="Ваше имя">

        <input id="password" type="password" name="password" placeholder="Пароль">
        <input id="password-repeat" type="password" name="password-repeat" placeholder="Повторите пароль">

        <button id="register-btn" type="submit">Зарегистрироваться</button>
        <a href="login" class="register-link">
            <button type="button" class="second-btn">Войти</button>
        </a>
    </form>
</div>
