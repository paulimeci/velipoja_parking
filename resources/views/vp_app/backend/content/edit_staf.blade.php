@extends('my_app.backend.master')
@section('title', 'Stafi Edit')
@section('css')

@endsection
@section('main-content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="col-md-8 bg-white shadow-lg rounded p-4">
            <form action="{{ Route('update_staf', $Punonjesit->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf

                <!-- Intestazione -->
                <div class="mb-4">
                    <h3 class="text-center text-primary" style="font-size: 1.5rem;">Aggiorna Dipendente</h3>
                    <hr>
                </div>

                <!-- ID Azienda Nascosto -->
                <input type="hidden" name="kompania" value="{{ $Punonjesit->id_kompania }}">

                <!-- Dipartimento e Posizione -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="departamenti" class="form-label" style="font-size: 0.9rem;">Dipartimento</label>
                        <select name="departamenti" class="form-select form-select-sm">
                            <option value="">Seleziona un dipartimento</option>
                            @foreach(\App\Models\My_App\Departamentet::All_Departament($Punonjesit->id_kompania, 1) as $departament)
                                <option value="{{ $departament->id }}" {{ $Punonjesit->id_departamenti == $departament->id ? 'selected' : '' }}>
                                    {{ $departament->Departament_Lang->emri }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamenti')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="pozicioni" class="form-label" style="font-size: 0.9rem;">Posizione</label>
                        <select name="pozicioni" class="form-select form-select-sm">
                            <option value="">Seleziona una posizione</option>
                            @foreach(\App\Models\My_App\Pozicion_Pune::All_Pozicion_Pune($Punonjesit->id_kompania, 1) as $poz)
                                <option value="{{ $poz->id }}" {{ $Punonjesit->id_pozicioni == $poz->id ? 'selected' : '' }}>
                                    {{ $poz->Pozicion_Lang->emri }}
                                </option>
                            @endforeach
                        </select>
                        @error('pozicioni')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nome e Contatto -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="emri" class="form-label" style="font-size: 0.9rem;">Nome e Cognome</label>
                        <input type="text" name="emri" class="form-control form-control-sm" value="{{ $Punonjesit->emri }}" placeholder="Inserisci il nome">
                        @error('emri')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nr_cel" class="form-label" style="font-size: 0.9rem;">Numero di Cellulare</label>
                        <input type="text" name="nr_cel" class="form-control form-control-sm" value="{{ $Punonjesit->nr_cel }}" placeholder="Inserisci il numero di cellulare">
                        @error('nr_cel')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email e Indirizzo -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label" style="font-size: 0.9rem;">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ $Punonjesit->email }}" placeholder="Inserisci l'email">
                        @error('email')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="adresa" class="form-label" style="font-size: 0.9rem;">Indirizzo</label>
                        <input type="text" name="adresa" class="form-control form-control-sm" value="{{ $Punonjesit->adresa }}" placeholder="Inserisci l'indirizzo">
                        @error('adresa')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data di Inizio e Data di Fine -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="filluar" class="form-label" style="font-size: 0.9rem;">Data di Inizio</label>
                        <input type="date" name="filluar" class="form-control form-control-sm" value="{{ $Punonjesit->filluar }}">
                        @error('filluar')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="larguar" class="form-label" style="font-size: 0.9rem;">Data di Fine</label>
                        <input type="date" name="larguar" class="form-control form-control-sm" value="{{ $Punonjesit->larguar }}">
                        @error('larguar')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Foto -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6 text-center">
                        <label class="form-label" style="font-size: 0.9rem;">Foto Esistente</label>
                        <div>
                            @if($Punonjesit->foto)
                                <img src="{{ asset($Punonjesit->foto) }}" alt="Foto del Dipendente" loading="lazy" class="img-thumbnail" style="max-height: 150px;">
                            @else
                                <p class="text-muted" style="font-size: 0.8rem;">Nessuna foto caricata.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="foto" class="form-label" style="font-size: 0.9rem;">Carica Foto</label>
                        <input type="file" name="foto" class="form-control form-control-sm">
                        @error('foto')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Stato Attivo -->
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="active" class="form-check-input" id="active" {{ $Punonjesit->active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active" style="font-size: 0.9rem;">Attivo</label>
                </div>

                <!-- Footer -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Salva Modifiche</button>
                    <button type="button" class="btn btn-secondary btn-sm w-100 mt-2" data-bs-dismiss="modal">Annulla</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>
@endsection
