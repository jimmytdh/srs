<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $connection = 'users';
    protected $table = 'designation';
    protected $fillable = [
        'code',
        'description'
    ];
}
