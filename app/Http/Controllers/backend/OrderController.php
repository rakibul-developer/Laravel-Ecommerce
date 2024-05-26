<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->all()) {

            $orders = Order::where(function ($q) use ($request) {
                if ($request->order_id) {
                    $q->where('id', 'LIKE', '%' . $request->order_id . '%');
                }
                if ($request->order_status) {
                    $q->where('order_status', 'LIKE', '%' . $request->order_status . '%');
                }
                if ($request->payment_status) {
                    $q->where('payment_status', 'LIKE', '%' . $request->payment_status . '%');
                }
                if ($request->from_date && $request->to_date) {
                    $q->whereBetween('created_at', [$request->from_date, $request->to_date]);
                }
                if ($request->from_date && $request->to_date === null) {
                    $q->whereDate('created_at', $request->from_date);
                }
            })->orderBy('id', 'desc')->paginate(10)->withQueryString();
        } else {
            $orders = Order::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        }
        return view('backend.order.index', compact('orders'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $order = Order::with('inventory_orders.inventory.product', 'inventory_orders.inventory.color', 'inventory_orders.inventory.size', 'user.userInfo', 'shipping')->where('id', $request->order_id)->first();

        // $order_data = '<tr> <td> Transaction Id : ' . $order->transaction_id . '</td> </tr> <tr> <td> Coupon Name : ' . $order->coupon_name . '</td> </tr> <tr> <td> Coupon Amount : ' . $order->coupon_amount . '</td> </tr> <tr> <td> Shipping Charge : ' . $order->shipping_charge . '</td> </tr> <tr> <td> Order Notes : ' . $order->order_notes . '</td> </tr> <tr> <td> Order Status : ' . $order->order_status . '</td> </tr> <tr> <td> Payment Status : ' . $order->payment_status . '</td> </tr> <tr> <td> Created At : ' . $order->created_at->isoFormat('d-mm-YYYY') . '</td></tr>';
        // $data = [];
        // $data['order_id'] = $order->id;
        // $data['total'] = $order->total;
        // $data['transaction_id'] = $order->transaction_id;
        // $data['coupon_name'] = $order->coupon_name ? $order->coupon_name : '_ _';
        // $data['coupon_amount'] = $order->coupon_amount ? $order->coupon_amount : '_ _';
        // $data['shipping_charge'] = $order->shipping_charge;
        // $data['order_notes'] = $order->order_notes ? $order->order_notes : '_ _';
        // $data['order_status'] = $order->order_status;
        // $data['payment_status'] = $order->payment_status;

        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($order)
    {
        $invoiceOrder = Order::where('id', $order)->first();

        return view('backend.order.edit', compact('invoiceOrder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
