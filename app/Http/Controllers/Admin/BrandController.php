<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
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
    public function store(Request $request, Brand $brand): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|unique:brands,title',
            'image' => 'required|image'
        ]);
        if ($validate->fails()) {
            return $this->errorResponse(422, $validate->messages());
        }
        $brand->newBrand($request);
        $dataResponse = $brand->orderBy('id', 'desc')->first();
        return $this->successResponse(201, new BrandResource($dataResponse), 'brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
            return $this->errorResponse(422, 'The title has already been taken');
        }
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'image'
        ]);
        if ($validate->fails()) {
            return $this->errorResponse(422, $validate->messages());
        }
        $brand->updateBrand($request);
//        $dataResponse = $brand->orderBy('id', 'desc')->first();
        return $this->successResponse(201, new BrandResource($brand), 'brand updated successfully');


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return $this->successResponse(200, null, $brand->title . ' ' . 'deleted successfully');
    }
}
