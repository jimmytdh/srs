<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $table = 'borrow';
    protected $fillable = ['item_id','date_borrowed','user_borrowed','remarks_borrowed','date_returned','user_returned','remarks_returned'];
}
