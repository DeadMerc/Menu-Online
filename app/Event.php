<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    public $timestamps = false;

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function shop()
    {
        return $this->hasOne('App\Shop', 'id', 'shop_id');
    }
}
