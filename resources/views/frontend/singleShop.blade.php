@extends('layouts.frontendApp')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
    {{-- breadcrumb_section - start ==================================================  --}}
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                <li>Product Details</li>
            </ul>
        </div>
    </div>
    {{-- breadcrumb_section - end ==================================================  --}}
    {{-- product_details - start ==================================================  --}}
    <section class="product_details section_space pb-0">
        <div class="container">
            <div class="row">
                <div class="col col-lg-6">
                    <div class="product_details_image">
                        <div class="details_image_carousel">
                            @foreach ($product->galleries as $gallary)
                                <div class="slider_item">
                                    <img src="{{ asset('storage/product/' . $gallary->image) }}"
                                        alt="{{ $product->title }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="details_image_carousel_nav">
                            @foreach ($product->galleries as $gallary)
                                <div class="slider_item">
                                    <img src="{{ asset('storage/product/' . $gallary->image) }}" alt="$product->title">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product_details_content">
                        <h2 class="item_title">{{ $product->title }}</h2>
                        <p>{{ $product->short_description }}</p>
                        <div class="item_review">
                            <ul class="rating_star ul_li">
                                <li><i class="fas fa-star"></i>&gt;</li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star-half-alt"></i></li>
                            </ul>
                            <span class="review_value">3 Rating(s)</span>
                        </div>

                        <div class="item_price">
                            <span>$
                                @if ($product->sale_price)
                                    <span class="product_price">{{ $product->sale_price }}</span>
                                @else
                                    <span class="product_price">{{ $product->price }}</span>
                                @endif
                                {{-- <span class="product_price">{{ $product->sale_price ?? $product->price }}</span> --}}
                            </span>
                            @if ($product->sale_price)
                                <del>{{ $product->price }}</del>
                            @endif
                        </div>
                        <hr>

                        <div class="item_attribute">
                            <h3 class="title_text">Options <span class="underline"></span></h3>
                            <form action="#">
                                <div class="row">
                                    <div class="col col-md-6">
                                        <div class="select_option clearfix">
                                            <h4 class="input_title">Size *</h4>
                                            <select class="size_box nice_select" name="size">
                                                <option data-display="- Please select -">Choose A Option</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->size->id }}">{{ $size->size->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col col-md-6">
                                        <div class="select_option clearfix">
                                            <h4 class="input_title">Color *</h4>
                                            <select disabled class="color_box form-control" name="color">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->any())
                                    <span class="repuired_text">Repuired Fiields *</span>
                                @endif

                                <span class="repuired_text"><span class="stock"></span><span
                                        class="stock_limit"></span></span>
                            </form>
                        </div>

                        <form action="{{ route('frontend.cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="inventory_id" id="inventory_id">
                            <input type="hidden" name="total" id="total">
                            <div class="quantity_wrap">
                                <div class="quantity_input">
                                    <button type="button" class="input_number_decrement" disabled>
                                        <i class="fal fa-minus"></i>
                                    </button>
                                    <input class="input_number" name="quantity" type="text" value="1">
                                    <button type="button" class="input_number_increment" disabled>
                                        <i class="fal fa-plus"></i>
                                    </button>
                                </div>

                                <div class="total_price">Total: $<span
                                        class="total_inventory_price">{{ $product->sale_price ?? $product->price }}</span>
                                </div>
                            </div>

                            {{-- @if ($errors->any())
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif --}}

                            <ul class="default_btns_group ul_li">
                                <li><button type="submit" class="btn btn_primary addtocart_btn">Add To Cart</button></li>
                                <li><a href="#!"><i class="far fa-compress-alt"></i></a></li>
                                <li><a href="#!"><i class="fas fa-heart"></i></a></li>
                            </ul>
                        </form>

                        <ul class="default_share_links ul_li">
                            <li>
                                <a class="facebook" href="#!">
                                    <span><i class="fab fa-facebook-square"></i> Like</span>
                                    <small>10K</small>
                                </a>
                            </li>
                            <li>
                                <a class="twitter" href="#!">
                                    <span><i class="fab fa-twitter-square"></i> Tweet</span>
                                    <small>15K</small>
                                </a>
                            </li>
                            <li>
                                <a class="google" href="#!">
                                    <span><i class="fab fa-google-plus-square"></i> Google+</span>
                                    <small>20K</small>
                                </a>
                            </li>
                            <li>
                                <a class="share" href="#!">
                                    <span><i class="fas fa-plus-square"></i> Share</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="details_information_tab">
                <ul class="tabs_nav nav ul_li" role="tablist">
                    <li>
                        <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button"
                            role="tab" aria-controls="description_tab" aria-selected="true">
                            Description
                        </button>
                    </li>
                    <li>
                        <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button"
                            role="tab" aria-controls="additional_information_tab" aria-selected="false">
                            Additional information
                        </button>
                    </li>
                    <li>
                        <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab"
                            aria-controls="reviews_tab" aria-selected="false">
                            Reviews(2)
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                        {!! $product->description !!}
                    </div>

                    <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                        {!! $product->add_info !!}
                    </div>

                    <div class="tab-pane fade" id="reviews_tab" role="tabpanel">
                        <div class="average_area">
                            <h4 class="reviews_tab_title">Average Ratings</h4>
                            <div class="row align-items-center">
                                <div class="col-md-5 order-last">
                                    <div class="average_rating_text">
                                        <ul class="rating_star ul_li_center">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star-half-alt"></i></li>
                                        </ul>
                                        <p class="mb-0">
                                            Average Star Rating: <span>4.3 out of 5</span> (2 vote)
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="product_ratings_progressbar">
                                        <ul class="five_star ul_li">
                                            <li><span>5 Star</span></li>
                                            <li>
                                                <div class="progress_bar"></div>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                        <ul class="four_star ul_li">
                                            <li><span>4 Star</span></li>
                                            <li>
                                                <div class="progress_bar"></div>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fal fa-star"></i>
                                            </li>
                                        </ul>
                                        <ul class="three_star ul_li">
                                            <li><span>3 Star</span></li>
                                            <li>
                                                <div class="progress_bar"></div>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fal fa-star"></i>
                                                <i class="fal fa-star"></i>
                                            </li>
                                        </ul>
                                        <ul class="two_star ul_li">
                                            <li><span>2 Star</span></li>
                                            <li>
                                                <div class="progress_bar"></div>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fal fa-star"></i>
                                                <i class="fal fa-star"></i>
                                                <i class="fal fa-star"></i>
                                            </li>
                                        </ul>
                                        <ul class="one_star ul_li">
                                            <li><span>1 Star</span></li>
                                            <li>
                                                <div class="progress_bar"></div>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                                <i class="fal fa-star"></i>
                                                <i class="fal fa-star"></i>
                                                <i class="fal fa-star"></i>
                                                <i class="fal fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="customer_reviews">
                            <h4 class="reviews_tab_title">2 reviews for this product</h4>
                            <div class="customer_review_item clearfix">
                                <div class="customer_image">
                                    <img src="assets/images/team/team_1.jpg" alt="image_not_found">
                                </div>
                                <div class="customer_content">
                                    <div class="customer_info">
                                        <ul class="rating_star ul_li">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star-half-alt"></i></li>
                                        </ul>
                                        <h4 class="customer_name">Aonathor troet</h4>
                                        <span class="comment_date">JUNE 2, 2021</span>
                                    </div>
                                    <p class="mb-0">Nice Product, I got one in black. Goes with anything!</p>
                                </div>
                            </div>

                            <div class="customer_review_item clearfix">
                                <div class="customer_image">
                                    <img src="assets/images/team/team_2.jpg" alt="image_not_found">
                                </div>
                                <div class="customer_content">
                                    <div class="customer_info">
                                        <ul class="rating_star ul_li">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star-half-alt"></i></li>
                                        </ul>
                                        <h4 class="customer_name">Danial obrain</h4>
                                        <span class="comment_date">JUNE 2, 2021</span>
                                    </div>
                                    <p class="mb-0">
                                        Great product quality, Great Design and Great Service.
                                    </p>
                                </div>
                            </div>
                        </div>

                        @auth
                            @foreach ($user->orders as $order)
                                @foreach ($order->inventory_orders as $inventory_order)
                                    @if ($inventory_order->inventory->product_id == $product->id)
                                        <div class="customer_review_form">
                                            <h4 class="reviews_tab_title">Add a review</h4>
                                            <p>
                                                Your email address will not be published. Required fields are marked *
                                            </p>
                                            <form action="#">
                                                <section class='rating-widget'>

                                                    <!-- Rating Stars Box -->
                                                    <div class='rating-stars text-center'>
                                                        <ul id='stars'>
                                                            <li class='star' title='Poor' data-value='1'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' title='Fair' data-value='2'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' title='Good' data-value='3'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' title='Excellent' data-value='4'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' title='WOW!!!' data-value='5'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class='success-box'>
                                                        <div class='clearfix'></div>
                                                        <img alt='tick image' width='32'
                                                            src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K' />
                                                        <div class='text-message'></div>
                                                        <div class='clearfix'></div>
                                                    </div>
                                                </section>

                                                <input type="hidden" class="rating_value" value="0">
                                                <div class="form_item">
                                                    <textarea name="comment" placeholder="Your Review*"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn_primary">Submit Now</button>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        @endauth
                    </div>
                </div>
            </div>



        </div>
    </section>
    {{-- product_details - end ================================================== --}}
    {{-- related_products_section - start ==================================================  --}}
    <section class="related_products_section section_space">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="best-selling-products related-product-area">
                        <div class="sec-title-link">
                            <h3>Related products</h3>
                            <div class="view-all"><a href="#">View all<i class="fal fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="product-area clearfix">
                            <div class="grid">
                                <div class="product-pic">
                                    <img src="assets/images/shop/product_img_12.png" alt="">
                                    <div class="actions">
                                        <ul>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Favourite</title>
                                                        <path
                                                            d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z">
                                                        </path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Shuffle</title>
                                                        <path
                                                            d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7">
                                                        </path>
                                                        <path
                                                            d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17">
                                                        </path>
                                                        <path d="M19 4L22 7L19 10"></path>
                                                        <path d="M19 13L22 16L19 19"></path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup"
                                                    role="button" tabindex="0"><svg width="48px" height="48px"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Visible (eye)</title>
                                                        <path
                                                            d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h4><a href="#">Macbook Pro</a></h4>
                                    <p><a href="#">Apple MacBook Pro13.3″ Laptop with Touch ID </a></p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="price">
                                        <ins>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi>
                                                    <span class="woocommerce-Price-currencySymbol">$</span>471.48
                                                </bdi>
                                            </span>
                                        </ins>
                                    </span>
                                    <div class="add-cart-area">
                                        <button class="add-to-cart">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="product-pic">
                                    <img src="assets/images/shop/product-img-21.png" alt="">
                                    <span class="theme-badge">Sale</span>
                                    <div class="actions">
                                        <ul>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Favourite</title>
                                                        <path
                                                            d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z">
                                                        </path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Shuffle</title>
                                                        <path
                                                            d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7">
                                                        </path>
                                                        <path
                                                            d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17">
                                                        </path>
                                                        <path d="M19 4L22 7L19 10"></path>
                                                        <path d="M19 13L22 16L19 19"></path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup"
                                                    role="button" tabindex="0"><svg width="48px" height="48px"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Visible (eye)</title>
                                                        <path
                                                            d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h4><a href="#">Apple Watch</a></h4>
                                    <p><a href="#">Apple Watch Series 7 case Pair any band </a></p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="price">
                                        <ins>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi>
                                                    <span class="woocommerce-Price-currencySymbol">$</span>471.48
                                                </bdi>
                                            </span>
                                        </ins>
                                    </span>
                                    <div class="add-cart-area">
                                        <button class="add-to-cart">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="product-pic">
                                    <img src="assets/images/shop/product-img-22.png" alt="">
                                    <span class="theme-badge-2">12% off</span>
                                    <div class="actions">
                                        <ul>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Favourite</title>
                                                        <path
                                                            d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z">
                                                        </path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Shuffle</title>
                                                        <path
                                                            d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7">
                                                        </path>
                                                        <path
                                                            d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17">
                                                        </path>
                                                        <path d="M19 4L22 7L19 10"></path>
                                                        <path d="M19 13L22 16L19 19"></path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup"
                                                    role="button" tabindex="0"><svg width="48px" height="48px"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Visible (eye)</title>
                                                        <path
                                                            d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h4><a href="#">Mac Mini</a></h4>
                                    <p><a href="#">Apple MacBook Pro13.3″ Laptop with Touch ID </a></p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="price">
                                        <ins>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi>
                                                    <span class="woocommerce-Price-currencySymbol">$</span>471.48
                                                </bdi>
                                            </span>
                                        </ins>
                                        <del aria-hidden="true">
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi>
                                                    <span class="woocommerce-Price-currencySymbol">$</span>904.21
                                                </bdi>
                                            </span>
                                        </del>
                                    </span>
                                    <div class="add-cart-area">
                                        <button class="add-to-cart">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="product-pic">
                                    <img src="assets/images/shop/product-img-23.png" alt="">
                                    <span class="theme-badge">Sale</span>
                                    <div class="actions">
                                        <ul>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Favourite</title>
                                                        <path
                                                            d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z">
                                                        </path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                        width="48px" height="48px" viewBox="0 0 24 24"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Shuffle</title>
                                                        <path
                                                            d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7">
                                                        </path>
                                                        <path
                                                            d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17">
                                                        </path>
                                                        <path d="M19 4L22 7L19 10"></path>
                                                        <path d="M19 13L22 16L19 19"></path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup"
                                                    role="button" tabindex="0"><svg width="48px" height="48px"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                        stroke="#2329D6" stroke-width="1" stroke-linecap="square"
                                                        stroke-linejoin="miter" fill="none" color="#2329D6">
                                                        <title>Visible (eye)</title>
                                                        <path
                                                            d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h4><a href="#">iPad mini</a></h4>
                                    <p><a href="#">The ultimate iPad experience all over the world </a></p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="price">
                                        <ins>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi>
                                                    <span class="woocommerce-Price-currencySymbol">$</span>471.48
                                                </bdi>
                                            </span>
                                        </ins>
                                    </span>
                                    <div class="add-cart-area">
                                        <button class="add-to-cart">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- related_products_section - end ==================================================  --}}
