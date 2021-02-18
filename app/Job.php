<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'form_no',
        'request_date',
        'request_by',
        'request_office',
        'others',
        'findings',
        'remarks',
        'service_by',
        'acted_date',
        'completed_date',
        'status',
        'signature'
    ];
}
