<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'due',
        'description',
        'assign_to',
        'status',
        'remarks',
    ];
}
