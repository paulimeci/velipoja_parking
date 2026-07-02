<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog app_modal_sm">
        <div class="modal-content">
            <form action="{{ Route('store_kompanite') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary-800">
                    <h1 class="modal-title fs-5 text-white" id="exampleModal2">Aggiungi Azienda</h1>
                    <button type="button" class="fs-5 border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Emri -->
                    <div class="form-group">
                        <label for="emri">Nome dell'Azienda</label>
                        <input type="text" name="emri" class="form-control" value="{{ old('emri') }}" placeholder="Inserisci il nome dell'azienda">
                        @error('emri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NUIS -->
                    <div class="form-group">
                        <label for="nuis">Partita IVA</label>
                        <input type="text" name="nuis" class="form-control" value="{{ old('nuis') }}" placeholder="Inserisci il NUIS">
                        @error('nuis')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Adresa -->
                    <div class="form-group">
                        <label for="adresa">Indirizzo</label>
                        <input type="text" name="adresa" class="form-control" value="{{ old('adresa') }}" placeholder="Inserisci l'indirizzo">
                        @error('adresa')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Inserisci l'email">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Telefoni -->
                    <div class="form-group">
                        <label for="telefoni">Telefono</label>
                        <input type="text" name="telefoni" class="form-control" value="{{ old('telefoni') }}" placeholder="Inserisci il numero di telefono">
                        @error('telefoni')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="form-group">
                        <label for="website">Sito Web</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="Inserisci l'indirizzo del sito web">
                        @error('website')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Logo -->
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @error('logo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-light-primary">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>
</div>
