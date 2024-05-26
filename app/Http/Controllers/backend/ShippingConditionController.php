<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ShippingCondition;
use Illuminate\Http\Request;

class ShippingConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippingConditions = ShippingCondition::orderBy('id', 'desc')->get();
        return view('backend.shipping_condition.index', compact('shippingConditions'));
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
            'location' => 'required',
            'shipping_amount' => 'required|integer'
        ]);

        ShippingCondition::create([
            'location' => $request->location,
            'shipping_amount' => $request->shipping_amount
        ]);

        return back()->with('success', 'Shipping Condition Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShippingCondition  $shippingCondition
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $shippingcondition = ShippingCondition::where('id', $request->shipping_id)->first();

        $shippingcondition_data = '<tr> <td> Location : ' . $shippingcondition->location . '</td> </tr> <tr> <td> Shipping Amount : ' . $shippingcondition->shipping_amount . '</td> </tr>';

        return response()->json($shippingcondition_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingCondition  $shippingCondition
     * @return \Illuminate\Http\Response
     */
    public function edit($shippingCondition)
    {
        $shippingCondition = ShippingCondition::where('id', $shippingCondition)->first();

        return view('backend.shipping_condition.edit', compact('shippingCondition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingCondition  $shippingCondition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shippingCondition)
    {
        $shipping = ShippingCondition::findOrFail($shippingCondition);
        $request->validate([
            'location' => 'required',
            'shipping_amount' => 'required|integer'
        ]);

        $shipping->update([
            'location' => $request->location,
            'shipping_amount' => $request->shipping_amount
        ]);

        return redirect(route('backend.shippingcondition.index'))->with('success', 'Shipping Condition Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingCondition  $shippingCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingCondition $shippingCondition)
    {
        //
    }
}
