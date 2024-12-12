<?php

namespace App\Controllers;

use App\Core\Controller;
use App\DTO\BalanceDTO;
use App\Models\Balance;
use App\Models\User;
use App\DTO\UserDTO;
use App\Core\Validator;
use App\Core\ApiError;


class AuthController extends Controller
{
    public function login()
    {   
        $this->clearMessages();
        $userDTO = UserDTO::create($_POST);

        $errors = Validator::validateRequiredFields(['username', 'password'], $userDTO->toArray());

        if ($errors != []) {
            ApiError::badRequest($errors[0], '/login');
            die;
        }

        $User = new User();
        $userExists = $User->isExisted($userDTO);
        if (!$userExists) {
            ApiError::badRequest("Пользователь не найден", "/login");
            die;
        }
        
        $response = $User->login($userDTO);

        if ($response == false) {
            ApiError::badRequest("Неправильный логин или пароль", "/login");
        }

        $_SESSION["userId"] = $response->id;
        $_SESSION["username"] = $response->username;
        $this->redirect("/");
    }


    public function register()
    {
        $userDTO = UserDTO::create($_POST);

        $User = new User();
        $userExists = $User->isExisted($userDTO);

        $errors = Validator::validateRequiredFields(['username', 'password', 'gender', 'birthday', 'name'], $userDTO->toArray());
        if ($errors != []) {
            ApiError::badRequest($errors[0], "/register");
            return;
        }

        if ($userExists) {
            ApiError::badRequest("Имя пользователя занято", "/register");
            return;
        }

        if (Validator::validateStringLength($userDTO->password, 8, 32) == false) {
            ApiError::badRequest("Пароль должен быть от 8 до 32 символов", "/register");
            return;
        }

        if (Validator::validateIsStringInArray(['Male', 'Female'], $userDTO->gender) == false) {
            ApiError::badRequest('Выберите пол между Male и Female', "/register");
            return;
        }

        if (Validator::validateDate($userDTO->birthday) == false) {
            ApiError::badRequest('Дата рождения должна быть в формате YYYY-MM-DD', "/register");
            return;
        }

        if (Validator::validateAge($userDTO->birthday, 21) == false) {
            ApiError::badRequest('Вам должно быть не менее 21 лет', "/register");
            return;
        }

        $newUser = $User->create($userDTO);

        $Balance = new Balance();
        $Balance->create(BalanceDTO::create(['userId' => $newUser->id, 'currency' => 'EUR']));

        $_SESSION["userId"] = $newUser->id;
        $_SESSION["username"] = $newUser->username;
        $this->redirect("/");
    }

    public function logout() {
        unset($_SESSION["userId"]);
        unset($_SESSION["username"]);
        $this->redirect("/");
    }

}
