<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Resources\admin\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $category = Category::query()->paginate(10);
        return $this->successResponse(HttpResponse::HTTP_OK, [
            'categories' => CategoryResource::collection($category),
            'links' => CategoryResource::collection($category)->response()->getData()->links,
        ], 'Get categories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request, Category $category): JsonResponse
    {

        $category->newCategory($request);
        $dataResponse = $category->orderBy('id', 'desc')->first();
        return $this->successResponse(HttpResponse::HTTP_CREATED,
            new CategoryResource($dataResponse),
            'brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return $this->successResponse(HttpResponse::HTTP_OK,
            new CategoryResource($category),
            'GET - ' . $category->title);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $categoryUniq = Category::query()
            ->where('title', $request->title)
            ->where('id', '!==', $category->id)
            ->exists();

        if ($categoryUniq) {
            return $this->errorResponse(HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                'The title has already been taken');
        }
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'parent_id' => 'nullable|integer'
        ]);
        if ($validate->fails()) {
            return $this->errorResponse(HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                $validate->messages());
        }
        $category->updateCategory($request);
        return $this->successResponse(HttpResponse::HTTP_CREATED,
            new CategoryResource($category),
            'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return $this->successResponse(HttpResponse::HTTP_OK,
            new CategoryResource($category),
            'Category deleted successfully'
        );
    }

    public function parent(Category $category): JsonResponse
    {
        return $this->successResponse(HttpResponse::HTTP_OK,
            new CategoryResource($category->load('parent')),
            'Get parents');
    }

    public function children(Category $category): JsonResponse
    {
        return $this->successResponse(HttpResponse::HTTP_OK,
            new CategoryResource($category->load('children')),
            'Get children');
    }

}
