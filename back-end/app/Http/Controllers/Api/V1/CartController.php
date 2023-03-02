<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProductRecourse;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where("id", $request->user_id)->first();
        $total = 0;
        foreach ($user->userProducts as $userProduct){
            $vat =round($userProduct->product->price * $userProduct->product->vat_rate);
            $total += ($vat+$userProduct->product->price) * $userProduct->amount/100;
        }
        return response()->json([
            "cart" => UserProductRecourse::collection($user->userProducts),
            'total' => number_format($total, 2),
        ]);
    }

    public function store(Request $request)
    {
        $user = User::where("id", $request->user_id)->first();
        $product = Product::where("id", $request->product_id)->first();
        if ($product->available < $request->amount){
            return response()->json([
                "message" => "Sorry, you cen order $product->name is out of stock!"
            ]);
        }
        $userProduct = $user->userproducts->where("product_id", $request->product_id)->first();
        if ($userProduct){
            $userProduct->update([
                "amount" => $userProduct->amount + $request->amount
            ]);
        }else {
             $userProduct = (new UserProduct())->fill([
                "user_id" => $user->id,
                "product_id" => $request->product_id,
                "amount" => $request->amount,
            ]);
             $userProduct->save();
        }
        $product = Product::where("id", $request->product_id)->first();
        $product->update([
            "available" => $product->available - $request->amount,
        ]);
        $product->save();
        return response()->json([
            "message" => "$request->amount $product->name is successfully added to your cart!"
        ]);
    }

    public function destroy(UserProduct $userProduct)
    {
        $product=$userProduct->product;
        $product->update([
            "available" => $product->available + $userProduct->amount,
        ]);
        $userProduct->delete();
        return response()->json([
            "message" => "$product->name removed from your cart!"
        ]);
    }

    public function destroyAll(Request $request)
    {
        $userProducts = UserProduct::where('user_id', $request->user_id)->delete();
        return response()->json([
            "message" => "Thanks, check out was successful!",
            "user_id" => $request->id,
        ]);
    }
}
