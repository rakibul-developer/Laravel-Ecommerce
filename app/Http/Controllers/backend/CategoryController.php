<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with(['subCategories' => function ($q) {
            $q->withCount('products');
        }])->withCount('products')->where('parent_id', null)->orderBy('id', 'desc')->paginate(10);
        $trashCategories = Category::select('id', 'name', 'slug', 'image', 'status', 'parent_id')->onlyTrashed()->orderBy('id', 'desc')->paginate(10);
        return view('backend.category.index', compact('categories', 'trashCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|max:150|unique:categories,name',
            "parent" => 'nullable|integer',
            "description" => 'nullable|max:400',
            "image" => 'nullable|mimes:jpg,jpeg,png|max:512'
        ]);

        if ($request->file('image')) {
            $image_name = Str::uuid() . "." . $request->file('image')->extension();
            Image::make($request->file('image'))->crop(200, 256)->save(public_path('storage/category/' . $image_name));
        } else {
            $image_name = null;
        }

        Category::create([
            "name" => $request->name,
            "parent_id" => $request->parent,
            "description" => $request->description,
            "slug" => Str::slug($request->name),
            "image" => $image_name
        ]);

        return back()->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category Deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function parmanentDestroy($id)
    {
        $data = Category::where('id', $id)->onlyTrashed()->first();
        if ($data->image) {
            Storage::delete('category/' . $data->image);
        }
        $data->forceDelete();
        return back()->with('success', 'Category Parmanently Deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Category::where('id', $id)->onlyTrashed()->restore();
        return back()->with('success', 'Category Restored');
    }
}
