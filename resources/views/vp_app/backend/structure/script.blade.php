<!-- Latest jQuery -->
<script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('assets/js/lazysizes.js') }}" async></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

<!-- Simplebar JS -->
<script src="{{ asset('assets/vendor/simplebar/simplebar.js') }}"></script>

<!-- Phosphor JS -->
<script src="{{ asset('assets/vendor/phosphor/phosphor.js') }}"></script>
<!-- customizer JS -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>
<!-- Prism JS -->
<script src="{{ asset('assets/vendor/prism/prism.min.js') }}"></script>

<!-- ApexCharts JS -->
{{--<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>--}}

<!-- Sortable JS -->
<script src="{{ asset('assets/vendor/sortable/Sortable.min.js') }}"></script>

<!-- Block UI JS -->
<script src="{{ asset('assets/vendor/block-ui/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/block-ui/jquery.blockUI.js') }}"></script>

<!-- DataTable JS -->
<script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>

<!-- Project JS -->
{{--
<script src="{{ asset('assets/js/project_dashboard.js') }}"></script>
--}}

<!-- Block UI Custom JS -->
<script src="{{ asset('assets/js/block_ui.js') }}"></script>

<!-- Advance Table JS -->


<!-- App JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };
</script>

@yield('script')
