<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $product = Product::query()->paginate(10);
        return $this->successResponse(HttpResponse::HTTP_CREATED, [
                'product' => ProductResource::collection($product),
                'links' => ProductResource::collection($product)->response()->getData()->links,
            ]
            ,
            'Product index successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request, Product $product): JsonResponse
    {
        $product->newProduct($request);
        $responseDta = $product->orderBy('id', 'desc')->first();
        return $this->successResponse(HttpResponse::HTTP_OK,
            new ProductResource($responseDta),
            'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): JsonResponse
    {

        $validate = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'integer|exists:brands,id',
                'name' => 'required|string',
                'image' => 'image|mimes:png,jpg,jpeg,svg',
                'slug' => 'required',
                'price' => 'required|integer',
                'description' => 'required|string',
                'quantity' => 'required|integer'
            ]);

        if ($validate->fails()) {
            return $this->errorResponse(HttpResponse::HTTP_UNPROCESSABLE_ENTITY, $validate->messages());
        }

        $slugUnique = Product::query()
            ->where('slug', $request->slug)
            ->where('id', '!=', $product->id)
            ->exists();

        if ($slugUnique) {
            return $this->errorResponse(HttpResponse::HTTP_UNPROCESSABLE_ENTITY, 'The slug has already been taken');
        }


        $product->updateProduct($request);
        return $this->successResponse(HttpResponse::HTTP_OK, new ProductResource($product), $product->name . 'updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        $product->save();
        return $this->successResponse(HttpResponse::HTTP_ACCEPTED, null, $product->name . ' deleted successfully');
    }
}
