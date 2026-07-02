@section('title', 'Access Denied')
@include('my_app.backend.structure.head')

@include('my_app.backend.structure.css')

<div class="error-container p-0">
    <div class="container">
        <div>
            <div>
                <img src="{{asset('../assets/images/img_default/access-denied.png')}}" style="width: 100px;height: auto;" class="img-fluid" alt="Access Denied">
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <p class="text-center text-secondary f-w-500">Non hai i diritti di accesso per accedere a questa pagina. Se ritieni che si tratti di un errore, contatta l'amministratore.</p>
                    </div>
                </div>
            </div>
            <a role="button" href="{{route('datti_cliente')}}" class="btn btn-lg btn-warning text-white"><i class="ti ti-home"></i> Torna alla Home Page</a>
        </div>
    </div>
</div>

@section('script')
    <!--jquery-->
    <script src="{{asset('assets/js/jquery-3.6.3.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection
