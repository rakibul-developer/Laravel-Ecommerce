<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product_slug)
    {
        $product = Product::Where('slug', $product_slug)->first();
        $sizes = Size::all();
        $inventories = Inventory::with('color', 'size')->Where('product_id', $product->id)->get();
        return view('backend.inventory.index', compact('product', 'sizes', 'inventories'));
    }

    public function sizeSelect( Request $request )
    {
        $inventories = Inventory::Where('size_id', $request->size_id)->where('product_id', $request->product_id)->get();
        $color_id = $inventories->pluck('color_id')->toArray();
        $colors = Color::whereNotIn('id', $color_id)->get();
        $options = [];
        foreach ($colors as $color) {
            $options[] = '<option value="' . $color->id . '">' . $color->name . '</option>';
        }

        return response()->json($options);
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
            'size' => 'required',
            'color' => 'required',
            'stock' => 'required',
            'additional_price' => 'nullable',

        ]);
        Inventory::create([
            'product_id' => $request->product_id,
            'color_id' => $request->color,
            'size_id' => $request->size,
            'stock' => $request->stock,
            'additional_price' => $request->additional_price,
        ]);

        return back()->with('success', 'Inventory created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
