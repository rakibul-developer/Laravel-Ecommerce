<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('categories')->select('id', 'image', 'title', 'slug', 'sku')->orderBy('id', 'desc')->paginate(10);
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $gallery_images = $request->file('gallery_image');

        $request->validate([
            "title" => 'required|unique:products,title|max:300',
            "categories" => 'required',
            "sku" => 'required|unique:products,sku',
            "short_description" => 'nullable|max:300',
            "description" => 'nullable',
            "price" => 'required|integer',
            "sale_price" => 'nullable|integer',
            "additional_information" => 'nullable',
            "image" => 'required|mimes:jpg,jpeg,png|max:512',
            "gallery_image.*" => 'nullable|mimes:jpg,jpeg,png|max:512'
        ]);

        if ($request->file('image')) {
            $image_name = Str::uuid() . '.' . $request->file('image')->extension();
            $image_upload = Image::make($request->file('image'))->crop(1000, 700)->save(public_path('storage/product/' . $image_name));
        }

        if ($image_upload) {
            $product = Product::create([
                "title" => $request->title,
                "user_id" => auth()->user()->id,
                "sku" => $request->sku,
                "short_description" => $request->short_description,
                "description" => $request->description,
                "price" => $request->price,
                "sale_price" => $request->sale_price,
                "add_info" => $request->additional_information,
                "image" => $image_name,
            ]);

            if ($product && $gallery_images) {
                foreach ($gallery_images as $gallery_image) {
                    $gallery_name = Str::uuid() . '.' . $gallery_image->extension();
                    Image::make($gallery_image)->crop(1000, 700)->save(public_path('storage/product/' . $gallery_name));

                    ProductGallery::create([
                        "product_id" => $product->id,
                        "image" => $gallery_name,
                    ]);
                }
            }
        }

        $product->categories()->attach($request->categories);
        return redirect()->route('backend.product.index')->with('success', 'Product created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('backend.product.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('backend.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "title" => 'required|unique:products,title,' . $product->id,
            "categories" => 'required',
            "sku" => 'required|unique:products,sku,' . $product->id,
            "short_description" => 'nullable|max:300',
            "description" => 'nullable',
            "price" => 'required|numeric',
            "sale_price" => 'nullable|numeric',
            "additional_information" => 'nullable',
            "image" => 'nullable|mimes:jpg,jpeg,png|max:512',
        ]);

        if ($request->file('image')) {
            if (file_exists(public_path('storage/product/' . $product->image))) {
                Storage::delete('product/' . $product->image);
            }
            $image_name = Str::uuid() . '.' . $request->file('image')->extension();
            $image_upload = Image::make($request->file('image'))->crop(1000, 700)->save(public_path('storage/product/' . $image_name));
        }else {
            $image_name = $product->image;
        }

        $product->update([
            "title" => $request->title,
            "user_id" => auth()->user()->id,
            "sku" => $request->sku,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "price" => $request->price,
            "sale_price" => $request->sale_price,
            "add_info" => $request->additional_information,
            "image" => $image_name,
        ]);

        $product->categories()->sync($request->categories);
        return back()->with('success', 'Product updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
