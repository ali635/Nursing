<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['Product_name','category_id','description','price','photo'];
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    
    
    public function orders()
    {
        return $this -> belongsToMany(Order::class,'orderproduct');
    }
}
