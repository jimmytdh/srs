<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $connection = 'users';
    protected $table = 'section';
    protected $fillable = [
        'initial',
        'code',
        'description',
        'division_id'
    ];
}
