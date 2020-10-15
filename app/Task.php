<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = 'tasks';
    protected $fillable = [
        'due_date',
        'description',
        'assign_to',
        'status',
        'remarks',
    ];
}
