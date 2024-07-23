<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Urakka Sol</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Plugin -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/assets/owl.carousel.min.css') }}">

    <!-- APP CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <!-- MAIN CONTENT -->
    {{-- <div class="main"> --}}
    <div class="main-content">
        <section class="login">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        {{-- <div class="box-header d-flex justify-content-between">
                                <a href="index.html">
                                    <img src="./images/logo.png" alt="">
                                </a> --}}
                        <div class="action-reg">
                            <h4 class="fs-30">Login</h4>
                            <h5>Sign in to your account</h5>
                        </div>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h1>something wrong</h1>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="box-body">
                        <div class="auth-content my-auto">
                            <form class="mt-5 pt-4" method="POST" action="{{ route('login.check') }}">
                                @csrf
                                <div class="mb-24">
                                    <label class="form-label mb-14">User Name</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror" id="username"
                                        placeholder="Enter Name" value="{{ old('username') }}">
                                    @error('username')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-24">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <label class="form-label mb-14">Password</label>
                                        </div>
                                    </div>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter password" aria-label="Password"
                                            aria-describedby="password-addon" value="{{ old('password') }}">
                                        @error('password')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                        <button class="btn shadow-none ms-0" type="button" id="password-addon"><i
                                                class="far fa-eye-slash"></i></button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button
                                        class="btn bg-primary color-white w-100 waves-effect waves-light fs-18 font-w500"
                                        type="submit">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    {{-- </div> --}}
    <!-- END MAIN CONTENT -->

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/apexchart.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

    <!-- APP JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/shortcode.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
</body>

</html>
