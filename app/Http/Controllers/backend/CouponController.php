<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::where('status', 1)->orderBy('id', 'desc')->get();
        $deactiveCoupons = Coupon::where('status', 2)->orderBy('id', 'desc')->get();
        $trashCoupons = Coupon::orderBy('id', 'desc')->onlyTrashed()->get();
        return view('backend.coupon.index', compact('coupons', 'deactiveCoupons', 'trashCoupons'));
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
            'name' => 'required',
            'amount' => 'required|integer',
            'applicable_amount' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        Coupon::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'applicable_amount' => $request->applicable_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return back()->with('success', 'Coupon Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $coupon = Coupon::where('id', $request->coupon_id)->where('status', 1)->first();

        $coupon_data = '<tr> <td> Coupon Name : ' . $coupon->name . '</td> </tr> <tr> <td> Amount : ' . $coupon->amount . '</td> </tr> <tr> <td> Applicable Amount : ' . $coupon->applicable_amount . '</td> </tr> <tr> <td> Start Date : ' . $coupon->start_date->isoFormat('dddd-MMMM-YYYY') . '</td> </tr> <tr> <td> End Date : ' . $coupon->end_date->isoFormat('dddd-MMMM-YYYY') . '</td> </tr>';

        return response()->json($coupon_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($coupon)
    {
        $coupon = Coupon::where('id', $coupon)->where('status', 1)->first();

        return view('backend.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|integer',
            'applicable_amount' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $coupon->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'applicable_amount' => $request->applicable_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return redirect(route('backend.coupon.index'))->with('success', 'Coupon Updated Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function status_acitve(Coupon $coupon)
    {
        $coupon->update([
            'status' => 1,
        ]);
        return back()->with('success', 'Coupon update successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function status_deacitve(Coupon $coupon)
    {
        $coupon->update([
            'status' => 2,
        ]);
        return back()->with('success', 'Coupon update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon is temporary deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function parmanentDestroy($id)
    {
        $data = Coupon::where('id', $id)->onlyTrashed()->first();

        $data->forceDelete();
        return back()->with('success', 'Category Parmanently Deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function restore($coupon)
    {
        Coupon::where('id', $coupon)->onlyTrashed()->restore();
        return back()->with('success', 'Coupon Restored successfully');
    }
}
