<?php
// Проверка, отправлена ли форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Подключение к базе данных
    $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Поиск пользователя в базе
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Успешный логин
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Неверное имя пользователя или пароль.';
    }
}
?>

<style>
    <?php include 'index.css'; ?>
</style>

<div class="container">
    <form class="login-form" method="POST" action="">
        <h2>Вход</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
        <a href="register" class="register-link">
            <button type="button" class="register-btn">Зарегистрироваться</button>
        </a>
    </form>
</div>