<?php

namespace geoquizz\auth\domain\exception;

class JwtExpiredException extends \Exception {
    public function __construct() {
        parent::__construct('le token fourni est expiré');
    }

}