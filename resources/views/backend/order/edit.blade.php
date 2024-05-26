@extends('layouts.backendApp')

@section('title', 'Coupon Edit')

@section('content')
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Order Status</label>
                            <input type="text" class="form-control" name="order_status" value="{{$invoiceOrder->order_status}}"
                                placeholder="Order Status">
                            @error('order_status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Payment Status</label>
                            <input type="text" class="form-control" name="payment_status" value="{{$invoiceOrder->payment_status}}"
                                placeholder="Payment Status">
                            @error('payment_status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
