<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPAddress extends Model
{
    protected $fillable = [
        'type',
        'ip',
        'owner',
        'section'
    ];
    protected $table = 'ipaddresses';
}
