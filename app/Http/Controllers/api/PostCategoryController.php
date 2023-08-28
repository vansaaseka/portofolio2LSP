<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryDetailResource;
use App\Http\Resources\CategoryResource;
use App\Models\AdminCategory;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role_id;
        
        $categories = PostCategory::query();

        if ($role != 1) {
            $categories->where('is_active', 1);
        }

        $categories = $categories->get();

        $data = CategoryResource::collection($categories->all());

        if($data) {
            return response()->json([
                'message' => 'success',
                'categories' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required',
        ]);

        $dataAdmin = [
            'name' => $request->name
        ];

        AdminCategory::create($dataAdmin);

        $category = PostCategory::create($validatedData);
        $data = new CategoryResource($category);

        if($data) {
            return response()->json([
                'message' => 'success',
                'category' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function update(Request $request, PostCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        if($request->slug != $category->slug) {
            $validatedData['slug'] = 'required';
        }

        $result = PostCategory::where('id', $category->id)
            ->update($validatedData);

        if($result !== 0) {
            return response()->json([
                "message" => "Update Category Success"
            ], 200);
        } 

        return response()->json([
            "message" => "Update Category Failed"
        ], 400);
    }

    public function toggleStatus(PostCategory $category) {
        $data = PostCategory::where('id', $category->id);

        if($category->is_active == 0) {
            $data->update(['is_active' => 1]);
        } else if ($category->is_active == 1) {
            $data->update(['is_active' => 0]);
        }
        
        if($data) {
            return response()->json([
                'message' => 'success',
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function destroy($id)
    {
        AdminCategory::destroy($id);

        $result = PostCategory::destroy($id);

        if($result !== 0) {
            return response()->json([
                "message" => "Delete Category Success"
            ], 200);
        } 

        return response()->json([
            "message" => "Delete Category Failed"
        ], 400);
    }
}