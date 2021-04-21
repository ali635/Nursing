<?php



namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;


class ClientAuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'mobile'   => 'required',
            'gender'   => 'address',
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
        $client = client::where("mobile", request('mobile'))->first();
        if($client == 1){
            $success['token'] = $client->createToken('yahia')->accessToken;
            $success['name'] = $client->name;
            return $this->sendResponse($success, 'User Login Successfully!');
        } else {
            return $this->sendError('Unauthorised', ['error','Unauthorised']);
        }

    }



}

/*




 */
