<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog app_modal_sm">
        <div class="modal-content">
            <form action="{{ Route('store_klient') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary-800">
                    <h1 class="modal-title fs-5 text-white" id="exampleModal2">Shto Klient</h1>
                    <button type="button" class="fs-5 border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Hidden Field for Kompania -->
                    <div class="form-group" hidden>
                        <label for="id_kompania">Kompania</label>
                        <input type="number" name="id_kompania" class="form-control" value="{{ request('kompania') }}">
                    </div>

                    <!-- Client ID -->
                    <div class="form-group">
                        <label for="client_id">ID e Klientit</label>
                        <input type="number" name="client_id" class="form-control" value="{{ old('client_id') }}" placeholder="Vendos ID e klientit">
                        @error('client_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- First Name -->
                    <div class="form-group">
                        <label for="emri">Emri</label>
                        <input type="text" name="emri" class="form-control" value="{{ old('emri') }}" placeholder="Vendos emrin">
                        @error('emri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="mbiemri">Mbiemri</label>
                        <input type="text" name="mbiemri" class="form-control" value="{{ old('mbiemri') }}" placeholder="Vendos mbiemrin">
                        @error('mbiemri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group">
                        <label for="nr_cel">Numri i Celularit</label>
                        <input type="text" name="nr_cel" class="form-control" value="{{ old('nr_cel') }}" placeholder="Vendos numrin e celularit">
                        @error('nr_cel')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Vendos email-in">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Registration Date -->
                    <div class="form-group">
                        <label for="date_regjistrimi">Data e Regjistrimit</label>
                        <input type="datetime-local" name="date_regjistrimi" class="form-control" value="{{ old('date_regjistrimi') }}">
                        @error('date_regjistrimi')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Player Category -->
                    <div class="form-group">
                        <label for="kategoria_lojtarit">Kategoria e Lojtarit</label>
                        <select name="kategoria_lojtarit" class="form-control">
                            <option value="">Zgjidh një kategori</option>
                            <option value="Amator" {{ old('kategoria_lojtarit') == 'Amator' ? 'selected' : '' }}>Amator</option>
                            <option value="Profesional" {{ old('kategoria_lojtarit') == 'Profesional' ? 'selected' : '' }}>Profesional</option>
                        </select>
                        @error('kategoria_lojtarit')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Mbyll</button>
                    <button type="submit" class="btn btn-light-primary">Ruaj Ndryshimet</button>
                </div>
            </form>
        </div>
    </div>
</div>
