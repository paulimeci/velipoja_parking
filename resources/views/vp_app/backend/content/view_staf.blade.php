@extends('my_app.backend.master')
@section('title', 'Stafi')
@section('css')

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">

@endsection
@section('main-content')
    @php
        $user=\Illuminate\Support\Facades\Auth::user();
        $kompania_id=request('kompania');
        $hasAccess=$user->ka_akses()->where('id_kompania', $kompania_id)->exists();
    @endphp

    <div class="container-fluid">
        <div class="row">
            @if ((request()->filled('kompania'))&&$hasAccess)
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Gestione del personale</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="ti ti-user"></i>Aggiungi personale
                            </button>
                        </div>
                    </div>
                </div>
            @include('my_app.backend.content.partials_forms.form_punonjes')
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
                                    <th>Nome</th>
                                    <th>Dipartimento</th>
                                    <th>Numero di cellulare</th>
                                    <th>Accesso</th>
                                    <th>Posizione</th>
                                    <th>Iniziato</th>
                                    <th>Fatto</th>
                                    <th>Stato</th>
                                    <th>Azioni</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Punonjesit as $staf)
                                    <tr>
                                        <td>
                                            <label class="check-box">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary ms-2"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden me-2">
                                                    <img src="{{asset( $staf->foto )}}" alt="" class="img-fluid" loading="lazy">
                                                </div>
                                                <div>
                                                    <h6 class="f-s-15 mb-0">{{ $staf->emri }} {{ $staf->mbiemri }}</h6>
                                                    <p class="text-secondary f-s-13 mb-0">{{ $staf->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-dark f-w-500">{{ $staf->Departament_Im->Departament_Lang->emri }}</td>

                                        <td>
                                            {{ $staf->nr_cel }}
                                        </td>
                                        <td class="text-dark f-w-500">{{ $staf->Datti_Lidhje_User_Staff->Level_Accesso_Company->Datti_Roli_Aksesit->Role_Aksesi_Lang->emri ?? 'Non e\' utente' }}</td>
                                        <td class="text-dark f-w-500">{{ $staf->Pozicioni_Im->Pozicion_Lang->emri }}</td>

                                        <td>
                                            {{ $staf->filluar }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ !$staf->mbaruar ? 'warning' : 'danger' }}">
                                                {{ !$staf->mbaruar ? 'Continua...' : $staf->mbaruar }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge bg-{{ $staf->id_statusi ? 'success' : 'danger' }}">
                                                {{ $staf->id_statusi ? 'Attivo' : 'Non attivo' }}
                                            </span>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-danger icon-btn b-r-4 delete-btn" data-bs-toggle="modal" data-bs-target="#apiDeleteModal_{{$staf->id}}">
                                                <i class="ti ti-trash"></i>
                                            </button>

                                            <button type="button" class="btn btn-success icon-btn b-r-4" onclick="window.location.href='{{ route('edit_staf', $staf->id) }}'">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="apiDeleteModal_{{$staf->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="../assets/images/icons/delete-icon.png" alt="" class="img-fluid" loading="lazy">
                                                    <div class="text-center">
                                                        <h4 class="text-danger f-w-600">Sei sicuro?</h4>
                                                        <p class="text-secondary f-s-16">Se continua, non puoi tornare indietro!</p>
                                                    </div>

                                                    <div class="text-center d-flex mt-3 justify-content-center">
                                                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Jo</button>
                                                        <form id="delete-form-{{ $staf->id }}" action="{{ route('delete_staf', $staf->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary" id="confirmDelete">Sì, continua</button>
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
                                        <img src="{{ asset($Co->logo) }}" loading="lazy" class="img-fluid rounded-circle" alt="{{ $Co->emri }}">
                                    </div>
                                    <h5 class="text-primary fw-bold mt-2">
                                        <i class="ti ti-building me-2"></i>{{ $Co->emri }}
                                    </h5>
                                    <p class="text-muted mt-1 mb-3">
                                        <i class="ti ti-barcode me-2"></i>{{ $Co->nuis }}
                                    </p>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-arrow-right-circle me-2"></i>  Continua qui
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
                                    <i class="ti ti-alert-circle me-2"></i> Non c'è nessuna azienda.
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted">Al momento non hai aziende registrate.</p>
                                <a href="{{ route('view_kompanite') }}" class="btn btn-outline-danger w-100">
                                    <i class="ti ti-plus-circle"></i> Aggiungi qui
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


