<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All meta and title start-->
@include('my_app.backend.structure.head')
<!-- meta and title end-->
    <!-- css start-->
@include('my_app.backend.structure.css')
<!-- css end-->
    @livewireStyles
</head>

<body>

<!-- Loader start-->
    <div class="app-wrapper">
{{--        @include('my_app.backend.structure.loader')--}}
{{--        <div class="loader-wrapper">--}}
{{--            <div class="loader_4"></div>--}}
{{--        </div>--}}
        <!-- Loader end-->

        <!-- Menu Navigation start -->
        @include('my_app.backend.structure.sidebar')
        <!-- Menu Navigation end -->
            <div class="app-content">
                    <!-- Header Section start -->
                    @include('my_app.backend.structure.header')
                    <!-- Header Section end -->

                    <!-- Main Section start -->
                    <main>
                        {{--Ketu vendosim te gjithe toast mesage qe kemi --}}
                        @if(session('success'))
                            <script>
                                toastr.success('{{ session('success') }}', 'Sukses', {
                                    "progressBar": true,
                                    "closeButton": true,
                                    "timeOut": "5000",
                                    "positionClass": "toast-top-right",
                                    "toastClass": "toast-custom-success" // Klasë e personalizuar për sukses
                                });
                            </script>
                        @endif

                        @if(session('error'))
                            <script>
                                toastr.error('{{ session('error') }}', 'Gabim', {
                                    "progressBar": true,
                                    "closeButton": true,
                                    "timeOut": "5000",
                                    "positionClass": "toast-top-right",
                                    "toastClass": "toast-custom-error" // Klasë e personalizuar për error
                                });
                            </script>
                        @endif
                        @if(session('info'))
                            <script>
                                toastr.info('{{ session('info') }}', 'Informacion', {
                                    "progressBar": true,
                                    "closeButton": true,
                                    "timeOut": "5000",
                                    "positionClass": "toast-top-right",
                                    "toastClass": "toast-custom-info"
                                });
                            </script>
                        @endif
                        @if(session('warning'))
                            <script>
                                toastr.warning('{{ session('warning') }}', 'Paralajmërim', {
                                    "progressBar": true,
                                    "closeButton": true,
                                    "timeOut": "8000",
                                    "positionClass": "toast-top-right",
                                    "toastClass": "toast-custom-warning"
                                });
                            </script>
                        @endif
                        @if(session('danger'))
                            <script>
                                toastr.error('{{ session('danger') }}', 'Rrezik', {
                                    "progressBar": true,
                                    "closeButton": true,
                                    "timeOut": "5000",
                                    "positionClass": "toast-top-right",
                                    "toastClass": "toast-custom-danger"
                                });
                            </script>
                        @endif
                        @if($errors->any())
                            <script>
                                @foreach($errors->all() as $error)
                                toastr.error('{{ $error }}', 'Kujdes', {
                                    "progressBar": true,
                                    "closeButton": true,
                                    "timeOut": "5000",
                                    "positionClass": "toast-top-right",
                                    "toastClass": "toast-custom-error"
                                });
                                @endforeach
                            </script>
                        @endif
                        {{-- main body content --}}
                        @yield('main-content')
                    </main>
                    <!-- Main Section end -->
            </div>

            <!-- tap on top -->
            <div class="go-top">
              <span class="progress-value">
                <i class="ti ti-arrow-up"></i>
              </span>
            </div>

            <!-- Footer Section start -->
             @include('my_app.backend.structure.footer')
            <!-- Footer Section end -->
    </div>
@livewireScripts
</body>

<!--customizer-->
<!-- scripts start-->
@include('my_app.backend.structure.script')
<!-- scripts end-->
</html>
