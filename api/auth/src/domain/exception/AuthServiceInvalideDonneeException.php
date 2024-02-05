<?php

namespace geoquizz\auth\domain\exception;

class AuthServiceInvalideDonneeException extends \Exception
{
    public function __construct() {
        parent::__construct("Probleme au niveau des données de l'inscription");
    }
}