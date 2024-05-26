@extends('layouts.frontendApp')

@section('title', 'User Deshboard')

@section('content')
    {{-- breadcrumb_section - start==================================================  --}}
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                <li>My Account</li>
            </ul>
        </div>
    </div>
    {{-- breadcrumb_section - end==================================================  --}}
    {{-- account_section - start==================================================  --}}
    <section class="account_section section_space">
        <div class="container">
            <div class="row">
                @include('frontend.userDeshboard.userSlideber')

                <div class="col col-lg-9">
                    <div class="account_content_area">
                        <h3>My Dashboard</h3>
                        <ul class="content_layout ul_li_block">
                            <table class="table mb-0 thead-border-top-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Total</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list align-baseline" id="staff">
                                    @foreach (auth()->user()->orders as $order)
                                        <tr class="order_parent">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->total }}</td>
                                            <td>{{ $order->order_status }}</td>
                                            <td>{{ $order->payment_status }}</td>
                                            <td>{{ $order->created_at->isoFormat('D-MM-YYYY') }}</td>
                                            <input type="hidden" value="{{ $order->id }}" class="order_id">
                                            <td>
                                                <button class="btn btn-primary viewButton" data-toggle="modal"
                                                    data-target="#viewPage">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- account_section - end==================================================  --}}
@endsection
