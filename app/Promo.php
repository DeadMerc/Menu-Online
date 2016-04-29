<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    public $timestamps = false;

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}
