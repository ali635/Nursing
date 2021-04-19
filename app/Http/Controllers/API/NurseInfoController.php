<?php


namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Http\Resources\Nurse as NurseResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;


class APIAuthController extends Controller
{
    public function index()
    {
        $nurses = User::all();
        return $this->sendResponse(NurseResource::collection($nurses),
          'تم ارسال بيانات جميع الممرضين');
    }

    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input , [
        'name'   => 'required',
        'email'  => 'required|max:255',
        'password' => 'required|min:6',
        'mobile' => 'required',
        'gender' => 'required',
        'age'    => 'required',
       ] );

       if ($validator->fails())
       {
            return $this->sendError('Please validate error' ,$validator->errors() );
       }
        $nurse = User::create($input);
        return $this->sendResponse(new NurseResource($nurse) ,'تم اضافة الممرض بنجاح ' );
    }


    public function show($id)
    {
        $nurse = User::find($id);
        if ( is_null($nurse) )
        {
            return $this->sendError('الممرض غير موجود'  );
        }
              return $this->sendResponse(new NurseResource($nurse) ,'الممرض موجود' );
    }

    public function update($id,Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'name'   => 'required',
            'email'  => 'required|max:255',
            'password' => 'required|min:6',
            'mobile' => 'required',
            'gender' => 'required',
            'age'    => 'required',

        ]);

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $nurse = User::findOrFail($id);

        $nurse->name = $request->name;
        $nurse->email = $request->email;
        $nurse->password = $request->password;
        $nurse->mobile = $request->mobile;
        $nurse->gender = $request->gender;
        $nurse->age = $request->age;


        $nurse->save();
        return $this->sendResponse(new NurseResource($nurse) ,'تم تعديل بيانات الممرض بنجاح' );

    }

    public function destroy($id)
    {

        $nurse = User::findOrFail($id);
        if ($nurse != null) {
            $nurse->delete();
            return $this->sendResponse(new NurseResource($nurse)  ,'تم حذف الممرض بنجاح' );
        }
        else{
            return $this->sendError('الممرض غير موجود');
        }

    }

}
