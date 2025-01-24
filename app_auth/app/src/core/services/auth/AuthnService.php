<?php

namespace app_auth\core\services\auth;

use Faker\Provider\Uuid;
use PDO;
use app_auth\application\providers\auth\AuthnProviderInterface;
use app_auth\core\dto\CredentialsDTO;
use app_auth\core\dto\AuthDTO;

class AuthnService implements AuthnServiceInterface{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }



    public function byCredentials(CredentialsDTO $credentials): ?AuthDTO {
        $sql = "SELECT id, email, role, password FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $credentials->email]);
        $user = $stmt->fetch();

        if ($user && password_verify($credentials->password, $user['password'])) {
            return new AuthDTO($user['id'], $user['email'], $user['role']);
        }

        return null;  // En cas d'erreur de validation
    }

}