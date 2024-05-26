@extends('layouts.frontendApp')
@section('title', 'Login - Register')
@section('content')
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index-2.html">Home</a></li>
                <li>Login/Register</li>
            </ul>
        </div>
    </div>
    <section class="register_section section_space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <ul class="nav register_tabnav ul_li_center" role="tablist">
                        <li role="presentation">
                            <button class="active" data-bs-toggle="tab" data-bs-target="#signin_tab" type="button"
                                role="tab" aria-controls="signin_tab" aria-selected="true">Sign In</button>
                        </li>
                        <li role="presentation">
                            <button data-bs-toggle="tab" data-bs-target="#signup_tab" type="button" role="tab"
                                aria-controls="signup_tab" aria-selected="false" class="">Register</button>
                        </li>
                    </ul>

                    <div class="register_wrap tab-content">
                        <div class="tab-pane fade active show" id="signin_tab" role="tabpanel">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Email Address*') }}</h3>
                                    <div class="form_item">
                                        <label><i class="fas fa-user"></i></label>
                                        <input class="@error('email') is-invalid @enderror" type="email" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="example@gmail.com">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Password*') }}</h3>
                                    <div class="form_item">
                                        <label for="password_input"><i class="fas fa-lock"></i></label>
                                        <input id="password_input" type="password"
                                            class="@error('password') is-invalid @enderror" name="password" required
                                            autocomplete="current-password" placeholder="*******123">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="checkbox_item">
                                        <input id="remember_checkbox" type="checkbox" name="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember_checkbox">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <button type="submit" class="btn btn_primary">Sign In</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="signup_tab" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Name*') }}</h3>
                                    <div class="form_item">
                                        <label for="name_input2"><i class="fas fa-user"></i></label>
                                        <input id="name_input2" type="text" class="@error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required autocomplete="name"
                                            placeholder="Name">
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Eamil*') }}</h3>
                                    <div class="form_item">
                                        <label for="email_input"><i class="fas fa-envelope"></i></label>
                                        <input class="@error('email') is-invalid @enderror" type="email" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="example@gmail.com">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Password*') }}</h3>
                                    <div class="form_item">
                                        <label for="password_input"><i class="fas fa-lock"></i></label>
                                        <input id="password_input" type="password"
                                            class="@error('password') is-invalid @enderror" name="password" required
                                            autocomplete="current-password" placeholder="*******123">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Confirm Password*') }}</h3>
                                    <div class="form_item">
                                        <label for="password_input"><i class="fas fa-lock"></i></label>
                                        <input id="password_input" type="password" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="*******123">
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <button type="submit" class="btn btn_secondary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
