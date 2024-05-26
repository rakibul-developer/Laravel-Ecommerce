@extends('layouts.backendApp')
@section('title', 'Invoice Details')

@section('content')
    <div class="row">
        <div class="col-lg-8 text-center m-auto">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('backend.order.index') }}" method="get">
                <div class="row">
                    <div class="col-lg-3 col-xl-2">
                        <input type="search" placeholder="Order Id" name="order_id" class="form-control"
                            value="{{ request()->order_id }}">
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <select name="order_status" class="form-control">
                            <option selected disabled>Order Status</option>
                            <option value="pending" {{ request()->order_status === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Processing" {{ request()->order_status === 'Processing' ? 'selected' : '' }}>
                                Proccessing</option>
                            <option value="cancle" {{ request()->order_status === 'cancle' ? 'selected' : '' }}>Cancle
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <select name="payment_status" class="form-control">
                            <option selected disabled>Payment Status</option>
                            <option value="paid" {{ request()->payment_status === 'paid' ? 'selected' : '' }}>Paid
                            </option>
                            <option value="unpaid" {{ request()->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid
                            </option>
                            <option value="cancle" {{ request()->payment_status === 'cancle' ? 'selected' : '' }}>Cancle
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <input type="date" name="from_date" class="form-control" value="{{ request()->from_date }}">
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <input type="date" name="to_date" class="form-control"
                            value="{{ request()->from_date ? request()->to_date : '' }}">
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <input type="submit" class="form-control btn btn-success" value="Search">
                    </div>
                    <div class="col-lg-3 col-xl-3 mx-auto mt-3">
                        <a href="{{ route('backend.order.index') }}" type="submit"
                            class="form-control btn btn-danger">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-tabs-basic nav" role="tablist">
                    <a href="#active" class="active" data-toggle="tab" role="tab" aria-selected="true">Active</a>
                    <a href="#deactive" data-toggle="tab" role="tab" aria-selected="false">Deactive</a>
                    <a href="#trash" data-toggle="tab" role="tab" aria-selected="false">Trash</a>
                </div>
                <div class="card-body tab-content">
                    <div class="tab-pane active show fade" id="active">
                        <div class="table-responsive border-bottom" data-toggle="lists">

                            <table class="table mb-0 thead-border-top-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Total</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="staff">
                                    @foreach ($orders as $order)
                                        <tr class="order_parent">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->total }}</td>
                                            <td>{{ $order->order_status }}</td>
                                            <td>{{ $order->payment_status }}</td>
                                            <td>{{ $order->created_at->isoFormat('D-MM-YYYY') }}</td>
                                            <input type="hidden" value="{{ $order->id }}" class="order_id">
                                            <td>
                                                <a href="{{ route('backend.order.edit', $order->id) }}"
                                                    class="mb-1 m-1 btn btn-sm btn-primary">Edit</a>
                                                <button class="mb-1 m-1 btn btn-sm btn-info viewButton" data-toggle="modal"
                                                    data-target="#viewPage">View</button>
                                                <a href="" class="mb-1 m-1 btn btn-sm btn-warning">Deactive</a>
                                                <form class="d-inline" action="" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="mb-1 m-1 btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 border-top pt-2">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="deactive">
                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Applicable Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="staff">
                                {{-- @foreach ($deactiveCoupons as $coupon) --}}
                                {{-- <tr>
                                        <td>{{ $coupon->id }}</td>
                                        <td>{{ $coupon->name }}</td>
                                        <td>{{ $coupon->amount }}</td>
                                        <td>{{ $coupon->applicable_amount }}</td>
                                        <td>{{ $coupon->start_date->isoFormat('D-MMM-YYYY') }}</td>
                                        <td>{{ $coupon->end_date->isoFormat('D-MMM-YYYY') }}</td>
                                        <td>
                                            <a href="{{ route('backend.coupon.status_acitve', $coupon->id) }}"
                                                class="mb-1 m-1 btn btn-sm btn-success">Active</a>
                                        </td>
                                    </tr> --}}
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="trash">
                        <div class="table-responsive border-bottom" data-toggle="lists">
                            <div class="table-responsive border-bottom" data-toggle="lists">
                                <table class="table mb-0 thead-border-top-0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Applicable Amount</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="staff">
                                        {{-- @foreach ($trashCoupons as $coupon)
                                            <tr>
                                                <td>{{ $coupon->id }}</td>
                                                <td>{{ $coupon->name }}</td>
                                                <td>{{ $coupon->amount }}</td>
                                                <td>{{ $coupon->applicable_amount }}</td>
                                                <td>{{ $coupon->start_date->isoFormat('D-MMM-YYYY') }}</td>
                                                <td>{{ $coupon->end_date->isoFormat('D-MMM-YYYY') }}</td>
                                                <td>
                                                    <a href="{{ route('backend.coupon.restore', $coupon->id) }}"
                                                        class="mb-1 m-1 btn btn-sm btn-info">Restore</a>
                                                    <form class="d-inline"
                                                        action="{{ route('backend.coupon.parmanentDelete', $coupon->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="mb-1 m-1 btn btn-sm btn-danger parmanent_delete">Parmanently
                                                            Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 border-top pt-2">
                                {{-- {{ $orders->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<!-- Modal -->
<div class="modal fade" id="viewPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <table class="table mb-0 thead-border-top-0"> --}}
                <h1 class="pb-3 text-center">Order Details</h1>
                {{-- <tbody class="list order_data" id="staff"> --}}
                <div class="card">
                    <div class="card-header">
                        Order Information
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Order Id</td>
                                <td>:</td>
                                <td class="order_id"></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>:</td>
                                <td class="total"></td>
                            </tr>
                            <tr>
                                <td>Transaction Id</td>
                                <td>:</td>
                                <td class="transaction_id"></td>
                            </tr>
                            <tr>
                                <td>Coupon Name</td>
                                <td>:</td>
                                <td class="coupon_name"></td>
                            </tr>
                            <tr>
                                <td>Coupon Amount</td>
                                <td>:</td>
                                <td class="coupon_amount"></td>
                            </tr>
                            <tr>
                                <td>Shipping Charge</td>
                                <td>:</td>
                                <td class="shipping_charge"></td>
                            </tr>
                            <tr>
                                <td>Order Notes</td>
                                <td>:</td>
                                <td class="order_notes"></td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>:</td>
                                <td class="order_status"></td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td>:</td>
                                <td class="payment_status"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Product Information
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Product Title</td>
                                <td>:</td>
                                <td class="product_title"></td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td>:</td>
                                <td class="quantity"></td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>:</td>
                                <td class="amount"></td>
                            </tr>
                            <tr>
                                <td>Additionl Price</td>
                                <td>:</td>
                                <td class="additional_price"></td>
                            </tr>
                            <tr>
                                <td>Color</td>
                                <td>:</td>
                                <td class="color"></td>
                            </tr>
                            <tr>
                                <td>Size</td>
                                <td>:</td>
                                <td class="size"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        User Information
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td class="name"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td class="email"></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td class="phone"></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td class="address"></td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>:</td>
                                <td class="city"></td>
                            </tr>
                            <tr>
                                <td>Size</td>
                                <td>:</td>
                                <td class="zip"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shippingInfo">
                    <div class="card-header">
                        Shipping Information
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td class="shipping_name"></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td class="shipping_phone"></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td class="shipping_address"></td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>:</td>
                                <td class="shipping_city"></td>
                            </tr>
                            <tr>
                                <td>Size</td>
                                <td>:</td>
                                <td class="shipping_zip"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- </tbody> --}}
                {{-- </table> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            var viewButton = $('.viewButton');

            $('.parmanent_delete').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        $(this).parent('form').submit();
                    }
                })
            });

            viewButton.on('click', function() {
                var order_id = $(this).parents('.order_parent').find('.order_id');
                
                $.ajax({
                    type: 'POST',
                    url: '{{ route('backend.order.show') }}',
                    data: {
                        order_id: order_id.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $('.order_id').html(data.id);
                        $('.total').html(data.total);
                        $('.transaction_id').html(data.transaction_id);
                        $('.coupon_name').html(data.coupon_name ? data.coupon_name : '_ _');
                        $('.coupon_amount').html(data.coupon_amount ? data.coupon_name : '_ _');
                        $('.shipping_charge').html(data.shipping_charge ? data.shipping_charge :
                            'Free');
                        $('.order_notes').html(data.order_notes ? data.order_notes : '_ _');
                        $('.order_status').html(data.order_status);
                        $('.payment_status').html(data.payment_status);
                        data.inventory_orders.forEach(value => {
                            $('.product_title').html(value.inventory.product.title);
                            $('.quantity').html(value.quantity);
                            $('.amount').html(value.amount);
                            $('.additional_price').html(value.additional_price ? value
                                .additional_price : '_ _');
                            $('.color').html(value.inventory.color.name);
                            $('.size').html(value.inventory.size.name);
                        });
                        $('.name').html(data.user.name);
                        $('.email').html(data.user.email);
                        $('.phone').html(data.user.user_info.phone);
                        $('.address').html(data.user.user_info.address);
                        $('.city').html(data.user.user_info.city);
                        $('.zip').html(data.user.user_info.zip);
                        if (data.shipping) {
                            $('.shipping_name').html(data.shipping.name);
                            $('.shipping_phone').html(data.shipping.phone);
                            $('.shipping_address').html(data.shipping.address);
                            $('.shipping_city').html(data.shipping.city);
                            $('.shipping_zip').html(data.shipping.zip);
                        }else{
                            $('.shipping_name').html('_ _');
                            $('.shipping_phone').html('_ _');
                            $('.shipping_address').html('_ _');
                            $('.shipping_city').html('_ _');
                            $('.shipping_zip').html('_ _');
                        }
                    }
                });
            });

        });
    </script>
@endsection
