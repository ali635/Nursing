<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Validation\Rule;

class CategoriesController extends BaseController
{
    
    public function index()
    {
        $categories = Category::all();
        return $this->sendResponse(CategoryResource::collection($categories),
          'تم ارسال جميع الاقسام');
    }

    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input , [
        'name' => 'required|max:255|unique:categories'
       ]);

       if ($validator->fails()) {
        return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $category = Category::create([
            'name' => $request->name,
        ]);
    
    
    return $this->sendResponse(new CategoryResource($category) ,'تم اضافة القسم بنجاح ' );

    }

    public function show($id)
    {
        $category = Category::find($id);
        if ( is_null($category) ) {
            return $this->sendError('لا يوجد هذا القسم'  );
              }
              return $this->sendResponse(new CategoryResource($category) ,'تم ارسال المنتج بنجاح' );

    }


    public function update($id,Request $request)
    {
        
        $input = $request->all();
        $validator = Validator::make($input , [
            'name' => ['required', \Illuminate\Validation\Rule::unique('categories')->ignore($request->id)]
        ]);

        if ($validator->fails()) 
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $category = Category::findOrFail($id);
        
        $category->name = $request->name;
        
        $category->save();
        return $this->sendResponse(new CategoryResource($category) ,'تم تعديل القسم بنجاح' );

    }


    public function destroy($id)
    {
       
        $category = Category::findOrFail($id);
        if ($category != null) {
            $category->delete();
            return $this->sendResponse(new CategoryResource($category)  ,'تم حذف القسم بنجاح' );
        }
        else{
            return $this->sendError('القسم not found');
        }

    }
}
