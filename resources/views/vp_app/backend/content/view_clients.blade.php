@extends('my_app.backend.master')
@section('title', 'Stafi')
@section('css')

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">

@endsection
@section('main-content')

    <div class="container-fluid">
        <div class="row">
            @if (request()->filled('kompania'))
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Menaxhimi i klientave</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="ti ti-user"></i> Shto Klient
                            </button>
                             <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#upload_clients_excel">
                                <i class="ti ti-user"></i> Importo Klient Excel
                            </button>

                        </div>
                    </div>
                </div>
            @include('my_app.backend.content.partials_forms.form_klient')
            @include('my_app.backend.content.partials_forms.form_upload_clients')
            <div class="col-12">
                <div class="card">
                    <div class="card-body ps-0 pe-0">
                        <div class="table-responsive app-scroll app-datatable-default project-table">
                            <table id="projectTable" class="display table-bottom-border app-data-table table-box-hover">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="check-box">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmark outline-secondary ms-2"></span>
                                        </label>
                                    </th>
                                    <th>client_id</th>
                                    <th>Emri</th>
                                    <th>Mbiemri</th>
                                    <th>Nr Cel</th>
                                    <th>Kategotria</th>
                                    <th>Regjistruar</th>
                                    <th>Veprime</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Klientat as $klient)
                                    <tr>
                                        <td>
                                            <label class="check-box">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary ms-2"></span>
                                            </label>
                                        </td>
                                        <td class="text-dark f-w-500">{{ $klient->client_id }}</td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden me-2">
                                                    <img src="{{asset( $klient->foto ?? 'null' )}}" alt="" loading="lazy" class="img-fluid">
                                                </div>
                                                <div>
                                                    <h6 class="f-s-15 mb-0">{{ $klient->emri }}</h6>
                                                    <p class="text-secondary f-s-13 mb-0">{{ $klient->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-dark f-w-500"> {{ $klient->mbiemri }}</td>

                                        <td class="text-dark f-w-500">{{ $klient->nr_cel }}</td>

                                        <td>
                                            {{ $klient->kategoria_lojtarit }}
                                        </td>
                                        <td>
                                            {{ $klient->date_regjistrimi }}
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-danger icon-btn b-r-4 delete-btn" data-bs-toggle="modal" data-bs-target="#apiDeleteModal_{{$klient->id}}">
                                                <i class="ti ti-trash"></i>
                                            </button>

                                            <button type="button" class="btn btn-success icon-btn b-r-4" onclick="window.location.href='{{ route('edit_staf', $klient->id) }}'">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="apiDeleteModal_{{$klient->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="../assets/images/icons/delete-icon.png" alt="" loading="lazy" class="img-fluid">
                                                    <div class="text-center">
                                                        <h4 class="text-danger f-w-600">Jeni i sigurt?</h4>
                                                        <p class="text-secondary f-s-16">Nese vazhdon nuk mundesh ta kthesh me!</p>
                                                    </div>

                                                    <div class="text-center d-flex mt-3 justify-content-center">
                                                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Jo</button>
                                                        <form id="delete-form-{{ $klient->id }}" action="{{ route('delete_staf', $klient->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary" id="confirmDelete">Po, Vazhdo</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @else
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-body d-flex justify-content-between align-items-center bg-light rounded-top">
                            <h5 class="card-title mb-0 text-dark">
                                <i class="ti ti-briefcase me-2"></i> Kompanitë
                            </h5>
                        </div>
                    </div>
                </div>
                @forelse($Kompanite AS $Co)
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-lg hover-card">
                            <div class="card-body text-center p-4">
                                <form action="" method="GET">
                                    <input type="hidden" name="kompania" value="{{ $Co->id }}">
                                    <div class="company-logo mb-3">
                                        <img src="{{ asset($Co->logo) }}" class="img-fluid rounded-circle"  loading="lazy" alt="{{ $Co->emri }}">
                                    </div>
                                    <h5 class="text-primary fw-bold mt-2">
                                        <i class="ti ti-building me-2"></i>{{ $Co->emri }}
                                    </h5>
                                    <p class="text-muted mt-1 mb-3">
                                        <i class="ti ti-barcode me-2"></i>{{ $Co->nuis }}
                                    </p>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-arrow-right-circle me-2"></i> Vazhdo këtu
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-lg text-center hover-card">
                            <div class="card-header bg-danger text-white rounded-top">
                                <h5 class="mb-0">
                                    <i class="ti ti-alert-circle me-2"></i> Nuk ka kompani
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted">Aktualisht nuk keni regjistruar asnjë kompani.</p>
                                <a href="{{ route('view_kompanite') }}" class="btn btn-outline-danger w-100">
                                    <i class="ti ti-plus-circle"></i> Shto këtu
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            @endif
        </div>
    </div>

@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>

    <!--js-->
    <script src="{{ asset('assets/js/advance_table.js') }}"></script>
@endsection


