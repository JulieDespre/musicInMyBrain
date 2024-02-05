<?php

namespace geoquizz\auth\domain\DTO;


class UserDTO extends DTO {
    public string $email;
    public string $username;

    /**
     * @param string $email
     * @param string $username
     */
    public function __construct(string $email, string $username) {
        $this->email = $email;
        $this->username = $username;
    }
}