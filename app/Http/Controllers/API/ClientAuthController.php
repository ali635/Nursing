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
            'email'     => 'required|email|unique:clients,email',
            'password'  => 'required|min:6|confirmed|string',
            'photo'     => 'nullable|image',
            'longitude' => 'nullable',
            'latitude'  => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
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
        $success['token'] = $client->createToken('yahia')->accessToken;
        $success['name'] = $client->name;
        return $this->sendResponse($success, 'User registered Successfully!');
    }

    ///////////////////login function //////////////////
    public function login(Request $request)
    {

        // $client = Client::where('email', $request->input("email"))
        // ->where('password', $request->input("password"))
        // ->first();
        // dd($client);
        
        if(is_numeric($request->input('email'))){

            $client = Client::where('mobile',$request->input('email'))
           
            ->first();
          
        }
          elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
        
             $client = Client::where('email',$request->input('email'))
            
            ->first();
        
         }else {
             $client = Client::where('name',$request->input('email'))
             
             ->first();  
         }

        if($client && Hash::check($request->input('password'), $client->password)) 
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
