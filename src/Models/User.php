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

    public function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function isExisted(UserDTO $user)
    {
        $this->DB()->query('select * from users where username = ?', [$user->username]);
        return $this->DB()->fetchOne();
    }

}