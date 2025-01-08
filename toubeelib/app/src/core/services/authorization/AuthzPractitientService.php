<?php

namespace toubeelib\core\services\authorization;

use toubeelib\core\dto\AuthDTO;

class AuthzPractitientService{

    public function authRead(AuthDTO $authUser, int $practitionerId): bool{
        if($authUser->role === 10){
            return true;
        }

        if($authUser->role === 5 && $authUser->id === $practitionerId){
            return true;
        }

        return false;
    }

    public function authWrite(AuthDTO $authUser, int $practitionerId): bool{
        if($authUser->role === 10){
            return true;
        }

        if($authUser->role === 5 && $authUser->id === $practitionerId){
            return true;
        }

        return false;
    }

    public function authDelete(AuthDTO $authUser): bool{
        if($authUser->role === 10){
            return true;
        }

        return false;
    }
}