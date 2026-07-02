@extends('my_app.backend.master')
@section('title', 'Kompanite Edit')
@section('css')

@endsection
@section('main-content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="col-md-8 bg-white shadow-lg rounded p-4">
            <form action="{{ Route('update_kompanite', $Kompanite->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf

                <!-- Header -->
                <div class="mb-4">
                    <h3 class="text-center text-primary" style="font-size: 1.5rem;">Aggiorna Azienda</h3>
                    <hr>
                </div>

                <!-- Hidden Kompania ID -->
                <input type="hidden" name="id_kompania" value="{{ $Kompanite->id }}">

                <!-- Emri dhe NUIS -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="emri" class="form-label" style="font-size: 0.9rem;">Nome dell'Azienda</label>
                        <input type="text" name="emri" class="form-control form-control-sm" value="{{ $Kompanite->emri }}" placeholder="Inserisci il nome dell'azienda">
                        @error('emri')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nuis" class="form-label" style="font-size: 0.9rem;">NUIS</label>
                        <input type="text" name="nuis" class="form-control form-control-sm" value="{{ $Kompanite->nuis }}" placeholder="Inserisci il NIPT dell'azienda">
                        @error('nuis')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Adresa dhe Email -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="adresa" class="form-label" style="font-size: 0.9rem;">Indirizzo</label>
                        <input type="text" name="adresa" class="form-control form-control-sm" value="{{ $Kompanite->adresa }}" placeholder="Inserisci l'indirizzo dell'azienda">
                        @error('adresa')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label" style="font-size: 0.9rem;">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ $Kompanite->email }}" placeholder="Inserisci l'email dell'azienda">
                        @error('email')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Telefoni dhe Website -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="telefoni" class="form-label" style="font-size: 0.9rem;">Numero di Telefono</label>
                        <input type="text" name="telefoni" class="form-control form-control-sm" value="{{ $Kompanite->telefoni }}" placeholder="Inserisci il numero di telefono dell'azienda">
                        @error('telefoni')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="website" class="form-label" style="font-size: 0.9rem;">Sito Web</label>
                        <input type="text" name="website" class="form-control form-control-sm" value="{{ $Kompanite->website }}" placeholder="Inserisci il sito web dell'azienda">
                        @error('website')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data e Fillimit dhe Data e Mbarimit të Abonimit -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="data_fillimit_abonimit" class="form-label" style="font-size: 0.9rem;">Data di Inizio Abbonamento</label>
                        <input type="date" name="data_fillimit_abonimit" class="form-control form-control-sm" value="{{ $Kompanite->data_fillimit_abonimit }}">
                        @error('data_fillimit_abonimit')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="data_mbarimit_abonimit" class="form-label" style="font-size: 0.9rem;">Data di Fine Abbonamento</label>
                        <input type="date" name="data_mbarimit_abonimit" class="form-control form-control-sm" value="{{ $Kompanite->data_mbarimit_abonimit }}">
                        @error('data_mbarimit_abonimit')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Logo -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6 text-center">
                        <label class="form-label" style="font-size: 0.9rem;">Logo Esistente</label>
                        <div>
                            @if($Kompanite->logo)
                                <img src="{{ asset($Kompanite->logo) }}" alt="Logo dell'Azienda" loading="lazy" class="img-thumbnail" style="max-height: 150px;">
                            @else
                                <p class="text-muted" style="font-size: 0.8rem;">Nessun logo caricato.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="logo" class="form-label" style="font-size: 0.9rem;">Carica Logo</label>
                        <input type="file" name="logo" class="form-control form-control-sm">
                        @error('logo')
                        <div class="text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Statusi Aktiv -->
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="active" class="form-check-input" id="active" {{ $Kompanite->active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active" style="font-size: 0.9rem;">Attivo</label>
                </div>

                <!-- Footer -->
                <div class="text-center d-flex">
                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2 me-2">Salva Modifiche</button>
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
