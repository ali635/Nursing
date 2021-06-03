<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable =['client_id','client_name','client_phone','client_id','new_address','total','payment_method','status','check','Payment_Date','user_id'];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'orderproduct');
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
