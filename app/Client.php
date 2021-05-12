<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = ['name','mobile','address','longitude','latitude'];

       /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function wishlist()
    {
        return $this->belongsToMany('App\Product', 'wishlists')->withTimestamps();
    }

    public function wishlistHas($productId)
    {
        return self::wishlist()->where('product_id', $productId)->exists();
    }

}
