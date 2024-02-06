<?php

namespace geoquizz\auth\domain\entities;
use Illuminate\Database\Eloquent\Model;
use geoquizz\auth\domain\dto\UserDTO;

class Users extends Model
{
    protected $connection = 'auth';
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function toDTO():UserDTO
    {
        return new UserDTO(
            $this->email,
            $this->username
        );
    }

}