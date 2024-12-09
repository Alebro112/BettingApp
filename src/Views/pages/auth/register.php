<style>
    <?php include 'index.css'; ?>
</style>

<div class="container">
    <div class="login-form">
        <h2>Регистрация</h2>
        <div id="error" class="error" style="color: red; margin-bottom: 10px;"></div>
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

        <button id="register-btn" type="button">Зарегистрироваться</button>
        <a href="login" class="register-link">
            <button type="button" class="second-btn">Войти</button>
        </a>
    </div>
</div>

<script>
    function errorHandler(text) {
        $("#error").text(text);
    }

    function calculateAge(birthday) {
        const birthDate = new Date(birthday);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    async function registerUser(username, password, gender, birthday, name) {
        const api = new Api('http://localhost:3000');
        const response = await api.post('/api/register', {
            username: username,
            password: password,
            gender: gender,
            birthday: birthday,
            name: name
        });
        return response;
    }

    $("#register-btn").click(function () {
        const username = $("#username").val().trim();
        const password = $("#password").val();
        const passwordRepeat = $("#password-repeat").val();
        const gender = $("#gender").val();
        const birthday = $("#birthday").val();
        const name = $("#name").val().trim();

        // Очистка ошибок
        errorHandler('');

        if (!username) {
            errorHandler('Введите имя пользователя');
            return;
        }

        if (!name) {
            errorHandler('Введите ваше имя');
            return;
        }

        if (!gender) {
            errorHandler('Выберите пол');
            return;
        }

        if (!birthday) {
            errorHandler('Введите дату рождения');
            return;
        }

        const age = calculateAge(birthday);
        if (age < 21) {
            errorHandler('Вам должно быть больше 21 года');
            return;
        }

        if (!password) {
            errorHandler('Введите пароль');
            return;
        }

        if (password !== passwordRepeat) {
            errorHandler('Пароли не совпадают');
            return;
        }

        registerUser(username, password, gender, birthday, name).then(response => {
            console.log(response);
        }).catch(error => {
            errorHandler(error.response.message);
        });
    });
</script>
