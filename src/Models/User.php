<?php

namespace App\Models;

use App\Core\Model;
use App\DTO\UserDTO;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function create(UserDTO $user)
    {
        $hashedPassword = $this->hashPassword($user->password);

        $this->DB()->query('INSERT INTO users(username, password, name, gender, birthday) VALUES (?, ?, ?, ?, ?)', [
            $user->username,
            $hashedPassword,
            $user->name,
            $user->gender,
            $user->birthday
        ]);

        $id = $this->DB()->insert();

        $userDB = UserDTO::create($this->getById($id));
        $userDB->unsetPassword();
        return $userDB;
    }

    public function getByUsername($username): UserDTO
    {
        $this->DB()->query('select * from users where username = ?', [$username]);
        return UserDTO::create($this->DB()->fetchOne());
    }

    public function login(UserDTO $user): mixed
    {
        $userDB = $this->getByUsername($user->username);

        if ($this->validatePassword($user->password, $userDB->password)) {
            $userDB->unsetPassword();
            return $userDB;
        } else {
            return false;
        }
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function validatePassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public function isExisted(UserDTO $user): bool
    {
        $this->DB()->query('select * from users where username = ?', [$user->username]);
        if ($this->DB()->fetchOne()) {
            return true;
        }
        return false;
    }

}