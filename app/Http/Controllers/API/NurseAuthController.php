<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;


class NurseAuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed|string',
            'mobile'   => 'required|numeric|unique:users,mobile',
            'gender'   => 'required',
            'age'      => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('yahia')->accessToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User registered Successfully!');
    }



    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('yahia')->accessToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'User Login Successfully!');
        } else {
            return $this->sendError('Unauthorised', ['error','Unauthorised']);
        }
    }

    public function logoutApi()
    {
        if (Auth::check())
        {
            $user = Auth::user()->token();
            $user->revoke();
            return $this->sendResponse($user ,'nurse logout successfully' );
        }
    }
}
