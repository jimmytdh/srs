<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'users';
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'designation',
        'division',
        'section',
        'password',
        'signature',
        'picture'
    ];

    public function roles()
    {
        return $this->hasMany('App\UserAccess');
    }

    public function isAdmin()
    {
        return $this->roles()->where('level','admin')->exists();
    }

    public function allowed()
    {
        return $this->roles()->exists();
    }
}
