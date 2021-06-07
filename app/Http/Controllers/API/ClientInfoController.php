<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Client as ClientResource;
use Illuminate\Support\Facades\Hash;
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
            'name'      => 'required|string|unique:clients,name',
            'mobile'    => 'required|numeric|unique:clients,mobile',
            'address'   => 'required|max:255|min:50|string',
            'email'     => 'required|email|unique:clients,email',
            'password'  => 'required|min:6',
            'photo'     => 'nullable|image',
            'longitude' => 'nullable',
            'latitude'  => 'nullable',
        ] );

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $client = client::create($input);
        if($request->photo && $request->photo->isValid())
        {
            $file_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('profile'),$file_name);
            $path = "public/profile/$file_name";
            $client->photo=$path;
        }
        $client->save();
        return $this->sendResponse(new ClientResource($client) ,'تم اضافة المستخدم بنجاح ' );
    }


    public function show($id)
    {
        $client = Client::findOrFail($id);
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
            'name'      => 'required|string|unique:clients,name',
            'mobile'    => 'required|numeric|unique:clients,mobile',
            'address'   => 'required|max:255|min:50|string',
            'email'     => 'required|email|unique:clients,email',
            'password'  => 'required|min:6',
            'photo'     => 'nullable|image',
            'longitude' => 'nullable',
            'latitude'  => 'nullable',

        ]);

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $client = Client::findOrFail($id);
        
        $client->name      = $request->name;
        $client->mobile    = $request->mobile;
        $client->address   = $request->address;
        $client->longitude = $request->longitude;
        $client->latitude  = $request->latitude;

        if($request->photo && $request->photo->isValid())
        {
            $file_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('profile'),$file_name);
            $path = "public/profile/$file_name";
            $client->photo=$path;
        }
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
