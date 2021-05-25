<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends BaseController
{
    public function index()
    {
        $data=[];
        $data['clients'] = Client::count();
        $data['nurses']  = User::count();
        return $this->sendResponse($data,'تم ارسال جميع الاحصائيات بنجاح');     
    }
}