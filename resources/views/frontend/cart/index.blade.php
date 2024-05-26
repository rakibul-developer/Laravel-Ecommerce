@extends('layouts.frontendApp')

@section('title', 'Carts')

@section('content')
    {{-- breadcrumb_section - start ==================================================  --}}
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </div>
    {{-- breadcrumb_section - end ==================================================  --}}
    {{-- cart_section - start ==================================================  --}}
    <section class="cart_section section_space">
        <div class="container">
            <div class="cart_update_wrap">
                <p class="mb-0"><i class="fal fa-check-square"></i> Shipping costs updated.</p>
            </div>

            <div class="cart_table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Size & Color</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts as $cart)
                            <tr class="cart_parent">
                                <td class="text-center">
                                    <div class="cart_product">
                                        <img src="{{ asset('storage/product/' . $cart->inventory->product->image) }}"
                                            alt="{{ $cart->inventory->product->title }}">
                                        <h3><a href="shop_details.html">{{ $cart->inventory->product->title }}</a></h3>
                                    </div>
                                </td>
                                <td>
                                    {{ $cart->inventory->size->name }} - {{ $cart->inventory->color->name }}
                                </td>
                                <td class="text-center">
                                    <span class="price_text">$</span>
                                    <span class="price_text price" id="price">
                                        @if ($cart->inventory->product->sale_price)
                                            {{ number_format($cart->inventory->product->sale_price + $cart->inventory->additional_price, 2) }}
                                        @else
                                            {{ number_format($cart->inventory->product->price + $cart->inventory->additional_price, 2) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="#">
                                        <div class="quantity_input">
                                            <input type="hidden" class="cart_id" value="{{ $cart->id }}">
                                            <input type="hidden" class="stock_limit" value="{{ $cart->inventory->stock }}">
                                            <button type="button" class="input_number_decrement">
                                                <i class="fal fa-minus"></i>
                                            </button>
                                            <input class="input_number" type="text" name="quantity[]"
                                                value="{{ $cart->quantity }}">
                                            <button type="button" class="input_number_increment">
                                                <i class="fal fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <p style="margin-bottom: 0px">
                                        {{ $cart->inventory->stock }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <span class="price_text">$</span>
                                    <span class="price_text total_price" id="total_price">
                                        @if ($cart->inventory->product->sale_price)
                                            {{ number_format(($cart->inventory->product->sale_price + $cart->inventory->additional_price) * $cart->quantity, 2) }}
                                        @else
                                            {{ number_format(($cart->inventory->product->price + $cart->inventory->additional_price) * $cart->quantity, 2) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('frontend.cart.destroy', $cart->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove_btn">
                                            <i class="fal fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="cart_btns_wrap">
                <div class="row">
                    <div class="col col-lg-6">
                        <form action="{{ route('frontend.cart.applyCoupon') }}" method="POST">
                            @csrf
                            <div class="coupon_form form_item mb-0">
                                <input type="text" name="coupon" placeholder="Coupon Code..."
                                    value="@if (Session::has('coupon')) {{ Session::get('coupon')['name'] }} @endif">
                                <button type="submit" class="btn btn_dark">Apply Coupon</button>
                                <div class="info_icon">
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="" data-bs-original-title="Your Info Here"
                                        aria-label="Your Info Here"></i>
                                </div>
                            </div>
                        </form>
                        {{-- @if (Session::has('error'))
                            <div class="alert alert-danger mt-3">{{ Session::get('error') }}</div>
                        @endif --}}
                    </div>

                    <div class="col col-lg-6">
                        <ul class="btns_group ul_li_right">
                            <li><a class="btn border_black" href="{{ route('frontend.cart.index') }}">Update Cart</a></li>
                            <li><a class="btn btn_dark checkout" href="{{ route('frontend.checkout.view') }}">Prceed To
                                    Checkout</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col col-lg-6">
                    <div class="calculate_shipping">
                        <h3 class="wrap_title">Calculate Shipping <span class="icon"><i
                                    class="far fa-arrow-up"></i></span></h3>
                        {{-- <form action="#"> --}}
                        <div class="select_option clearfix">
                            <select class="nice_select select_shipping">
                                <option data-display="Select Your Place" disabled selected>Select Your Option</option>
                                @foreach ($shippingConditions as $shippingCondition)
                                    <option value="{{ $shippingCondition->id }}">
                                        {{ $shippingCondition->location }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error_message"></span>
                        </div>
                        {{-- <div class="row">
                                <div class="col col-md-6">
                                    <div class="form_item">
                                        <input type="text" name="location" placeholder="State / Country">
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="form_item">
                                        <input type="text" name="postalcode" placeholder="Postcode / ZIP">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn_primary rounded-pill">Update Total</button> --}}
                        {{-- </form> --}}
                    </div>
                </div>

                <div class="col col-lg-6">
                    <div class="cart_total_table">
                        <h3 class="wrap_title">Cart Totals</h3>
                        <ul class="ul_li_block">
                            <li>
                                <span>Cart Subtotal</span>
                                <span>$
                                    <span id="sub_total" class="p-0">
                                        {{ number_format($carts->sum('cart_total'), 2, '.') }}</span>
                                </span>
                            </li>
                            <li>
                                <span>Shipping and Handling</span>
                                <span class="shipping_cost">
                                    {{ Session::has('shippingAmount') ? '+ ' . Session::get('shippingAmount') : 'Select Your Shipping Area' }}
                                </span>
                            </li>
                            @if (Session::has('coupon'))
                                <li>
                                    <span>{{ Session::get('coupon')['name'] }}</span>
                                    <span>- {{ Session::get('coupon')['amount'] }}</span>
                                </li>
                            @endif
                            <li>
                                <span>Order Total</span>
                                <span>$
                                    <span class="total_price p-0" id="total">
                                        @if (Session::has('coupon'))
                                            {{ number_format($carts->sum('cart_total') - number_format(Session::get('coupon')['amount']) + Session::get('shippingAmount'), 2) }}
                                        @else
                                            {{ number_format($carts->sum('cart_total') + Session::get('shippingAmount'), 2) }}
                                        @endif
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- cart_section - end ==================================================  --}}
    @foreach ($coupons as $coupon)
        @if (Session::has('coupon'))
            @if ($coupon->name == Session::get('coupon')['name'] && $coupon->end_date != Session::get('coupon')['end_date'])
                {{ Session::forget('coupon') }}
            @endif
        @endif
    @endforeach



@endsection

@section('js')
    <script>
        $(function() {
            var input_number_decrement = $('.input_number_decrement'),
                input_number_increment = $('.input_number_increment'),
                sub_total = $('#sub_total'),
                total = $('#total');

            input_number_increment.on('click', function() {
                var number = $(this).parent('.quantity_input').children('.input_number'),
                    stock_limit = $(this).parent('.quantity_input').children('.stock_limit').val(),
                    cart_id = $(this).parent('.quantity_input').children('.cart_id'),
                    price = $(this).parents('.cart_parent').find('.price'),
                    total_price = $(this).parents('.cart_parent').find('.total_price'),
                    shipping_id = $('.select_shipping').val();

                var inc = number.val();
                if (inc < parseInt(stock_limit)) {
                    inc++;
                    total_price.html(parseFloat(price.html() * inc).toFixed(2));

                }
                number.val(inc);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('frontend.cart.update') }}',
                    data: {
                        cart_id: cart_id.val(),
                        shipping_id: shipping_id,
                        user_id: '{{ auth()->user()->id }}',
                        quantity: inc,
                        total_price: total_price.html(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        sub_total.html(parseFloat(data.cart_total).toFixed(2));
                        total.html(parseFloat(data.total).toFixed(2));
                        console.log(data);
                    }
                });
            });

            input_number_decrement.on('click', function() {
                var number = $(this).parent('.quantity_input').children('.input_number'),
                    cart_id = $(this).parent('.quantity_input').children('.cart_id'),
                    price = $(this).parents('.cart_parent').find('.price'),
                    total_price = $(this).parents('.cart_parent').find('.total_price'),
                    shipping_id = $('.select_shipping').val();

                var dnc = number.val();
                if (dnc > 1) {
                    dnc--;
                    var update_total_price = total_price.html(parseFloat(price.html() * dnc).toFixed(2));
                }
                number.val(dnc);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('frontend.cart.update') }}',
                    data: {
                        cart_id: cart_id.val(),
                        shipping_id: shipping_id,
                        user_id: '{{ auth()->user()->id }}',
                        quantity: dnc,
                        total_price: total_price.html(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        sub_total.html(parseFloat(data.cart_total).toFixed(2));
                        total.html(parseFloat(data.total).toFixed(2));
                        console.log(data);
                    }
                });
            });

            $('.select_shipping').on('change', function() {
                var shipping_id = $('.select_shipping').val(),
                    shipping_cost = $('.shipping_cost');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('frontend.cart.applyShipping') }}',
                    data: {
                        shipping_id: shipping_id,
                        user_id: '{{ auth()->user()->id }}',
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.shipping.shipping_amount > 0) {
                            shipping_cost.html("+" + parseInt(data.shipping.shipping_amount));
                        } else {
                            shipping_cost.html('Free');
                        }
                        total.html(parseInt(data.shipping_total).toFixed(2));
                    }
                });
            });
        });
    </script>
@endsection
