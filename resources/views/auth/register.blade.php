<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Create a stylish landing page for your business startup and get leads for the offered services with this HTML landing page template.">
    <meta name="author" content="Inovatik">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CloudMultiple') }}</title>
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <!-- Website Title -->
    <title>Multiple CLoud</title>

    <!-- Styles -->

    <!-- Favicon  -->
    <link rel="icon" href={{ asset('images/favicon.png') }}>
</head>

<body data-spy="scroll" data-target=".fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <!-- Mobile Menu Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-awesome fas fa-bars"></span>
            <span class="navbar-toggler-awesome fas fa-times"></span>
        </button>
        <!-- end of mobile menu toggle button -->

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#pricing">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#request">Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" data-toggle="modal" data-target="#loginModal">Login</a>
                </li>

                <!-- Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle page-scroll" href="#about" id="navbarDropdown" role="button"
                        aria-haspopup="true" aria-expanded="false">About</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="terms-conditions.html"><span class="item-text">Terms
                                Conditions</span></a>
                        <div class="dropdown-items-divide-hr"></div>
                        <a class="dropdown-item" href="privacy-policy.html"><span class="item-text">Privacy
                                Policy</span></a>
                    </div>
                </li>
                <!-- end of dropdown menu -->

                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->
    <br>
    <br>

    <!----------------------- Main Container -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------------- Left Box ----------------------------->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('images/cloud-computing.jpeg') }}" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be
                    Verified</p>
                <small class="text-white text-wrap text-center"
                    style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on
                    this
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

                        <input id="password-confirm" type="password"
                            class="form-control form-control-lg bg-light fs-6" name="password_confirmation" required
                            autocomplete="new-password" placeholder="Confirm Password">
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

    {{-- @include('layouts.homepage.footer') --}}
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/register.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
