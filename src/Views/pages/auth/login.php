<style>
    <?php include 'index.css'; ?>
</style>

<div class="container">
    <div class="login-form">
        <h2>Вход</h2>
        <div id="error" class="error" style="color: red; margin-bottom: 10px;"></div>
        <input id="username" type="text" name="username" placeholder="Имя пользователя">
        <input id="password" type="password" name="password" placeholder="Пароль">

        <button id="login-btn" type="button">Войти</button>
        <a href="register" class="register-link">
            <button type="button" class="second-btn">Зарегистрироваться</button>
        </a>
    </div>
</div>

<script>
    function errorHandler(text) {
        $("#error").text(text);
    }

    async function login(username, password) {
        const api = new Api('http://localhost:3000');
        const response = await api.post('/api/login', {
            username: username,
            password: password
        });
        return response;
    }

    $("#login-btn").click(function () {
        const username = $("#username").val().trim();
        const password = $("#password").val();

        // Очистка ошибок
        errorHandler('');

        if (!username) {
            errorHandler('Введите имя пользователя');
            return;
        }

        if (!password) {
            errorHandler('Введите пароль');
            return;
        }


        login(username, password).then(response => {
           console.log(response); 
        }).catch(error => {
            errorHandler(error.response.message);
        });
        
    });
</script>