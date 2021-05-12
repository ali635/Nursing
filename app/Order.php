<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable =['product_id','client_id','user_id'];
    
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function clients()
    {
        return $this->hasOne('App\Client','client_id');
    }
    public function users()
    {
        return $this->hasOne('App\User','user_id');
    }
}
