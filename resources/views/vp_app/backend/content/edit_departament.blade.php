@extends('my_app.backend.master')
@section('title', 'Departamentet Edit')
@section('css')

@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Modifica reparto</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update_departaments', $departament->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Hidden Field for Kompania -->
                                <div class="col-md-12" hidden>
                                    <div class="form-group">
                                        <label for="id_kompania">Kompania</label>
                                        <input type="number" name="id_kompania" class="form-control" value="{{ $departament->id_kompania }}">
                                    </div>
                                </div>

                                <!-- Departamenti Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="departamenti">Dipartimento ({{ \App\Models\GjuhetByUser::My_Default_Lang()->Datti_Gjuha->emri }})</label>
                                        <input type="text" name="departamenti" class="form-control" value="{{ $departament->Departament_Lang->emri }}" placeholder="Inserisci il nome di un reparto.">
                                        @error('departamenti')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pershkrimi -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pershkrimi">Descrizione ({{ \App\Models\GjuhetByUser::My_Default_Lang()->Datti_Gjuha->emri }})</label>
                                        <input type="text" name="pershkrimi" class="form-control" value="{{ $departament->Departament_Lang->pershkrimi }}" placeholder="Inserisci una descrizione.">
                                        @error('pershkrimi')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Logo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="img_logo">Logo (facoltativo)</label>
                                        <input type="file" name="img_logo" class="form-control">
                                        @error('img_logo')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if ($departament->img_logo)
                                            <div class="mt-2">
                                                <label>Logo esistente:</label>
                                                <img src="{{ asset($departament->img_logo) }}" loading="lazy" alt="Logo" height="50">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success px-5">Aggiornare</button>
                                    <a href="{{ route('view_departaments') }}" class="btn btn-secondary px-5">Annulla</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>

@endsection
