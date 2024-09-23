<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Resources\CategroyResource;
use App\Http\Requests\StorecatergoryRequest;
use App\Http\Requests\UpdatecatergoryRequest;

class CategoryController extends Controller
{
    protected CategoryService $CategoryService;

    /**
     * Constructor for CategoryController
     *
     * @param CategoryService $CategoryService The category service for handling category-related logic.
     */
    public function __construct(CategoryService $CategoryService)
    {
        $this->CategoryService = $CategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories= $this->CategoryService->getAll();
        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'books' => [
                'info' => CategroyResource::collection($categories['data']),
                'current_page' => $categories['current_page'],
                'last_page' => $categories['last_page'],
                'per_page' => $categories['per_page'],
                'total' => $categories['total'],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecatergoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $category = $this->CategoryService->store($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'Category' => CategroyResource::make($category),
        ], 201); // Created
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $category = $this->CategoryService->show($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrived successfully',
            'Category' => CategroyResource::make($category),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecatergoryRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $category = $this->CategoryService->update($request->validated(), $id);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'Category' => CategroyResource::make($category),
        ], 200); // OK
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $message = $this->CategoryService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], 200); // OK
    }
    public function ShowTrashed(): \Illuminate\Http\JsonResponse
    {
        $trashedCategory= $this->CategoryService->showDeleted();
        return response()->json([
            'status' => 'success',
            'message' => 'Trashed Categories retrieved successfully',
            'categories' => [
                'categories' => [
                    'info' => CategroyResource::collection($trashedCategory->items()),
                    'current_page' => $trashedCategory->currentPage(),
                    'last_page' => $trashedCategory->lastPage(),
                    'per_page' => $trashedCategory->perPage(),
                    'total' => $trashedCategory->total(),
                ],
            ],
        ], 200); // OK
    }

    /**
     * @throws \Exception
     */
    public function restore(string $id): \Illuminate\Http\JsonResponse
    {
        $category=$this->CategoryService->restoreDeleted($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Trashed Categories restored successfully',
            'book' => CategroyResource::make($category),
        ] , 200); // OK
    }

    /**
     * @throws \Exception
     */
    public function forceDelete(string $id): \Illuminate\Http\JsonResponse
    {
        $message=$this->CategoryService->ForceDelete($id);
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ] , 200); // OK
    }

}
