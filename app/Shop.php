<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    protected $table = 'shops';
    protected $appends = array('rating');

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function city()
    {
        return $this->hasOne('App\City', 'id', 'city_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo', 'shop_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }


    public function getRatingAttribute()
    {
        $data['sum'] = $this->hasMany('App\Review', 'shop_id', 'id');
        $data['sum'] = $data['sum']->sum('rating');
        $data['count'] = $this->hasMany('App\Review', 'shop_id', 'id');
        $data['count'] = $data['count']->count();
        if ($data['count'] > 0 and $data['sum'] > 0) {
            $rating = $data['sum'] / $data['count'];
        } else {
            $rating = 0.00;
        }
        return $rating;
    }

}
