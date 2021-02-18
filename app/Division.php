<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $connection = 'users';
    protected $table = 'division';
    protected $fillable = [
        'code',
        'description'
    ];
}
