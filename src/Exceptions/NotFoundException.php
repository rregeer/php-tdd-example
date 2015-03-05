<?php

namespace TDD\Exceptions;

class NotFoundException extends \Exception {

    public function __construct($message, \Exception $exception = null)
    {
        if ($exception != null) {
            parent::__construct($message, $exception->getCode(), $exception);
        } else {
            parent::__construct($message);
        }
    }
}