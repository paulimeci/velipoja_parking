<div>
    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                <form class="position-relative table-src-form me-0" onsubmit="event.preventDefault();">
                    <input type="text" class="form-control" placeholder="Search here">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                </form>

                <button type="button" wire:click="hapModalin" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                    <span class="py-sm-1 d-block">
                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                        <span>Shto Konfigurim Orësh</span>
                    </span>
                </button>
            </div>

            @if($showOretModal)
                <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-3 shadow">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-semibold">
                                    @if($isViewOnly) Shiko Konfigurimin @elseif($editingId) Edito Konfigurimin @else Shto Konfigurim të Ri @endif
                                </h5>
                                <button type="button" wire:click="$set('showOretModal', false)" class="btn-close"></button>
                            </div>
                            <div class="modal-body pt-3">

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Nga (Kohëzgjatja në Orë) <span class="text-danger">*</span></label>
                                    <input wire:model="ora_fillestare" type="number" step="0.01" min="0"
                                           {{ $isViewOnly ? 'disabled' : '' }}
                                           class="form-control rounded-2 @error('ora_fillestare') is-invalid @enderror"
                                           placeholder="p.sh. 0">
                                    @error('ora_fillestare') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Deri Në (Kohëzgjatja në Orë) <span class="text-danger">*</span></label>
                                    <input wire:model="ora_limit" type="number" step="0.01" min="0"
                                           {{ $isViewOnly ? 'disabled' : '' }}
                                           class="form-control rounded-2 @error('ora_limit') is-invalid @enderror"
                                           placeholder="p.sh. 2">
                                    @error('ora_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <hr class="text-muted my-3">
                                <h6 class="fw-semibold mb-3 text-secondary">Çmimet sipas Monedhave</h6>

                                @foreach($monedhat as $monedha)
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Vlera në {{ $monedha->emri }} ({{ $monedha->kodi }}) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input wire:model="cmimet_monedhave.{{ $monedha->id }}" type="number" step="0.01" min="0"
                                                   {{ $isViewOnly ? 'disabled' : '' }}
                                                   class="form-control @error('cmimet_monedhave.' . $monedha->id) is-invalid @enderror"
                                                   placeholder="Vendos vlerën për {{ $monedha->kodi }}">
                                            <span class="input-group-text bg-light fw-semibold rounded-end-2">{{ $monedha->kodi }}</span>
                                        </div>
                                        @error('cmimet_monedhave.' . $monedha->id)
                                        <div class="text-danger fs-13 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach

                            </div>
                            <div class="modal-footer border-0 pt-2">
                                <button type="button" wire:click="$set('showOretModal', false)"
                                        class="btn btn-outline-secondary rounded-2">Anulo</button>
                                @if(!$isViewOnly)
                                    <button type="button" wire:click="ruajOret" class="btn btn-primary rounded-2">
                                        <span wire:loading wire:target="ruajOret" class="spinner-border spinner-border-sm me-1"></span>
                                        {{ $editingId ? 'Ruaj Ndryshimet' : 'Ruaj Konfigurimin' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="default-table-area style-two default-table-width">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nga (Orë)</th>
                            <th scope="col">Deri Në (Orë)</th>
                            <th scope="col">Çmimi Kryesor (ALL)</th>
                            <th scope="col">Çmime te tjera</th>
                            <th scope="col">Veprime</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($konfigurimet as $konfig)
                            <tr wire:key="konfig-{{ $konfig->id }}">
                                <td>#{{ $konfig->id }}</td>
                                <td class="fw-medium text-secondary">{{ $konfig->nga }} orë</td>
                                <td class="fw-medium text-secondary">
                                    {{ $konfig->ne >= 999 ? '8+' : $konfig->ne . ' orë' }}
                                </td>
                                <td>
                                    <div class="mb-1">
                            <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-semibold">
                                {{ number_format($konfig->cmimet['ALL'] ?? 0, 0, ',', '.') }} ALL
                            </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 mt-1">
                                        @if(isset($konfig->cmimet['EUR']))
                                            <small class="text-muted fs-11 bg-light px-2 py-0.5 rounded border">
                                                <span class="fw-medium text-primary">EUR:</span> €{{ number_format($konfig->cmimet['EUR'], 2) }}
                                            </small>
                                        @endif

                                        @if(isset($konfig->cmimet['USD']))
                                            <small class="text-muted fs-11 bg-light px-2 py-0.5 rounded border">
                                                <span class="fw-medium text-warning">USD:</span> ${{ number_format($konfig->cmimet['USD'], 2) }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button" wire:click="shikoOret({{ $konfig->id }})" class="ps-0 border-0 bg-transparent lh-1">
                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                        </button>
                                        <button type="button" wire:click="editOret({{ $konfig->id }})" class="ps-0 border-0 bg-transparent lh-1">
                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                        </button>
                                        <button type="button" wire:click="fshiOret({{ $konfig->id }})"
                                                wire:confirm="A jeni i sigurt që dëshironi ta fshini këtë fashë?"
                                                class="ps-0 border-0 bg-transparent lh-1">
                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted p-4">
                                    Nuk ka asnjë konfigurim të regjistruar deri tani.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
