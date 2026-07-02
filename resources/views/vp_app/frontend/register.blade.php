@section('title', 'Sign Up')
@include('my_app.backend.structure.head')

@include('my_app.backend.structure.css')

<body class="sign-in-bg">
<div class="app-wrapper d-block">
    <div class="main-container">
        <!-- sign up start -->
        <div class="container">
            <div class="row sign-in-content-bg">
                <div class="col-lg-6 image-contentbox d-none d-lg-block">
                    <div class="form-container">

                        <div class="signup-content mt-4">
                    <span>
                  <img src="{{asset('../assets/images/logo/logo.png')}}"  style="width: 400px;height: auto; border-radius: 5px;" alt="" class="img-fluid ">
                </span>
                        </div>

                        <div class="signup-bg-img">
                            <img src="{{asset('../assets/images/login/02.png')}}" alt="" class="img-fluid">
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 form-contentbox">
                    <div class="form-container">
                        <form class="app-form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nome e Cognome</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Inserisci il tuo nome" id="name"
                                               value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nome utente</label>
                                        <input type="text" class="form-control" name="username"
                                               placeholder="Inserisci il tuo nome utente" id="username"
                                               value="{{ old('username') }}">
                                        @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nr_cel" class="form-label">Numero di telefono</label>
                                        <input type="number" class="form-control" name="nr_cel"
                                               placeholder="Inserisci il tuo numero" id="nr_cel"
                                               value="{{ old('nr_cel') }}">
                                        @error('nr_cel')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                               placeholder="Inserisci la tua email" id="email"
                                               value="{{ old('email') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                               placeholder="Inserisci la tua password" id="password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Conferma Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                               placeholder="Conferma la tua password" id="password_confirmation">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terms">
                                        Accetto i <a href="#" target="_blank">Termini e Condizioni</a>.
                                    </label>
                                </div>
                                @error('terms')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Invia</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- sign up end -->
    </div>
</div>

</body>
@section('script')
    <!--js-->
    <script src="{{asset('assets/js/coming_soon.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection
