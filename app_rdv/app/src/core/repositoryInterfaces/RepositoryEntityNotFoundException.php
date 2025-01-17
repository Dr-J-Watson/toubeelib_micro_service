<?php

namespace app_rdv\core\repositoryInterfaces;

class RepositoryEntityNotFoundException extends \Exception
{
    public function __construct($message = "Entity not found", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}