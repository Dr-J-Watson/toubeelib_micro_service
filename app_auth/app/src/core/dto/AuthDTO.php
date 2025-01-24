<?php

namespace app_auth\core\dto;

use PhpParser\Token;

class AuthDTO extends DTO{
    protected string $email;
    protected string $id;
    protected int $role;
    protected ?string $token;
    protected ?string $refreshToken;

    public function __construct(string $id="",string $email="", int $role=0){
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
    }

    public function addToken(string $token, string $refreshToken): AuthDTO{
        $this->token = $token;
        $this->refreshToken = $refreshToken;

        return $this;
    }

}