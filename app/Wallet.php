<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Wallet extends Model 
{
    protected $table = 'wallet';
    protected $primaryKey = 'idwallet';

    protected $fillable = [
        'money',
        'idperson'
    ];

    //public $incrementing = false;
    
    public $timestamps = false;
    protected $keyType = 'int';
}
