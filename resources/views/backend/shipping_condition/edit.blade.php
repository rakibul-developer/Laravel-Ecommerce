@extends('layouts.backendApp')

@section('title', 'Shipping Condition Edit')

@section('content')
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-form__body card-body">
                    <form action="{{ route('backend.shippingcondition.update', $shippingCondition->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Location:</label>
                            <input type="text" class="form-control" name="location"
                                value="{{ $shippingCondition->location }}" placeholder="Location">
                            @error('location')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Shipping Amount:</label>
                            <input type="text" class="form-control" name="shipping_amount"
                                value="{{ $shippingCondition->shipping_amount }}" placeholder="Enter Shipping Amount">
                            @error('shipping_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    {{-- @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection
