<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Revenue extends Model 
{
    protected $table = 'revenue';
    protected $primaryKey = 'idrevenue';

    protected $fillable = [
        'idwallet',
        'topic',
        'money'
    ];

    //public $incrementing = false;
    
    public $timestamps = false;
    protected $keyType = 'int';
}
