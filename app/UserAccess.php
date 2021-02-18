<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $connection = 'mysql';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
