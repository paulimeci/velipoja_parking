
<form action="{{ Route('store_departaments') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="modal-body text-center">
        <!-- Hidden Field for Kompania -->
        <div class="form-group" hidden>
            <label for="id_kompania">Kompania</label>
            <input type="number" name="id_kompania" class="form-control" value="{{ request('kompania') }}">
        </div>

        <!-- Category Name -->
        <div class="form-group mb-3">
            <label for="kategoria">Dipartimento</label>
            <input type="text" name="departamenti" class="form-control" value="{{ old('departamenti') }}" placeholder="Inserisci il nome di un reparto.">
            @error('departamenti')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="pershkrimi">Descrizione</label>
            <input type="text" name="pershkrimi" class="form-control" value="{{ old('pershkrimi') }}" placeholder="Inserisci una descrizione.">
            @error('pershkrimi')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Logo Upload -->
        <div class="form-group mb-3">
            <label for="img_logo">Logo</label>
            <input type="file" name="img_logo" class="form-control">
            @error('img_logo')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="modal-footer  d-flex justify-content-between">
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Chiudi</button>
        <button type="submit" class="btn btn-light-primary">Salva</button>
    </div>
</form>
