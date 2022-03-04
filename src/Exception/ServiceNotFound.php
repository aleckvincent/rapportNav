<?php

namespace App\Exception;

use Throwable;

class ServiceNotFound extends \Exception {

    public function __construct(string $serviceName, $code = 404, Throwable $previous = null) {
        $message = "Le service : " . $serviceName . " n'existe pas.";
        parent::__construct($message, $code, $previous);
    }
}
