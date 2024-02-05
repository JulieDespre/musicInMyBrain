<?php

namespace geoquizz\auth\domain\exception;

class AuthServiceInvalideTokenException extends \Exception {
    public function __construct() {
        parent::__construct('Token invalide');
    }

}