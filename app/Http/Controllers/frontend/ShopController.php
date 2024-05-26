<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function allProducts()
    {
        $products = Product::Where('status', 1)->orderBy('id', 'desc')->paginate(30);
        return view('frontend.shop', compact('products'));
    }

    public function singleProduct($slug)
    {
        $product = Product::with('galleries', 'inventories.size', 'inventories.color')->where('slug', $slug)->firstOrfail();
        $sizes = $product->inventories->unique('size_id');
        $user = User::where('id', auth()->user()->id)->with('orders.inventory_orders.inventory')->first();

        return view('frontend.singleShop', compact('product', 'sizes', 'user'));
    }

    public function shopColor(Request $request)
    {
        $inventories = Inventory::with('color')->where('product_id', $request->product_id)->where('size_id', $request->size_id)->get();

        $color_option = ['<option data-display="- Please select -">Choose A Option</option>'];

        foreach ($inventories as $inventory) {
            $color_option[] = '<option value="' . $inventory->color->id . '">' . $inventory->color->name . '</option>';
        }
        return response()->json($color_option);
    }

    public function shopStock(Request $request)
    {
        $inventory = Inventory::with('product')->where('product_id', $request->product_id)->where('size_id', $request->size_id)->where('color_id', $request->color_id)->first();
        
        if ($inventory->product->sale_price) {
            $price = $inventory->product->sale_price + $inventory->additional_price;
        }else {
            $price = $inventory->product->price + $inventory->additional_price;
        }

        $data = [];
        $data['stock'] = 'Stock : ';
        $data['stockValue'] = $inventory->stock;
        $data['additional_price'] = $inventory->additional_price;
        $data['price'] = $price;
        $data['inventory_id'] = $inventory->id;
        return response()->json($data);
    }
}
