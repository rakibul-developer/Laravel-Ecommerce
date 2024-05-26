<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\UserInfo;
use App\Models\Inventory;
use App\Mail\InvoiceOrder;
use Illuminate\Http\Request;
use App\Models\InventoryOrder;
use App\Models\ShippingAddress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        // return $request->all();
        $request->validate([
            "billing_phone" => 'required',
            "billing_address_1" => 'required'
            // "billing_city"=> 'required'
            // "billing_postcode8"=> 'required'
        ]);

        UserInfo::updateOrCreate([
            'user_id' => auth()->user()->id
        ], [
            "phone" => $request->billing_phone,
            "address" => $request->billing_address_1,
            "city" => "$request->city",
            "zip" => $request->postcode,
        ]);

        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $sub_total = 0;
        foreach ($carts as $cart) {
            if ($cart->inventory->stock >= $cart->quantity) {
                $price = (($cart->inventory->product->sale_price ?? $cart->inventory->product->price) + $cart->inventory->additional_price ?? 0) * $cart->quantity;
            } else {
                return back()->with('error', 'Product Stock Out');
            }
            $sub_total += $price;
        }
        if (Session::has('coupon')) {
            $total =  ($sub_total + Session::get('shippingAmount')) - Session::get('coupon')['amount'];
        } else {
            $total = $sub_total + Session::get('shippingAmount');
        }

        $post_data = array();
        $post_data['total_amount'] = $total;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = auth()->user()->name;
        $post_data['cus_email'] = auth()->user()->email;
        $post_data['cus_add1'] = auth()->user()->userInfo->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = auth()->user()->userInfo->city;
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = auth()->user()->userInfo->zip;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = auth()->user()->userInfo->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $order_insert = Order::create([
            'user_id' => auth()->user()->id,
            'total' => $post_data['total_amount'],
            'transaction_id' => $post_data['tran_id'],
            'coupon_name' => Session::get('coupon')['name'] ?? null,
            'coupon_amount' => Session::get('coupon')['amount'] ?? null,
            'shipping_charge' => Session::get('shippingAmount') ?? null,
            'order_notes' => $request->order_comments,
            'order_status' => 'Pending',
            'payment_status' => 'unpaid',
            'status' => true,
        ]);

        if ($order_insert) {
            foreach ($carts as $cart) {
                InventoryOrder::create([
                    "order_id" => $order_insert->id,
                    "inventory_id" => $cart->inventory_id,
                    "quantity" => $cart->quantity,
                    "amount" => $cart->inventory->product->sale_price ?? $cart->inventory->product->price,
                    "additional_price" => $cart->inventory->additional_price ?? 0,
                ]);
            }
        }

        if ($request->ship_to_different_address && $order_insert) {
            $request->validate([
                "shipping_name" => 'required',
                "shipping_phone" => 'required',
                "shipping_address" => 'required',
            ]);

            ShippingAddress::create([
                "order_id" => $order_insert->id,
                "name" => $request->shipping_name,
                "phone" => $request->shipping_phone,
                "address" => $request->shipping_address,
                "city" => $request->shipping_city,
                "zip" => $request->shipping_postcode,
            ]);
        }

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    // public function payViaAjax(Request $request)
    // {

    //     # Here you have to receive all the order data to initate the payment.
    //     # Lets your oder trnsaction informations are saving in a table called "orders"
    //     # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

    //     $post_data = array();
    //     $post_data['total_amount'] = '10'; # You cant not pay less than 10
    //     $post_data['currency'] = "BDT";
    //     $post_data['tran_id'] = uniqid(); // tran_id must be unique

    //     # CUSTOMER INFORMATION
    //     $post_data['cus_name'] = 'Customer Name';
    //     $post_data['cus_email'] = 'customer@mail.com';
    //     $post_data['cus_add1'] = 'Customer Address';
    //     $post_data['cus_add2'] = "";
    //     $post_data['cus_city'] = "";
    //     $post_data['cus_state'] = "";
    //     $post_data['cus_postcode'] = "";
    //     $post_data['cus_country'] = "Bangladesh";
    //     $post_data['cus_phone'] = '8801XXXXXXXXX';
    //     $post_data['cus_fax'] = "";

    //     # SHIPMENT INFORMATION
    //     $post_data['ship_name'] = "Store Test";
    //     $post_data['ship_add1'] = "Dhaka";
    //     $post_data['ship_add2'] = "Dhaka";
    //     $post_data['ship_city'] = "Dhaka";
    //     $post_data['ship_state'] = "Dhaka";
    //     $post_data['ship_postcode'] = "1000";
    //     $post_data['ship_phone'] = "";
    //     $post_data['ship_country'] = "Bangladesh";

    //     $post_data['shipping_method'] = "NO";
    //     $post_data['product_name'] = "Computer";
    //     $post_data['product_category'] = "Goods";
    //     $post_data['product_profile'] = "physical-goods";

    //     # OPTIONAL PARAMETERS
    //     $post_data['value_a'] = "ref001";
    //     $post_data['value_b'] = "ref002";
    //     $post_data['value_c'] = "ref003";
    //     $post_data['value_d'] = "ref004";


    //     #Before  going to initiate the payment order status need to update as Pending.
    //     $update_product = DB::table('orders')
    //         ->where('transaction_id', $post_data['tran_id'])
    //         ->updateOrInsert([
    //             'name' => $post_data['cus_name'],
    //             'email' => $post_data['cus_email'],
    //             'phone' => $post_data['cus_phone'],
    //             'amount' => $post_data['total_amount'],
    //             'status' => 'Pending',
    //             'address' => $post_data['cus_add1'],
    //             'transaction_id' => $post_data['tran_id'],
    //             'currency' => $post_data['currency']
    //         ]);

    //     $sslc = new SslCommerzNotification();
    //     # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
    //     $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

    //     if (!is_array($payment_options)) {
    //         print_r($payment_options);
    //         $payment_options = array();
    //     }
    // }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        // $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = Order::where('transaction_id', $tran_id)->first();
        $orderInventories = InventoryOrder::where('order_id', $order_details->id)->get();

        if ($order_details->order_status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount);

            if ($validation) {

                $order_details->update([
                    'order_status' => 'Processing',
                    'payment_status' => 'paid'
                ]);

                foreach ($orderInventories as $orderInventory) {
                    Inventory::where('id', $orderInventory->inventory_id)->decrement('stock', $orderInventory->quantity);
                    Cart::where('inventory_id', $orderInventory->inventory_id)->where('user_id', auth()->user()->id)->delete();
                }
                $request->session()->forget(['coupon', 'shippingAmount']);

                $pdf = Pdf::loadView('invoice.orderInvoice', compact('order_details', 'orderInventories'));

                $pdf->save(public_path('/storage/invoice/' . $order_details->transaction_id . '_invoice_pdf'));
                Invoice::create([
                    'order_id' => $order_details->id,
                    'invoice_path' => url('/') . '/storage/invoice/' . $order_details->transaction_id . '_invoice_pdf',
                    'invoice' => $order_details->transaction_id . '_invoice_pdf',
                ]);

                Mail::to(auth()->user()->email)->send(new InvoiceOrder($order_details, $orderInventories));

                return redirect()->route('frontend.shop')->with('success', 'Transaction is Successful');
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            return redirect()->route('frontend.shop')->with('info', 'Transaction is already Completed');
        } else {
            return back()->with('error', 'Invalid Transaction');
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = Order::where('transaction_id', $tran_id)->select('id', 'transaction_id', 'order_status', 'payment_status')->first();
        $orderInventorys = InventoryOrder::where('order_id', $order_details->id)->get();

        if ($order_details->order_status == 'Pending') {
            $order_details->update([
                'order_status' => 'Failed',
            ]);

            $request->session()->forget(['coupon', 'shippingAmount']);
            return redirect()->route('frontend.cart.index')->with('error', 'Transaction is Falied');
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            return redirect()->route('frontend.shop')->with('info', 'Transaction is already Successful');
        } else {
            return back()->with('error', 'Invalid is Transaction');
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = Order::where('transaction_id', $tran_id)->select('id', 'transaction_id', 'order_status', 'payment_status')->first();

        if ($order_details->order_status == 'Pending') {
            $order_details->update([
                'order_status' => 'Canceled',
            ]);

            InventoryOrder::where('order_id', $order_details->id)->delete();
            $order_details->delete();

            $request->session()->forget(['coupon', 'shippingAmount']);
            return redirect()->route('frontend.cart.index')->with('info', 'Transaction is Cancel');
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            return redirect()->route('frontend.shop')->with('info', 'Transaction is already Successful');
        } else {
            return back()->with('error', 'Invalid is Transaction');
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = Order::where('transaction_id', $tran_id)->select('id', 'transaction_id', 'order_status', 'payment_status')->first();
            $orderInventorys = InventoryOrder::where('order_id', $order_details->id)->get();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->total);
                if ($validation == TRUE) {

                    $order_details->update([
                        'order_status' => 'Processing',
                        'payment_status' => 'paid'
                    ]);

                    foreach ($orderInventorys as $orderInventory) {
                        Inventory::where('id', $orderInventory->inventory_id)->decrement('stock', $orderInventory->quantity);
                        Cart::where('inventory_id', $orderInventory->inventory_id)->where('user_id', auth()->user()->id)->delete();
                    }
                    $request->session()->forget(['coupon', 'shippingAmount']);
                    return redirect()->route('frontend.shop')->with('success', 'Transaction is Successfully completed');
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                return redirect()->route('frontend.shop')->with('info', 'Transaction is already successfully Completed');
            } else {
                return back()->with('error', 'Invalid Transaction');
            }
        } else {
            return back()->with('error', 'Invalid Data');
        }
    }
}