@endsection

@section('css')
    <style>
        .success-box {
            margin: 50px 0;
            padding: 10px 10px;
            border: 1px solid #eee;
            background: #f9f9f9;
            display: none;
        }

        .success-box img {
            margin-right: 10px;
            display: inline-block;
            vertical-align: top;
        }

        .success-box>div {
            vertical-align: top;
            display: inline-block;
            color: #888;
        }



        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type: none;
            padding: 0;

            -moz-user-select: none;
            -webkit-user-select: none;
        }

        .rating-stars ul>li.star {
            display: inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul>li.star>i.fa {
            font-size: 2.5em;
            /* Change the size of the stars */
            color: #ccc;
            /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul>li.star.hover>i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul>li.star.selected>i.fa {
            color: #FF912C;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function() {
            var product_id = {{ $product->id }};
            var size_box = $('.size_box');
            var color_box = $('.color_box');
            var product_price = $('.product_price');
            var stock = $('.stock')
            var stock_limit = $('.stock_limit');
            var input_number_increment = $('.input_number_increment');
            var input_number = $('.input_number');
            var input_number_decrement = $('.input_number_decrement');
            var numberValue = input_number.val();
            var total_inventory_price = $('.total_inventory_price');



            size_box.on('change', function() {
                color_box.removeAttr("disabled");
                color_box.removeClass("disabled");
                $.ajax({
                    type: 'POST',
                    url: '{{ route('frontend.single.shop.color') }}',
                    data: {
                        size_id: size_box.val(),
                        product_id: product_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        color_box.html(data);
                    }
                });
                product_price.html(parseFloat({{ $product->sale_price ?? $product->price }}).toFixed(2));
                total_inventory_price.html(parseFloat({{ $product->sale_price ?? $product->price }}
                        .toFixed(2))
                    .toFixed(2));
                $('#total').val("");
                $('#inventory_id').val("");
                stock.html("");
                stock_limit.html("");
                input_number.val(1);
            })

            color_box.on('change', function() {
                input_number_increment.removeAttr("disabled");
                input_number_decrement.removeAttr("disabled");
                $.ajax({
                    type: 'POST',
                    url: '{{ route('frontend.single.shop.stock') }}',
                    data: {
                        size_id: size_box.val(),
                        color_id: color_box.val(),
                        product_id: product_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        product_price.html(parseFloat(data.price).toFixed(2));
                        total_inventory_price.html(parseFloat(data.price).toFixed(2));
                        $('#total').val(parseFloat(data.price).toFixed(2));
                        stock.html(data.stock);
                        stock_limit.html(data.stockValue);
                        $('#inventory_id').val(data.inventory_id);
                    }
                });
            });

            input_number_increment.on('click', function() {
                if (numberValue < stock_limit.html()) {
                    numberValue++;
                }
                input_number.val(numberValue);
                total_inventory_price.html(parseFloat(product_price.html() * numberValue).toFixed(2));
                $('#total').val(parseFloat(product_price.html() * numberValue).toFixed(2));
            });
            input_number_decrement.on('click', function() {
                if (numberValue > 1) {
                    numberValue--;
                }
                input_number.val(numberValue);
                total_inventory_price.html(parseFloat(product_price.html() * numberValue).toFixed(2));
                $('#total').val(parseFloat(product_price.html() * numberValue).toFixed(2));
            });


        });

        // product rating
        $(document).ready(function() {

            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function() {
                $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });


            /* 2. Action to perform on click */
            $('#stars li').on('click', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                } else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                $('.rating_value').val(ratingValue);
                responseMessage(msg);

            });


        });


        function responseMessage(msg) {
            $(".success-box").css({
                display: "block",
            })
            $('.success-box').fadeIn(200);
            $('.success-box div.text-message').html("<span>" + msg + "</span>");
        }
    </script>
@endsection
