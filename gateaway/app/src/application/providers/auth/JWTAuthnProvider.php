<?php

namespace toubeelib\application\providers\auth;

use PDO;
use PhpParser\Token;
use toubeelib\application\providers\auth\AuthnProviderInterface;
use toubeelib\core\dto\AuthDTO;
use toubeelib\core\dto\CredentialsDTO;
use toubeelib\core\services\auth\AuthnService;

class JWTAuthnProvider implements AuthnProviderInterface{

    private PDO $db;

    public function __construct() {
        $pdo = new PDO('pgsql:host=toubeelib.db;dbname=auth', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
    }

    public function register(CredentialsDTO $credentials, int $role): void{
        if($credentials->password == null || strlen($credentials->password) < 8){
            throw new \Exception("Password must be at least 8 characters");
        }

        if(filter_var($credentials->email, FILTER_VALIDATE_EMAIL) === false){
            throw new \Exception("Invalid email");
        }

        $existingUser = $this->getUserByEmail($credentials->email);
        if ($existingUser) {
            throw new \Exception('Cet utilisateur existe déjà');
        }


        try {
            $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, :role)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'email' => $credentials->email,
                'password' => password_hash($credentials->password, PASSWORD_DEFAULT),
                'role' => $role
            ]);

        } catch (\PDOException $e) {
            throw new \Exception('Erreur lors de l\'enregistrement de l\'utilisateur: ' . $e->getMessage());
        }
    }

    public function signin(CredentialsDTO $credentials): AuthDTO{
        $sql = "SELECT id, role FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $credentials->email]);
        $user = $stmt->fetch();
        if (!$user) {
            throw new \Exception('Cet utilisateur n\'existe pas');
        }
        $payload = [ 'iss'=>'localhost:6080/users/signin',
            'aud'=>'localhost:6080/users/signin',
            'iat'=>time(),
            'exp'=>time()+3600,
            'sub' => $user['id'],
            'data' => [
                'role' => $user['role'],
                'user' => $credentials->email
            ]
        ] ;

        $jwt = new JWTManager();
        $auth = new AuthnService($this->db);
        $accessToken = $jwt->creatAccessToken($payload);
        $refreshToken = $jwt->creatRefreshToken($payload);
        $user2 = $auth->byCredentials($credentials);
        $user2->addToken($accessToken, $refreshToken);
        return $user2;
    }

    public function refresh(Token $token): AuthDTO{
        $payload = JWTManager::class->decodeToken($token);

        $token = JWTManager::class->creatAccessToken($payload);
        $rtoken = JWTManager::class->creatRefreshToken($payload);
        $auth = new AuthDTO($payload['sub'], $payload['data']['user'], $payload['data']['role']);
        
        return $auth->addToken($token, $rtoken);
    }

    public function getSignedInUser(Token $token): AuthDTO{
        $payload = JWTManager::class->decodeToken($token);
        return new AuthDTO($payload['sub'], $payload['data']['user'], $payload['data']['role']);
    }

    public function getUserByEmail($email): ?array{
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }


}