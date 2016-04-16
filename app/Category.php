<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $appends = array('count_childrens_category','count_shops_in_category');
    
    public function shops() {
        return $this->hasMany('App\Shop','category_id');
    }
    
    public function childrens() {
        return $this->hasMany('App\Category','parent_id');
    }
    
    public function parents(){
        return $this->hasOne('App\Category','id','parent_id');
    }
    
    public function events() {
        return $this->hasMany('App\Event','category_id');
    }
    
    public function getCountChildrensCategoryAttribute() {
        return $this->hasMany('App\Category','parent_id')->count();
    }
    public function getCountShopsInCategoryAttribute() {
        return $this->shops()->count();
    }
}
