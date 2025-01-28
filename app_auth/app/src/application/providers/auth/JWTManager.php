<?php

namespace app_auth\application\providers\auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;

class JWTManager{

    public function creatAccessToken(array $payload): string{
        $payload['exp'] = time() + 3600; // 1 hour expiration
        return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS512');
    }

    public function creatRefreshToken(array $payload): string{
        $payload['exp'] = time() + 604800;// 1 week expiration
        return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS512');
    }

    public function decodeToken(string $token): array{
        try {
            $decoded = (array) JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'),'HS512' ));
            if (isset($decoded['data']) && is_object($decoded['data'])) {
                $decoded['data'] = (array) $decoded['data'];
            }
            return $decoded;
        } catch (ExpiredException $e) {
            throw new \Exception('Token expired');
        } catch (SignatureInvalidException $e) {
            throw new \Exception('Invalid token signature');
        } catch (BeforeValidException $e) {
            throw new \Exception('Token from the future');
        } catch (\UnexpectedValueException $e) {
            throw new \Exception('Unexpected token value');
        }
    }
}