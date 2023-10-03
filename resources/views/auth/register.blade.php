@extends('layouts.homepage.main')

@section('content')
    <!----------------------- Main Container -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------------- Left Box ----------------------------->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="{{asset('images/cloud-computing.jpeg')}}" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be
                    Verified</p>
                <small class="text-white text-wrap text-center"
                    style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on this
                    platform.</small>
            </div>
            <!-------------------- ------ Right Box ---------------------------->

            <div class="col-md-6 right-box">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group mb-3">

                        <input id="name" placeholder="Name" type="text"
                            class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="input-group mb-3">


                        <input id="email" type="email"
                            class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="Email Address">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="input-group mb-3">

                        <input id="password" type="password"
                            class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">

                        <input id="password-confirm" type="password" class="form-control form-control-lg bg-light fs-6"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm Password">
                    </div>

                    <div class="input-group mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">
                            {{ __('Register') }}
                        </button>

                    </div>
                </form>

                {{--
                <div class="input-group mb-3">
                    <button class="btn btn-lg btn-light w-100 fs-6"><img src="images/google.png" style="width:20px"
                            class="me-2"><small>Sign In with Google</small></button>
                </div> --}}

            </div>
        </div>
    </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/register.css') }}">
@endsection
