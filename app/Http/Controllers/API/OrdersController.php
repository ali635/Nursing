<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Order as OrderResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrdersController extends BaseController
{
    public function index()
    {
        $orders = Order::all();
        return $this->sendResponse(OrderResource::collection($orders),
          'تم ارسال جميع الطلبات');
    }

    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input , [
        'product_id'  => 'required|numeric|exists:products,id',
        
        'user_id'     => 'nullable|numeric|exists:users,id'
       ] );

       if ($validator->fails())
       {
            return $this->sendError('Please validate error' ,$validator->errors() );
       }
       

       $ids = Auth::guard('client')->user()->id;
      $order= Order::create([
        'product_id' => $request->product_id,
        'client_id' => $ids
       ]);
       
        return $this->sendResponse(new OrderResource($order) ,'تم اضافة الطلب بنجاح ' );
    }


    public function show($id)
    {
        $order = Order::find($id);
        if ( is_null($order) )
        {
            return $this->sendError('Order not found'  );
        }
              return $this->sendResponse(new OrderResource($order) ,'Order found successfully' );
    }

    public function update($id,Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'product_id'  => 'required|numeric|exists:products,id',
            'client_id'   => 'required|numeric|exists:clients,id',
            'user_id'     => 'required|numeric|exists:users,id'
        ]);

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $order = Order::findOrFail($id);

        $order->product_id = $request->product_id;
        $order->client_id = $request->client_id;
        $order->user_id = $request->user_id;

        $order->save();
        return $this->sendResponse(new OrderResource($order) ,'تم تعديل الطلب بنجاح' );

    }

    public function destroy($id)
    {

        $order = Order::findOrFail($id);
        if ($order != null) {
            $order->delete();
            return $this->sendResponse(new OrderResource($order)  ,'تم حذف الطلب بنجاح' );
        }
        else{
            return $this->sendError('الطلب not found');
        }
    }
}
