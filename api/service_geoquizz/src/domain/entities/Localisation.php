<?php

namespace geoquizz\service\domain\entities;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $connection = 'geoquizz';
    protected $table = 'localisation';
    protected $primaryKey = 'id';
    public $timestamps = false;

}