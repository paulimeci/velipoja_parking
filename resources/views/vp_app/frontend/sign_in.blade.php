@section('title', 'Sign In')
@include('my_app.backend.structure.head')

@include('my_app.backend.structure.css')
@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}", "Error", {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
        });
        @endforeach
    </script>
@endif

@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "Sukses", {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
        });
    </script>
@endif


<body class="sign-in-bg">
<div class="app-wrapper d-block">
    <div class="main-container">
        <!-- Body main section starts -->
        <div class="container">
            <div class="row sign-in-content-bg">
                <div class="col-lg-6 image-contentbox d-none d-lg-block">
                    <div class="form-container ">
                        <div class="signup-content mt-4">
                <span>
                  <img src="{{asset('../assets/images/logo/logo.gif')}}"  style="width: 400px;height: auto; border-radius: 5px;" alt="" class="img-fluid ">
                </span>
                        </div>

                        <div class="signup-bg-img">
                            <img src="{{asset('../assets/images/login/04.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 form-contentbox">
                    <div class="form-container">
                        <form class="app-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5 text-center text-lg-start">
                                        <h2 class="text-primary f-w-600">Welcome To TURK ARENA! </h2>
                                        <p>Sign in with your data that you enterd during your registration</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Username"
                                               id="username">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <a href="{{route('password_reset')}}" class="link-primary float-end">Forgot
                                            Password ?</a>
                                        <input type="password" class="form-control" placeholder="Enter Your Password"
                                               id="password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                        <label class="form-check-label text-secondary" for="checkDefault">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <a href="{{route('index')}}" role="button" class="btn btn-primary w-100">Sign
                                            In</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center text-lg-start">
                                        Don't Have Your Account yet? <a href="{{route('sign_up')}}"
                                                                        class="link-primary text-decoration-underline">
                                            Sign up</a>
                                    </div>
                                </div>
                                <div class="app-divider-v justify-content-center">
                                    <p>Or sign in with</p>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-facebook icon-btn b-r-22 m-1"><i
                                                    class="ti ti-brand-facebook text-white"></i></button>
                                        <button type="button" class="btn btn-gmail icon-btn b-r-22 m-1"><i
                                                    class="ti ti-brand-google text-white"></i></button>
                                        <button type="button" class="btn btn-github icon-btn b-r-22 m-1"><i
                                                    class="ti ti-brand-github text-white"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Body main section ends -->
    </div>
</div>


</body>
@section('script')

    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
@endsection

