<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;

class WishlistController extends BaseController
{
    public function index()
    {
        $products= Auth::guard('client')->user()
            ->wishlist()
            ->latest()
            ->get();
        return $this->sendResponse($products,'تم ارسال جميع المنتجات المفضلة بنجاح');       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (! Auth::guard('client')->user()->wishlistHas(request('product_id'))) {
            auth()->user()->wishlist()->attach(request('product_id'));
            return response()->json(['status'=> true,'message'=> 'تم حفظ المنتج في القائمة المفضلة بنجاح','wished'=> true]);
        }
        return response()->json(['status'=> true,'message'=> 'هذا المنتج مضاف من قبل او غير موجود','wished'=> false]);
    }

    /**
     * Destroy resources by the given id.
     *
     * @param string $productId
     * @return void
     */
    public function destroy()
    {
        if(Auth::guard('client')->user()->wishlist()->detach(request('product_id')))
        {
            return response()->json(['status'=> true,'message'=> 'تم حذف المنتج من القائمة المفضلة بنجاح','wished'=> true]);
        }
        return response()->json(['status'=> true,'message'=> 'هذا المنتج غير موجود في الثائمة المفضلة','wished'=> false]);
    }
}
