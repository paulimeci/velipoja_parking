<div class="modal fade" id="exampleModal" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog app_modal_sm">
        <div class="modal-content">
            <form action="{{ Route('store_staf') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary-800">
                    <h1 class="modal-title fs-5 text-white" id="exampleModal2">Aggiungi Partner</h1>
                    <button type="button" class="fs-5 border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Chiudi">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Campo Nascosto per l'Azienda -->
                    <div class="form-group" hidden>
                        <label for="id_kompania">Azienda</label>
                        <input type="number" name="kompania" class="form-control" value="{{ request('kompania') }}">
                    </div>

                    <!-- Dipartimento -->
                    <div class="form-group">
                        <label for="departamenti">Dipartimento</label>
                        <select name="departamenti" class="form-control">
                            <option value="">Scegli un dipartimento</option>
                            @foreach(\App\Models\My_App\Departamentet::All_Departament(request('kompania'), 1) as $departament)
                                <option value="{{ $departament->id }}" {{ old('departamenti') == $departament->id ? 'selected' : '' }}>
                                    {{ $departament->Departament_Lang->emri }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamenti')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Posizione -->
                    <div class="form-group">
                        <label for="pozicioni">Posizione</label>
                        <select name="pozicioni" class="form-control">
                            <option value="">Scegli una posizione</option>
                            @foreach(\App\Models\My_App\Pozicion_Pune::All_Pozicion_Pune(request('kompania'), 1) as $poz)
                                <option value="{{ $poz->id }}" {{ old('pozicioni') == $poz->id ? 'selected' : '' }}>
                                    {{ $poz->Pozicion_Lang->emri }}
                                </option>
                            @endforeach
                        </select>
                        @error('pozicioni')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ruolo di Accesso -->
                    <div class="form-group">
                        <label for="role_aksesi">Ruolo di Accesso</label>
                        <select name="role_aksesi" class="form-control">
                            <option value="">Scegli un ruolo</option>
                            @foreach(\App\Models\My_App\Role_Aksesi::All_Role_Aksesi(request('kompania'), 1) as $Rol)
                                <option value="{{ $Rol->id }}" {{ old('role_aksesi') == $Rol->id ? 'selected' : '' }}>
                                    {{ $Rol->Role_Aksesi_Lang->emri }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_aksesi')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nome e Cognome -->
                    <div class="form-group">
                        <label for="emri">Nome e Cognome</label>
                        <input type="text" name="emri" class="form-control" value="{{ old('emri') }}" placeholder="Inserisci il nome">
                        @error('emri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nome Utente -->
                    <div class="form-group">
                        <label for="username">Nome Utente</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Inserisci il nome utente">
                        @error('username')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Numero di Cellulare -->
                    <div class="form-group">
                        <label for="nr_cel">Numero di Cellulare</label>
                        <input type="text" name="nr_cel" class="form-control" value="{{ old('nr_cel') }}" placeholder="Inserisci il numero di cellulare">
                        @error('nr_cel')
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

                    <!-- Indirizzo -->
                    <div class="form-group">
                        <label for="adresa">Indirizzo</label>
                        <input type="text" name="adresa" class="form-control" value="{{ old('adresa') }}" placeholder="Inserisci l'indirizzo">
                        @error('adresa')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Carica Foto -->
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control">
                        @error('foto')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-light-primary">Salva modifiche</button>
                </div>
            </form>



        </div>
    </div>
</div>
