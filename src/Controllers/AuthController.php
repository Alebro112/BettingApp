<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Dto\UserDTO;

use App\Core\Validator;
use App\Core\ApiError;


class AuthController extends Controller
{
    public function index()
    {


        echo "login";
    }


    public function login()
    {
        $userDTO = UserDTO::create($this->requestJson());

        $User = new User();
        $userExists = $User->isExisted($userDTO);

        $errors = Validator::validateRequiredFields(['username', 'password'], $userDTO->toArray());
        if ($errors != []) {
            ApiError::badRequest($errors[0]);
            return;
        }

        if (!$userExists) {
            ApiError::badRequest("Пользователь не существует");
            return;
        }

        $response = $User->login($userDTO);

        $this->responseJson(200, $response);
    }


    public function register()
    {
        $userDTO = UserDTO::create($this->requestJson());

        $User = new User();
        $userExists = $User->isExisted($userDTO);

        $errors = Validator::validateRequiredFields(['username', 'password', 'gender', 'birthday', 'name'], $userDTO->toArray());
        if ($errors != []) {
            ApiError::badRequest($errors[0]);
            return;
        }

        if ($userExists) {
            ApiError::badRequest("Имя пользователя занято");
            return;
        }

        if (Validator::validateStringLength($userDTO->password, 8, 32) == false) {
            ApiError::badRequest("Пароль должен быть от 8 до 32 символов");
            return;
        }

        if (Validator::validateIsStringInArray(['Male', 'Female'], $userDTO->gender) == false) {
            ApiError::badRequest('Выберите пол между Male и Female');
        }

        if (Validator::validateDate($userDTO->birthday) == false) {
            ApiError::badRequest('Дата рождения должна быть в формате YYYY-MM-DD');
        }

        if (Validator::validateAge($userDTO->birthday, 21) == false) {
            ApiError::badRequest('Вам должно быть не менее 21 лет');
        }

        $newUser = $User->create($userDTO);

        $this->responseJson(200, $newUser);
    }

}
