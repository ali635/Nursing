<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends BaseController
{
    public function index()
    {
        $data=[];
        $data['clients'] = Client::count();
        $data['nurses']  = User::count();
        $data['orders_pending']  = Order::where('status','0')->count();
        $data['orders_visiting']  = Order::where('status','1')->count();
        $data['orders_visited']  = Order::where('status','2')->count();
        $data['total']  = Order::where('status','2')->sum('total');
        return $this->sendResponse($data,'تم ارسال جميع الاحصائيات بنجاح');     
    }

    public function getAllNurse()
    {
        $nurse = User::latest()->take(10)->get();
        return $this->sendResponse($nurse,'تم ارسال الممرضين بنجاح');  
    }
    public function getNoNurse()
    {
        $nurse = User::where('is_active','0')->get();
        return $this->sendResponse($nurse,'تم ارسال الممرضين بنجاح');
    }
}