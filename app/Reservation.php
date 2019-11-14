<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['code','title','description','user','item_id','date_start','date_end','time_start','time_end','status'];
}
