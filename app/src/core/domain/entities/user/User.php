<?php

namespace toubeelib\core\domain\entities\user;

use Faker\Provider\Uuid;
use toubeelib\core\dto\CredentialsDTO;

class User{
    protected UUID $id;
    protected string $email;
    protected string $password;
    protected string $role;

    public function __construct(UUID $id, string $email, string $password, string $role) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function __toString(){
        return "User: $this->id, $this->email, $this->role";
    }

    public function toDTO(): CredentialsDTO{
        return new CredentialsDTO($this->email, $this->password);
    }
}