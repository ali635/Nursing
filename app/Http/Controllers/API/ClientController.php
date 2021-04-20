<?php
/*
namespace App\Http\Controllers;

use App\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'mobile'   => 'required',
            'address'   => 'required',
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


}
*/
