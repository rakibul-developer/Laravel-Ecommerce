<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\ShippingCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::with('inventory', 'inventory.product', 'inventory.size', 'inventory.color')->where('user_id', auth()->user()->id)->get();
        $coupons  = Coupon::get();
        $shippingConditions = ShippingCondition::get();
        return view('frontend.cart.index', compact('carts', 'coupons', 'shippingConditions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "inventory_id" => 'required',
            "quantity" => 'required',
            "total" => 'required',
        ]);
        Cart::create([
            "user_id" => auth()->user()->id,
            "inventory_id" => $request->inventory_id,
            "quantity" => $request->quantity,
            "cart_total" => $request->total,
        ]);

        return redirect()->route('frontend.cart.index')->with('success', 'Cart added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)->where('id', $request->cart_id)->first();
        $shipping = ShippingCondition::where('id', $request->shipping_id)->first();
        $cart->update([
            'quantity' => $request->quantity,
            'cart_total' => $request->total_price
        ]);
        $cart_total = Cart::where('user_id', $request->user_id)->sum('cart_total');
        if ($shipping) {
            $total = ($cart_total + $shipping->shipping_amount) - (Session::has('coupon') ? Session::get('coupon')['amount'] : 0);
        } else {
            $total = $cart_total - (Session::has('coupon') ? Session::get('coupon')['amount'] : 0);
        }

        $cart_data = [
            'cart_total' => $cart_total,
            'total' => $total,
        ];
        return response()->json($cart_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Cart delete successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('name', $request->coupon)->first();
        $cart_total = Cart::where('user_id', auth()->user()->id)->sum('cart_total');
        if ($coupon) {
            if ($coupon->applicable_amount < $cart_total) {
                if ($coupon->start_date < now()) {
                    if ($coupon->end_date > now()) {
                        $applyCoupon = ([
                            'name' => $coupon->name,
                            'amount' => $coupon->amount,
                            'end_date' => $coupon->end_date,
                        ]);
                        Session::put('coupon', $applyCoupon);
                        return back();
                    } else {
                        return back()->with('error', 'Date Expired!');
                    }
                } else {
                    return back()->with('error', 'Invalid Coupon!');
                }
            } else {
                return back()->with('error', 'Amount is low!');
            }
        } else {
            return back()->with('error', 'Invalid Coupon!');
        }
        return $coupon;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function applyShipping(Request $request)
    {
        $shipping = ShippingCondition::where('id', $request->shipping_id)->first();
        $cart_total = Cart::where('user_id', auth()->user()->id)->sum('cart_total');
        if (Session::has('coupon')) {
            $shipping_total =  ($cart_total + $shipping->shipping_amount) - Session::get('coupon')['amount'];
        } else {
            $shipping_total = $cart_total + $shipping->shipping_amount;
        }
        Session::put('shippingAmount', $shipping->shipping_amount);
        $shipping_data = [
            'shipping' => $shipping,
            'cart_total' => $cart_total,
            'shipping_total' => $shipping_total
        ];
        return response()->json($shipping_data);
    }

    public function checkoutView()
    {
        $carts = Cart::with('inventory', 'inventory.product')->where('user_id', auth()->user()->id)->get();
        if (Session::has('shippingAmount')) {
            if (Session::has('coupon')) {
                $shipping_total =  ($carts->sum('cart_total') + Session::get('shippingAmount')) - Session::get('coupon')['amount'];
            } else {
                $shipping_total = $carts->sum('cart_total') + Session::get('shippingAmount');
            }
        } else {
            return back()->with('error', 'Invalid Shipping Area');
        }
        return view('frontend.cart.checkout', compact('carts', 'shipping_total'));
    }
}
