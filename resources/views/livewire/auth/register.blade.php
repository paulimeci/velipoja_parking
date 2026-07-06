<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/google-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightpick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <title>Velipoja Parking - Register</title>
</head>
<body class="boxed-size bg-white">
<div class="preloader" id="preloader">
    <div class="preloader">
        <div class="waviy position-relative">
            <span class="d-inline-block">T</span>
            <span class="d-inline-block">R</span>
            <span class="d-inline-block">E</span>
            <span class="d-inline-block">Z</span>
            <span class="d-inline-block">O</span>
        </div>
    </div>
</div>
<div class="container">
    <div class="main-content d-flex flex-column p-0">
        <div class="m-auto m-1230 w-100">

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success text-center mb-4 rounded-3 fs-14">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row align-items-center">
                {{-- Fotoja Ilustruese (Majtas) --}}
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('assets/images/register.jpg') }}" class="rounded-3 img-fluid" alt="register">
                </div>

                {{-- Kolona e Formës (Djathtas) --}}
                <div class="col-lg-6">
                    <div class="mw-480 ms-lg-auto p-4">
                        <div class="d-inline-block mb-4">
                            <img src="{{ asset('assets/images/logo.svg') }}" class="rounded-3 for-light-logo" alt="logo">
                            <img src="{{ asset('assets/images/white-logo.svg') }}" class="rounded-3 for-dark-logo" alt="logo">
                        </div>

                        <h3 class="fs-28 fw-bold mb-2">{{ __('Krijoni një llogari') }}</h3>
                        <p class="fw-medium fs-16 text-secondary mb-4">{{ __('Plotësoni të dhënat tuaja më poshtë për t\'u regjistruar.') }}</p>

                        {{-- Social Register Links --}}

                        {{-- FORMA E REGJISTRIMIT --}}
                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf

                            {{-- Emri i Plotë --}}
                            <div class="form-group mb-3">
                                <label for="name" class="label text-secondary fw-semibold mb-2">{{ __('Emri i Plotë') }}</label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control h-55 rounded-3 border-secondary border-opacity-25 @error('name') is-invalid @enderror"
                                    placeholder="{{ __('Full name') }}"
                                    required
                                    autofocus
                                    autocomplete="name"
                                >
                                @error('name')
                                <div class="invalid-feedback mt-1 fs-13">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Address --}}
                            <div class="form-group mb-3">
                                <label for="email" class="label text-secondary fw-semibold mb-2">{{ __('Adresa Email') }}</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control h-55 rounded-3 border-secondary border-opacity-25 @error('email') is-invalid @enderror"
                                    placeholder="example@trezo.com"
                                    required
                                    autocomplete="email"
                                >
                                @error('email')
                                <div class="invalid-feedback mt-1 fs-13">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-3">
                                <label for="password" class="label text-secondary fw-semibold mb-2">{{ __('Fjalëkalimi') }}</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control h-55 rounded-3 border-secondary border-opacity-25 @error('password') is-invalid @enderror"
                                    placeholder="{{ __('Password') }}"
                                    required
                                    autocomplete="new-password"
                                >
                                @error('password')
                                <div class="invalid-feedback mt-1 fs-13">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="label text-secondary fw-semibold mb-2">{{ __('Konfirmoni Fjalëkalimin') }}</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control h-55 rounded-3 border-secondary border-opacity-25 @error('password_confirmation') is-invalid @enderror"
                                    placeholder="{{ __('Confirm password') }}"
                                    required
                                    autocomplete="new-password"
                                >
                                @error('password_confirmation')
                                <div class="invalid-feedback mt-1 fs-13">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Butoni Submit --}}
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary fw-bold py-2.5 px-3 w-100 rounded-3 shadow-sm border-0" data-test="register-user-button">
                                    <div class="d-flex align-items-center justify-content-center py-1">
                                        <i class="material-symbols-outlined text-white fs-20 me-2">person_4</i>
                                        <span>{{ __('Create account') }}</span>
                                    </div>
                                </button>
                            </div>

                            {{-- Kushtet & Navigimi --}}
                            <div class="form-group text-secondary fs-13 mt-3 text-center">
                                <p class="fs-14">Regjistruar më parë? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none ms-1">{{ __('Log in') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button class="switch-toggle settings-btn dark-btn p-0 bg-transparent position-absolute top-0 d-none" id="switch-toggle">
    <span class="dark"><i class="material-symbols-outlined">light_mode</i></span>
    <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
</button>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/dragdrop.js') }}"></script>
<script src="{{ asset('assets/js/rangeslider.min.js') }}"></script>
<script src="{{ asset('assets/js/quill.min.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
<script src="{{ asset('assets/js/prism.js') }}"></script>
<script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/echarts.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar.main.js') }}"></script>
<script src="{{ asset('assets/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/world-merc.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/lightpick.js') }}"></script>
<script src="{{ asset('assets/js/custom/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/custom/echarts.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom.js') }}"></script>
</body>
</html>
