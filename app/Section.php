<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'section';
    protected $fillable = [
        'initial',
        'code',
        'description',
        'division_id'
    ];
}
