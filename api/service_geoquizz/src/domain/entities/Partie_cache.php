<?php

namespace geoquizz\service\domain\entities;
use Illuminate\Database\Eloquent\Model;

class Partie_cache extends Model
{
    protected $connection = 'geoquizz';
    protected $table = 'partie_cache';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

}