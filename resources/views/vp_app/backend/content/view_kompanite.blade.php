@extends('my_app.backend.master')
@section('title', 'Kompanite')
@section('css')

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">

@endsection
@section('main-content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Gestione aziendale</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="ti ti-topology-complex"></i> Aggiungi azienda
                        </button>
                    </div>
                </div>
            </div>
            @include('my_app.backend.content.partials_forms.form_kompani')
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
                                    <th>Partita Iva</th>
                                    <th>Numero di cellulare</th>
                                    <th>Sito web</th>
                                    <th>Data di Inizio</th>
                                    <th>Data Fine</th>
                                    <th>Stato</th>
                                    <th>Azioni</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Kompanite as $Co)
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
                                                    <img src="{{asset( $Co->foto )}}" alt="" loading="lazy" class="img-fluid">
                                                </div>
                                                <div>
                                                    <h6 class="f-s-15 mb-0">{{ $Co->emri }}</h6>
                                                    <p class="text-secondary f-s-13 mb-0">{{ $Co->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-dark f-w-500">{{ $Co->nuis }}</td>

                                        <td>
                                            {{ $Co->telefoni }}
                                        </td>
                                        <td class="text-dark f-w-500">{{ $Co->website }}</td>
                                        <td>
                                            {{ $Co->data_fillimit_abonimit }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ !$Co->data_mbarimit_abonimit ? 'warning' : 'danger' }}">
                                                {{ !$Co->data_mbarimit_abonimit ? 'Conitnua...' : $Co->data_mbarimit_abonimit }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge bg-{{ $Co->active ? 'success' : 'danger' }}">
                                                {{ $Co->active ? 'Aktiv' : 'Jo Aktiv' }}
                                            </span>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-danger icon-btn b-r-4 delete-btn" data-bs-toggle="modal" data-bs-target="#apiDeleteModal_{{$Co->id}}">
                                                <i class="ti ti-trash"></i>
                                            </button>

                                            <button type="button" class="btn btn-success icon-btn b-r-4" onclick="window.location.href='{{ route('edit_kompanite', $Co->id) }}'">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="apiDeleteModal_{{$Co->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="../assets/images/icons/delete-icon.png" loading="lazy" alt="" class="img-fluid">
                                                    <div class="text-center">
                                                        <h4 class="text-danger f-w-600">Jeni i sigurt?</h4>
                                                        <p class="text-secondary f-s-16">Nese vazhdon nuk mundesh ta kthesh me!</p>
                                                    </div>

                                                    <div class="text-center d-flex mt-3 justify-content-center">
                                                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Jo</button>
                                                        <form id="delete-form-{{ $Co->id }}" action="{{ route('delete_kompanite', $Co->id) }}" method="POST">
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
        </div>
    </div>

@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>
    <!--js-->
    <script src="{{ asset('assets/js/advance_table.js') }}"></script>
@endsection
