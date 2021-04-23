<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;

class ProductsController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products),
          'تم ارسال جميع المنتجات');
    }

    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input , [
        'Product_name'  => 'required|max:255',
        'category_id'    => 'required|exists:categories,id',
        'description'   => 'required',
        'price'         => 'required'
       ] );

       if ($validator->fails())
       {
            return $this->sendError('Please validate error' ,$validator->errors() );
       }
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product) ,'تم اضافة المنتج بنجاح ' );
    }


    public function show($id)
    {
        $product = Product::find($id);
        if ( is_null($product) )
        {
            return $this->sendError('Product not found'  );
        }
              return $this->sendResponse(new ProductResource($product) ,'Product found successfully' );
    }

    public function update($id,Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'Product_name'  => 'required|max:255',
            'category_id'    => 'required|exists:categories,id',
            'description'   => 'required',
            'price'         => 'required',
            'photo'         => 'nullable|image'
        ]);

        if ($validator->fails())
        {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $product = Product::findOrFail($id);

        $product->Product_name = $request->Product_name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        if($request->photo && $request->photo->isValid())
        {
            $file_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'),$file_name);
            $path = "public/images/$file_name";
            $product->photo=$path;
        }

        $product->save();
        return $this->sendResponse(new ProductResource($product) ,'تم تعديل المنتج بنجاح' );

    }

    public function destroy($id)
    {

        $product = Product::findOrFail($id);
        if ($product != null) {
            $product->delete();
            return $this->sendResponse(new ProductResource($product)  ,'تم حذف المنتج بنجاح' );
        }
        else{
            return $this->sendError('المنتج not found');
        }
    }

    // public function uploadImage($id,Request $request)
    // {
    //     $input = $request->all();
    //     $validator = Validator::make($input , [
    //         'Product_name'  => 'required|max:255',
    //         'category_id'   => 'required|exists:categories,id',
    //         'description'   => 'required',
    //         'price'         => 'required',
    //         'photo'         => 'nullable|image'
    //     ]);

    //     if ($validator->fails())
    //     {
    //         return $this->sendError('Please validate error' ,$validator->errors() );
    //     }
    //     $product = Product::findOrFail($id);

    //     $product->Product_name = $request->Product_name;
    //     $product->category_id = $request->category_id;
    //     $product->description = $request->description;
    //     $product->price = $request->price;
    //     if($request->photo && $request->photo->isValid())
    //     {
    //         $file_name = time().'.'.$request->photo->extension();
    //         $request->photo->move(public_path('images'),$file_name);
    //         $path = "public/images/$file_name";
    //         $product->photo=$path;
    //     }
    //     $product->save();
    //     return $this->sendResponse(new ProductResource($product) ,'تم تعديل المنتج بنجاح' );
   // }
}