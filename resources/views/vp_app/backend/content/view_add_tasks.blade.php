@extends('my_app.backend.master')
@section('title', 'Tasks')
@section('css')

@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            @if (request()->filled('kompania'))
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="ti ti-user-plus"></i> Menaxhimi i punes per stafin</h5>
                        </div>
                    </div>
                </div>

                @include('my_app.backend.content.partials_forms.form_punonjes')

                <div class="col-12">
                    <div class="row">
                        @foreach($My_Departament_Staff as $staf)
                            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="avatar rounded-circle overflow-hidden me-3 border border-primary" style="width: 70px; height: 70px;">
                                                <img src="{{ asset($staf->foto) }}" loading="lazy" alt="{{ $staf->emri }}" class="img-fluid">
                                            </div>
                                            <div>
                                                <h5 class="mb-1 text-primary fw-bold">{{ $staf->emri }} {{ $staf->mbiemri }}</h5>
                                                <p class="text-muted small mb-0"><i class="ti ti-mail"></i> {{ $staf->email }}</p>
                                            </div>
                                        </div>
                                        <p class="mb-2"><strong><i class="ti ti-building"></i> Departamenti:</strong> <span class="text-secondary">{{ $staf->Departament_Im->Departament_Lang->emri }}</span></p>

                                        <p class="mb-3"><strong><i class="ti ti-briefcase"></i> Puna Aktuale:</strong> <span class="text-secondary">{{ $staf->Pozicioni_Im->Pozicion_Lang->emri }}</span></p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <form action="{{ route('add_tasks_users') }}" method="POST" class="w-100">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                        <select name="kategori" class="form-select form-select-sm border-primary">
                                                            <option value="" disabled selected>Zgjidh Kategorinë</option>
                                                            <optgroup label="Kategori për Thirrje">
                                                                @foreach(\App\Models\My_App\Call\Call_Kategori::All_Call_Kategori(request('kompania'), 1) as $Kat_Calls)
                                                                    <option value="{{ $Kat_Calls->id }}">{{ $Kat_Calls->Call_Kategori_Lang->emri }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                            <optgroup label="Kategori për Email">
                                                                @foreach(\App\Models\My_App\Mail\Mail_Kategori::All_Mail_Kategori(request('kompania'), 1) as $Kat_Mails)
                                                                    <option value="{{ $Kat_Mails->id }}">{{ $Kat_Mails->Mail_Kategori_Lang->emri }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center">
                                                        <i class="ti ti-save me-1"></i> Ruaj
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

@endsection
