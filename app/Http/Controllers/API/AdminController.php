<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class AdminController extends BaseController
{
    public function login(Request $request)
    {
        
        $admin = Admin::where('email', $request->input("email"))
        ->first();
        

        if($admin && Hash::check($request->input('password'), $admin->password))
        {
            // $admin = Auth::user();
            $success['token'] = $admin->createToken('mohamed')->accessToken;
            $success['name'] = $admin->name;
            return $this->sendResponse($success ,'Admin login successfully' );
        }
        else{
            return $this->sendError('Please check your Auth' ,['error'=> 'Unauthorised'] );
        }
    }

    public function logoutApi()
    { 
        if (Auth::check()) 
        {
            $user = Auth::user()->token();
            $user->revoke();
            return $this->sendResponse($user ,'Admin logout successfully' );
        }
    }
}
