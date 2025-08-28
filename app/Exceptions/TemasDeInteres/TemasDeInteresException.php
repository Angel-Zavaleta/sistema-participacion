<?php

namespace App\Exceptions\TemasDeInteres;

use Exception;

class TemasDeInteresException extends Exception
{
    public function __construct(string $message = "Error en el tema de interes")
    {
        parent::__construct($message);
    }
}
