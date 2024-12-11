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

    public function getAll()
    {
        $this->DB()->query("SELECT id, username, name, gender, birthday, status FROM users");
        return UserDTO::createArray($this->DB()->fetchAll());
    }

    public function getById($id)
    {
        $this->DB()->query("SELECT * FROM users WHERE id = ?", [$id]);
        $user = UserDTO::create($this->DB()->fetchOne());
        $user->unsetPassword();
        return $user;
    }

    public function getByUsername($username): UserDTO
    {
        $this->DB()->query('select * from users where username = ?', [$username]);
        return UserDTO::create($this->DB()->fetchOne());
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

        $userDB = $this->getById($id);
        $userDB->unsetPassword();
        return $userDB;
    }

    public function update(UserDTO $user)
    {
        $this->DB()->query("
        UPDATE 
            users 
        SET 
            name=?,
            gender=?,
            birthday=?,
            status=?
        WHERE 
            id=?
        ", [
            $user->name,
            $user->gender,
            $user->birthday,
            $user->status,
            $user->id
        ]);
        $result = $this->DB()->execute()[0];
        return $result;
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