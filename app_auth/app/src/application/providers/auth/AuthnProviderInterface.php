<?php

namespace app_auth\application\providers\auth;

use PhpParser\Token;
use app_auth\core\dto\AuthDTO;
use app_auth\core\dto\CredentialsDTO;

interface AuthnProviderInterface{
    public function register(CredentialsDTO $credentials, int $role): void;
    public function signin(CredentialsDTO $credentials): AuthDTO;
    public function refresh(string $token): AuthDTO;

    public function getSignedInUser(string $token): AuthDTO;
}