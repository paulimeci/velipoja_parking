@extends('my_app.backend.master')
@section('title', 'Raport Ditor Detaje')
@section('css')

@endsection
@section('main-content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0">Detajet e Raportit</h4>
                    </div>
                    <div class="card-body p-5">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <h5><strong>Data:</strong> {{ \Carbon\Carbon::parse($Raport_Ditor->data)->format('d-m-Y') }}</h5>
                            </div>
                            <div class="col-md-9">
                                <h5><strong>Puna Kryer:</strong></h5>
                                <p>{!! $Raport_Ditor->punet_e_kryera !!} </p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><strong>Puna Kryer:</strong></h5>
                                <p>{!! $Raport_Ditor->punet_e_kryera_2 !!} </p>
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5><strong>Problemet:</strong></h5>
                                <p>{!! $Raport_Ditor->problemet ?? 'Nuk ka probleme të raportuara' !!}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5><strong>Arritjet:</strong></h5>
                                <p>{!! $Raport_Ditor->arritjet ?? 'Nuk ka arritje të raportuara' !!}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5><strong>Propozimet:</strong></h5>
                                <p>{!! $Raport_Ditor->propozimet ?? 'Nuk ka propozime të raportuara' !!}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('view_raport') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3">Kthehu në listën e raporteve</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card-header {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-body {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
        }

        .card {
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h5 {
            font-size: 1.2rem;
            color: #333;
        }

        p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-primary:focus, .btn-primary.focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card {
                margin: 0 15px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .btn-primary {
                font-size: 1rem;
            }
        }
    </style>
@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>

@endsection
