@extends('my_app.backend.master')
@section('title', 'Pozicion Pune Edit')
@section('css')


@endsection
@section('main-content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Modifica posizione</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update_pozicions', $Pozicion->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Hidden Field for Kompania -->
                            <div class="form-group" hidden>
                                <label for="id_kompania">Kompania</label>
                                <input type="number" name="id_kompania" class="form-control" value="{{ $Pozicion->id_kompania }}">
                            </div>
                            <!-- Translations -->

                                <!-- Category Name -->
                                <div class="form-group">
                                    <label for="pozicioni">POSIZIONE ({{ \App\Models\GjuhetByUser::My_Default_Lang()->Datti_Gjuha->emri }})</label>
                                    <input type="text" name="pozicioni" class="form-control" value="{{ $Pozicion->Pozicion_Lang->emri }}" placeholder="Inserisci un nome per la posizione.">
                                    @error('pozicioni')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="pershkrimi">Descrizione ({{ \App\Models\GjuhetByUser::My_Default_Lang()->Datti_Gjuha->emri }})</label>
                                    <input type="text" name="pershkrimi" class="form-control" value="{{ $Pozicion->Pozicion_Lang->pershkrimi }}" placeholder="Inserisci una descrizione.">
                                    @error('pershkrimi')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            <!-- Logo -->
                                <div class="form-group">
                                    <label for="img_logo">Logo (Opsionale)</label>
                                    <input type="file" name="img_logo" class="form-control">
                                    @error('img_logo')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if ($Pozicion->img_logo)
                                        <p class="mt-2">Logo ekzistuese: <img src="{{ asset($Pozicion->img_logo) }}" loading="lazy" alt="Logo" height="50"></p>
                                    @endif
                                </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Aggiornare</button>
                                <a href="{{ route('view_pozicions') }}" class="btn btn-secondary">Anulla</a>
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
