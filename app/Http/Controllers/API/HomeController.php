<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Order;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
    public function index()
    {
        $ids = Auth::guard('client')->user()->id;
        $user= Order::where([
            ['client_id', '=', $ids],
            ['check', '=', 1],
            ['status', '=', 1],
        ])->orWhere('status',2)
        ->get();
        
        return $this->sendResponse($user,'تم ارسال جميع الطلبات الخاصة بالمستخدم  بنجاح');       
    }
}
