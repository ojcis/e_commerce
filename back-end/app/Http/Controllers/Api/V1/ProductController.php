<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::all());
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function store(Request $request): ProductResource
    {
        $product=(new Product())->fill([
            'name' => $request->name,
            'available' => $request->available,
            'price' => $request->price,
            'vat_rate' => $request->vat_rate
        ]);
        $product->save();
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product): ProductResource
    {
         $product->update([
            'name' => $request->name,
            'available' => $request->available,
            'price' => $request->price,
            'vat_rate' => $request->vat_rate
        ]);
        return new ProductResource($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $name = $product->name;
        $product->delete();

        return response()->json([
            'message' => "$product->name is removed from stock!"
        ]);
    }
}
