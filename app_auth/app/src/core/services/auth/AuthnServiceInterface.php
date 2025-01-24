<?php

namespace app_auth\core\services\auth;

use app_auth\core\dto\CredentialsDTO;
use app_auth\core\dto\AuthDTO;

interface AuthnServiceInterface{
    //public function createUser(CredentialsDTO $credentials, int $role):UUID;
    public function byCredentials(CredentialsDTO $credentials): ?AuthDTO;
}