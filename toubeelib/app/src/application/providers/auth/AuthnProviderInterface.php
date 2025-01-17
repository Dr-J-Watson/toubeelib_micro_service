<?php

namespace toubeelib\application\providers\auth;

use PhpParser\Token;
use toubeelib\core\dto\AuthDTO;
use toubeelib\core\dto\CredentialsDTO;

interface AuthnProviderInterface{
    public function register(CredentialsDTO $credentials, int $role): void;
    public function signin(CredentialsDTO $credentials): AuthDTO;
    public function refresh(string $token): AuthDTO;

    public function getSignedInUser(string $token): AuthDTO;
}