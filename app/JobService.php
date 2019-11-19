<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobService extends Model
{
    protected $fillable = [
        'job_id',
        'service_id'
    ];
}
