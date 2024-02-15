<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['locations.media', 'locations.trips' => function ($query) {
        $query->where('status', 'available');
        }])->get();
        $formattedCategories = $categories->map(function ($category) {
            return $category->formatForJson();
        });
        return response()->json($formattedCategories);
    }
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::create($data);
        $category->addMediaFromRequest('image')->toMediaCollection("categories");
        return response()->json([
        'message' => 'Category created successfully',
        'category' => $category], 201);
    }
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if (!$category) {return response()->json(['error' => 'Category not found'], 404);}
        $data = $request->all();
        $category->update($data);
        if ($request->hasFile('image')) {
            $new_image = $request->file('image');
            $category->clearMediaCollection('categories');
            $category->addMedia($new_image)->toMediaCollection('categories');
        }
        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ], 200);
    }
    public function show($category)
    {
         $category = Category::find($category);
        if (!$category) {return response()->json(['error' => 'Category not found'], 404);}
        $category->load('locations.trips', 'media');
        $category->media->transform(function ($media) {
            return [
                'media' =>  str_replace('http://localhost', '', $media->original_url)
            ];
        });
        return response()->json(['category' => $category], 200);
    }
    public function destroy($category)
    {
        $category = Category::find($category);
        if (!$category) {return response()->json(['error' => 'Category not found'], 404);}
        $category->delete();
        return response()->json([
        'message' => 'Category deleted successfully',
        ], 201);
    }
}
