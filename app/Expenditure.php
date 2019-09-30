<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Expenditure extends Model 
{
    protected $table = 'expenditure';
    protected $primaryKey = 'idexpenditure';

    protected $fillable = [
        'idwallet',
        'topic',
        'money'
    ];

    //public $incrementing = false;
    
    public $timestamps = false;
    protected $keyType = 'int';
}
