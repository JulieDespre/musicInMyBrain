<?php

namespace geoquizz\auth\domain\exception;

class AuthServiceExpiredTokenException extends \Exception {
    public function __construct() {
        parent::__construct('Token expiré');
    }
}