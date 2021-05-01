<?php



namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;


class ClientAuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|unique:clients,name',
            'mobile'    => 'required|numeric|unique:clients,mobile',
            'address'   => 'required|max:255|min:50|string',
            'longitude' => 'nullable',
            'latitude'  => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }

        $input = $request->all();
        $client = client::create($input);
        $success['token'] = $client->createToken('yahia')->accessToken;
        $success['name'] = $client->name;
        return $this->sendResponse($success, 'User registered Successfully!');
    }
    public function login(Request $request)
    {
        //$client = client::where("mobile", request('mobile'))->first();

        $client = Client::where('mobile', $request->input("mobile"))
        ->where('name', $request->input("name"))
        ->first();
        if($client )
        {
            $success['token'] = $client->createToken('yahia')->accessToken;
            $success['name'] = $client->name;
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
            return $this->sendResponse($user ,'client logout successfully' );
        }
    }
}
