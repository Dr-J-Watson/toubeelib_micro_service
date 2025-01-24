<?php

namespace app_auth\core\dto;

class UserDTO extends DTO{

    public function __construct(string $id, string $email, string $role) {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
    }
}