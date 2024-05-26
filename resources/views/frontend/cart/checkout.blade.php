@extends('layouts.frontendApp')

@section('title', 'Checkout')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/woocommerce-2.css') }}">
@endsection

@section('content')
    <!-- breadcrumb_section - start
                                                                                                                                    ================================================== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                <li>Checkout</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end
                                                                                                                                    ================================================== -->


    <!-- checkout-section - start
                                                                                                                                    ================================================== -->
    <section class="checkout-section section_space">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="woocommerce">
                        <div class="woocommerce-info">Returning customer? <a href="#" class="showlogin">Click here to
                                login</a></div>
                        <form method="post" class="login">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are
                                a new customer, please proceed to the Billing &amp; Shipping section.</p>
                            <p class="form-row form-row-first">
                                <label for="username">Username or email <span class="required">*</span></label>
                                <input type="text" class="input-text" name="username" id="username" />
                            </p>
                            <p class="form-row form-row-last">
                                <label for="password">Password <span class="required">*</span></label>
                                <input class="input-text" type="password" name="password" id="password" />
                            </p>
                            <div class="clear"></div>
                            <p class="form-row">
                                <input type="hidden" id="_wpnonce" name="_wpnonce" value="94dfaf2ac1" />
                                <input type="hidden" name="_wp_http_referer" value="/wp/?page_id=6" />
                                <input type="submit" class="button" name="login" value="Login" />
                                <input type="hidden" name="redirect" value="http://localhost/wp/?page_id=6" />
                                <label for="rememberme" class="inline">
                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> Remember me
                                </label>
                            </p>
                            <p class="lost_password">
                                <a href="http://localhost/wp/?page_id=7&amp;lost-password">Lost your password?</a>
                            </p>
                            <div class="clear"></div>
                        </form>
                        <div class="woocommerce-info">Have a coupon? <a href="#" class="showcoupon">Click here to
                                enter your code</a></div>
                        <form class="checkout_coupon" method="post">
                            <p class="form-row form-row-first">
                                <input type="text" name="coupon_code" class="input-text" placeholder="Coupon code"
                                    id="coupon_code" value="" />
                            </p>
                            <p class="form-row form-row-last">
                                <input type="submit" class="button" name="apply_coupon" value="Apply Coupon" />
                            </p>
                            <div class="clear"></div>
                        </form>
                        <form action="{{ url('/pay') }}" method="post"
                            class="checkout woocommerce-checkout needs-validation">
                            @csrf
                            <div class="col2-set" id="customer_details">
                                <div class="coll-1">
                                    <div class="woocommerce-billing-fields">
                                        <h3>Billing Details</h3>
                                        <p class="form-row form-row form-row-wide validate-required"
                                            id="billing_name_field">
                                            <label for="billing_name" class="">Name <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="text" class="input-text " name="billing_name" id="billing_name"
                                                placeholder="" value="{{ auth()->user()->name }}" />
                                        </p>
                                        <div class="clear"></div>
                                        {{-- <p class="form-row form-row form-row-wide" id="billing_company_field">
                                            <label for="billing_company" class="">Company Name</label>
                                            <input type="text" class="input-text " name="billing_company"
                                                id="billing_company" placeholder="" autocomplete="organization"
                                                value="" />
                                        </p> --}}
                                        <p class="form-row form-row form-row-first validate-required validate-email"
                                            id="billing_email_field">
                                            <label for="billing_email" class="">Email Address <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="email" class="input-text " name="billing_email"
                                                id="billing_email" placeholder="" autocomplete="email"
                                                value="{{ auth()->user()->email }}" />
                                        </p>
                                        <p class="form-row form-row form-row-last validate-required validate-phone"
                                            id="billing_phone_field">
                                            <label for="billing_phone" class="">Phone <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="tel" class="input-text " name="billing_phone"
                                                id="billing_phone" placeholder="Enter Your Phone Number"
                                                autocomplete="tel" value="{{ auth()->user()->userInfo->phone ?? '' }}" />
                                        </p>
                                        <div class="clear"></div>
                                        <p class="form-row form-row form-row-wide address-field validate-required"
                                            id="billing_address_1_field">
                                            <label for="billing_address_1" class="">Address <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="text" class="input-text " name="billing_address_1"
                                                id="billing_address_1" placeholder="Street address"
                                                autocomplete="address-line1"
                                                value="{{ auth()->user()->userInfo->address ?? '' }}" />
                                        </p>
                                        {{-- <p class="form-row form-row form-row-wide address-field"
                                            id="billing_address_2_field">
                                            <input type="text" class="input-text " name="billing_address_2"
                                                id="billing_address_2"
                                                placeholder="Apartment, suite, unit etc. (optional)"
                                                autocomplete="address-line2" value="" />
                                        </p> --}}
                                        <p class="form-row form-row address-field validate-postcode validate-required form-row-first  woocommerce-invalid-required-field"
                                            id="city_field">
                                            <label for="city" class="">Town / City <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="text" class="input-text " name="city" id="city"
                                                placeholder="Enter Your City" autocomplete="address-level2"
                                                value="{{ auth()->user()->userInfo->city ?? '' }}" />
                                        </p>
                                        <p class="form-row form-row form-row-last address-field validate-required validate-postcode"
                                            id="postcode_field">
                                            <label for="postcode" class="">Postcode / ZIP <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="text" class="input-text " name="postcode" id="postcode"
                                                placeholder="Enter Your Post Code" autocomplete="postal-code"
                                                value="{{ auth()->user()->userInfo->zip ?? '' }}" />
                                        </p>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="coll-2">
                                    <div class="woocommerce-shipping-fields">
                                        <h3>
                                            <label data-bs-toggle="collapse" data-bs-target="#ship-to-different-address"
                                                for="ship-to-different-address-checkbox" class="checkbox">Ship to a
                                                different address?
                                                <input id="ship-to-different-address-checkbox" class="input-checkbox"
                                                    type="checkbox" name="ship_to_different_address" value="1" />
                                            </label>
                                        </h3>
                                        <div id="ship-to-different-address" class="collapse">
                                            <p class="form-row form-row-first form-row-wide validate-required"
                                                id="shipping_name_field">
                                                <label for="shipping_name" class="">Name <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_name"
                                                    id="shipping_name" placeholder="Enter Your Name"
                                                    autocomplete="given-name" value="" />
                                            </p>
                                            {{-- <p class="form-row form-row form-row-wide" id="shipping_company_field">
                                                <label for="shipping_company" class="">Company Name</label>
                                                <input type="text" class="input-text " name="shipping_company"
                                                    id="shipping_company" placeholder="" autocomplete="organization"
                                                    value="" />
                                            </p> --}}
                                            <p class="form-row form-row form-row-last phone-field validate-required"
                                                id="shipping_phone_field">
                                                <label for="shipping_phone" class="">Phone<abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_phone"
                                                    id="shipping_phone" placeholder="Enter Your Phone Number"
                                                    autocomplete="phone" value="" />
                                            </p>
                                            <div class="clear"></div>
                                            <p class="form-row form-row form-row-wide address-field validate-required"
                                                id="shipping_address_1_field">
                                                <label for="shipping_address_1" class="">Address <abbr
                                                        class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_address"
                                                    id="shipping_address_1" placeholder="Street address"
                                                    autocomplete="address-line1" value="" />
                                            </p>
                                            {{-- <p class="form-row form-row form-row-wide address-field"
                                                id="shipping_address_2_field">
                                                <input type="text" class="input-text " name="shipping_address_2"
                                                    id="shipping_address_2"
                                                    placeholder="Apartment, suite, unit etc. (optional)"
                                                    autocomplete="address-line2" value="" />
                                            </p> --}}
                                            <p class="form-row form-row address-field validate-postcode validate-required form-row-first  woocommerce-invalid-required-field"
                                                id="shipping_city_field2">
                                                <label for="shipping_city" class="">Town / City <abbr
                                                        class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_city"
                                                    id="shipping_city3" placeholder="" autocomplete="address-level2"
                                                    value="" />
                                            </p>
                                            <p class="form-row form-row form-row-last address-field validate-required validate-postcode"
                                                id="shipping_postcode_field17">
                                                <label for="shipping_postcode" class="">Postcode / ZIP <abbr
                                                        class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_postcode"
                                                    id="shipping_postcode4" placeholder="" autocomplete="postal-code"
                                                    value="" />
                                            </p>
                                            <div class="clear"></div>
                                        </div>
                                        <p class="form-row form-row notes" id="order_comments_field">
                                            <label for="order_comments" class="">Order Notes</label>
                                            <textarea name="order_comments" class="input-text " id="order_comments"
                                                placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <h3 id="order_review_heading">Your order</h3>
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <table class="shop_table woocommerce-checkout-review-order-table">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $cart)
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    {{ $cart->inventory->product->title }} <strong
                                                        class="product-quantity">&times; {{ $cart->quantity }}</strong>
                                                </td>
                                                <td class="product-total">
                                                    <span class="woocommerce-Price-amount amount"><span
                                                            class="woocommerce-Price-currencySymbol">$
                                                        </span>{{ $cart->cart_total }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td><span class="woocommerce-Price-amount amount"><span
                                                        class="woocommerce-Price-currencySymbol">$
                                                    </span>{{ number_format($carts->sum('cart_total'), 2) }}</span>
                                            </td>
                                        </tr>
                                        <tr class="shipping">
                                            <th>Shipping</th>
                                            <td data-title="Shipping">
                                                @if (Session::get('shippingAmount') > 0)
                                                    <span> + {{ Session::get('shippingAmount') }}</span>
                                                @else
                                                    <span> Free </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if (Session::has('coupon'))
                                            <tr class="coupon">
                                                <th>Coupon({{ Session::get('coupon')['name'] }})</th>
                                                <td data-title="Shipping">
                                                    <span>- {{ Session::get('coupon')['amount'] }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td><strong><span class="woocommerce-Price-amount amount"><span
                                                            class="woocommerce-Price-currencySymbol">$
                                                        </span>{{ number_format($shipping_total, 2) }}</span></strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div id="payment" class="woocommerce-checkout-payment">
                                    <ul class="wc_payment_methods payment_methods methods">
                                        <li class="wc_payment_method payment_method_cheque">
                                            <input id="payment_method_cheque" type="radio" class="input-radio"
                                                name="payment_method" value="cheque" checked='checked'
                                                data-order_button_text="" />
                                            <!--grop add span for radio button style-->
                                            <span class='grop-woo-radio-style'></span>
                                            <!--custom change-->
                                            <label for="payment_method_cheque">
                                                Check Payments </label>
                                            <div class="payment_box payment_method_cheque">
                                                <p>Please send a check to Store Name, Store Street, Store Town, Store State
                                                    / County, Store Postcode.</p>
                                            </div>
                                        </li>
                                        <li class="wc_payment_method payment_method_paypal">
                                            <input id="payment_method_paypal" type="radio" class="input-radio"
                                                name="payment_method" value="paypal"
                                                data-order_button_text="Proceed to PayPal" />
                                            <!--grop add span for radio button style-->
                                            <span class='grop-woo-radio-style'></span>
                                            <!--custom change-->
                                            <label for="payment_method_paypal">
                                                PayPal <img src="assets/images/paypal.png"
                                                    alt="PayPal Acceptance Mark" /><a href="#" class="about_paypal"
                                                    title="What is PayPal?">What is PayPal?</a> </label>
                                            <div class="payment_box payment_method_paypal" style="display:none;">
                                                <p>Pay via PayPal; you can pay with your credit card if you don&#8217;t have
                                                    a PayPal account.</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="form-row place-order">
                                        <button type="submit" class="button alt" name="woocommerce_checkout_place_order"
                                            id="place_order"> Place Order </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout-section - end ================================================== -->
@endsection

@section('js')
    <script>
        (function(window, document) {
            var loader = function() {
                var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(
                    7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                loader);
        })(window, document);
    </script>D
@endsection
