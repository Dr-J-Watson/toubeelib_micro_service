<?php

namespace toubeelib\core\services\auth;

use toubeelib\core\dto\CredentialsDTO;
use toubeelib\core\dto\AuthDTO;

interface AuthnServiceInterface{
    //public function createUser(CredentialsDTO $credentials, int $role):UUID;
    public function byCredentials(CredentialsDTO $credentials): ?AuthDTO;
}