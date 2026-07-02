@extends('my_app.backend.master')
@section('title', 'Pozicione Pune')
@section('css')

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
                            <h6 class="card-title mb-0">Gestione della posizione lavorativa</h6>
                            <button type="button" class="btn btn-sm btn-primary"   data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
                                <i class="ti ti-details"></i>Aggiungi posizione lavorativa
                            </button>
                        </div>
                    </div>
                </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd">
                <div class="offcanvas-header">
                    <button type="button" class="btn btn-success">NUOVA POSIZIONE</button>
                    <button type="button" class="btn-close text-reset fs-5" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @include('my_app.backend.content.partials_forms.form_pozicione')
                </div>
            </div>

            @foreach($Pozicion_Pune as $Poz)
                    <div class="col-md-6 col-xxl-3">
                        <div class="card border-0 shadow-sm rounded-lg mb-4 card-hover">
                            <div class="position-relative mt-3">
                                <img src="{{ asset($Poz->img_logo) }}" loading="lazy" class="card-img-top" alt="{{ $Poz->Pozicion_Lang->emri }}" style="object-fit: contain; width: 100%; height: 150px;">
                                <div class="position-absolute top-0 start-0 bg-dark text-white px-2 py-1 small rounded-end">{{ $Poz->Pozicion_Lang->emri }}</div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-dark">
                                    <i class="ti ti-briefcase me-2"></i>{{ $Poz->Pozicion_Lang->emri }}
                                </h5>
                                <p class="card-text text-muted small">{{ Str::limit($Poz->Pozicion_Lang->pershkrimi, 60) }}</p>
                            </div>
                            <div class="card-footer bg-white d-flex justify-content-between">
                                <a href="{{ route('edit_pozicions', $Poz->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="ti ti-pencil"></i> Modifica
                                </a>
                                <form action="{{ route('delete_pozicions', $Poz->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="ti ti-trash"></i> Cancella
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach
            @else
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-body d-flex justify-content-between align-items-center bg-light rounded-top">
                            <h5 class="card-title mb-0 text-dark">
                                <i class="ti ti-briefcase me-2"></i> Aziende
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

@endsection
