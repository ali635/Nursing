<?php

namespace App\Http\Controllers\API;

use App\client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Client as ClientResource;
use App\Http\Controllers\API\BaseController as BaseController;

class ClientInfoController extends BaseController
{
    public function index()
    {
        $clients = client::all();
        return $this->sendResponse(ClientResource::collection($clients),
            'تم ارسال بيانات جميع المستخدمين');

    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'name'   => 'required',
            'mobile' => 'required',
            'address' => 'required',
        ] );

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $client = client::create($input);
        return $this->sendResponse(new ClientResource($client) ,'تم اضافة المستخدم بنجاح ' );
    }


    public function show($id)
    {
        $client = client::find($id);
        if ( is_null($client) )
        {
            return $this->sendError('المستخدم غير موجود'  );
        }
        return $this->sendResponse(new ClientResource($client) ,'المستخدم موجود' );
    }

    public function update($id,Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'name'   => 'required',
            'mobile' => 'required',
            'address' => 'required',

        ]);

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $client = client::findOrFail($id);

        $client->name = $request->name;
        $client->mobile = $request->mobile;
        $client->address = $request->address;


        $client->save();
        return $this->sendResponse(new ClientResource($client) ,'تم تعديل بيانات المستخدم بنجاح' );

    }

    public function destroy($id)
    {

        $client = client::findOrFail($id);
        if ($client != null) {
            $client->delete();
            return $this->sendResponse(new ClientResource($client)  ,'تم حذف المستخدم بنجاح' );
        }
        else{
            return $this->sendError('المستخدم غير موجود');
        }

    }



}
