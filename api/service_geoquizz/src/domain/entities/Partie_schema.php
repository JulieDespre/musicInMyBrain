<?php

namespace geoquizz\service\domain\entities;
use Illuminate\Database\Eloquent\Model;

class Partie_schema extends Model
{
    protected $connection = 'geoquizz';
    protected $table = 'partie_schema';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

}