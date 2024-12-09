<?php

namespace App\DTO;

use App\Core\DTO;

class UserDTO extends DTO {
    public int $id;
    public string $username;
    public string $password;
    public string $name;
    public string $gender;
    public string $birthday;

    public function unsetPassword() {
        $this->password = '';
    }
}