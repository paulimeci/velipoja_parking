@extends('my_app.backend.master')
@section('title', 'Raport Ditor')
@section('css')

@endsection
@section('main-content')

    <div class="container-fluid">

        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Raportet ditore</h5>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
                        <i class="ti ti-user"></i> Bej raport ditor ketu
                    </button>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd">
            <div class="offcanvas-header">
                <button type="button" class="btn btn-light-success">Raport Ditor</button>
                <button type="button" class="btn-close text-reset fs-5" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                @include('my_app.backend.content.partials_forms.form_raport_ditor')
            </div>
        </div>
        <div class="row">
        @foreach($Raport_Ditor AS $raport)

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-header d-flex code-header">
                            <h5>{{ \Carbon\Carbon::parse($raport->data)->format('d-m-Y') }}</h5>
                            <a href="{{ route('view_raport_detaje', ['id' => $raport->id]) }}" >
                                <i class="ti ti-code source"></i>
                            </a>


                        </div>
                        <div class="card-body">
                            <h6>Raporti</h6>
                            <p></p>
                        </div>
                    </div>
                </div>

        @endforeach
        </div>
    </div>

@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>

@endsection
