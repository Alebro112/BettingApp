<?php

namespace App\DTO;

use App\Core\DTO;

class UserDTO extends DTO {
    public  int $id;
    public  string $username;
    public  string $password;
    public  string $name;
    public  string $gender;
    public  string $birthday;

    public string $status;

    public function unsetPassword() {
        $this->password = '';
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setGender(string $gender) {
        $this->gender = $gender;
    }

    public function setBirthday(string $birthday) {
        $this->birthday = $birthday;
    }

    public function setStatus(string $status) {
        $this->status = $status;
    }
}