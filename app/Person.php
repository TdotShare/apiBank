<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Person extends Model 
{
    protected $table = 'person';
    protected $primaryKey = 'idperson';

    protected $fillable = [
        'fname',
        'sname',
        'age'
    ];

    //public $incrementing = false;
    
    public $timestamps = false;
    protected $keyType = 'int';
}
