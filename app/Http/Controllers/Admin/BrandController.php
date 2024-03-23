<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandFormRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class BrandController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $brand = Brand::all();
        return $this->successResponse(HttpResponse::HTTP_OK, $brand, 'Brand get OK');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandFormRequest $request, Brand $brand): JsonResponse
    {
        $brand->newBrand($request);
        $dataResponse = $brand->orderBy('id', 'desc')->first();
        return $this->successResponse(HttpResponse::HTTP_CREATED,
            new BrandResource($dataResponse),
            'brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand): JsonResponse
    {
        $brandUniq = Brand::query()->where('title', '=', $request->title)
            ->where('id', '!=', $brand->id)
            ->exists();

        if ($brandUniq) {
            return $this->errorResponse(HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                'The title has already been taken');
        }
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'image'
        ]);
        if ($validate->fails()) {
            return $this->errorResponse(HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                $validate->messages());
        }
        $brand->updateBrand($request);
        return $this->successResponse(HttpResponse::HTTP_CREATED,
            new BrandResource($brand),
            'brand updated successfully');


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $brand->delete();
        $brand->save();
        return $this->successResponse(HttpResponse::HTTP_OK,
            null,
            $brand->title . ' ' . 'deleted successfully');
    }

    public function getProducts(Brand $brand): JsonResponse
    {
        return $this->successResponse(HttpResponse::HTTP_OK,
            new BrandResource($brand->load('products')),
            'Get products');
    }
}
