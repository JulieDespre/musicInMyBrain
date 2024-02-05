<?php

namespace geoquizz\auth\domain\DTO;

class CredentialsDTO extends DTO {

    public string $email;
    public string $password;
    public string $username;

    /**
     * @param string $email
     * @param string $password
     * @param string $username
     */
    public function __construct(string $email = '', string $password = '', string $username = '')
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }
}