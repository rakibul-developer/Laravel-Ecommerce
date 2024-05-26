@extends('layouts.backendApp')

@section('title', 'Coupon Edit')

@section('content')
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="{{route('backend.coupon.update', $coupon->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Coupon Name:</label>
                            <input type="text" class="form-control" name="name" value="{{ $coupon->name }}"
                                placeholder="Name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Amount:</label>
                            <input type="number" class="form-control" name="amount" value="{{ $coupon->amount }}" placeholder="Enter Amount">
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Applicable Amount:</label>
                            <input type="number" class="form-control" name="applicable_amount" value="{{ $coupon->applicable_amount }}" placeholder="Enter Amount">
                            @error('applicable_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Start Date:</label>
                            <input type="date" class="form-control" name="start_date" value="{{ $coupon->start_date }}">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>End Date:</label>
                            <input type="date" class="form-control" name="end_date" value="{{ $coupon->end_date }}">
                            @error('end_date')
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
