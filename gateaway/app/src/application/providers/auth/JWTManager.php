<?php

namespace toubeelib\application\providers\auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;

class JWTManager{

    public function creatAccessToken(array $payload): string{
        return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS512');
    }

    public function creatRefreshToken(array $payload): string{
        return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS512');
    }

    public function decodeToken(string $token): array{
        try {
            return array(JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'),'HS512' )));
        } catch (ExpiredException $e) {
            return \ExpiredException::class;
        } catch (SignatureInvalidException $e) {
            return \SignatureInvalidException::class;
        } catch (BeforeValidException $e) {
            return \BeforeValidException::class;
        } catch (\UnexpectedValueException $e) {
            return \UnexpectedValueException::class;
        }
    }
}