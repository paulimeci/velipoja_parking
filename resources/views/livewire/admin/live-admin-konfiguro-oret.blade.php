<div>
    @section('page-title', __('Konfigurimi i Orëve & Çmimeve'))

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">{{ __('Konfigurimi i Orëve') }}</span></li>
            </ol>
        </nav>
    @endsection

    {{-- ═══════════════════════════════════════
          SEKSIONI I KATEGORIVE (Stili i kutive me ngjyra)
         ════════════════════════════════════════ --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1 fw-semibold">{{ __('Kategoritë') }}</h5>
            <p class="text-secondary fs-13 mb-0">{{ __('Zgjidhni një kategori për të filtruar fashat e orëve...') }}</p>
        </div>
        <button type="button" wire:click="hapModalin" class="btn btn-primary rounded-3">
            <i class="ri-add-line me-1"></i> {{ __('Shto Konfigurim Orësh') }}
        </button>
    </div>

    <div class="row mb-2">
        @forelse($kategorite as $kategoria)
            @php
                $colors = ['primary','danger','success','warning','info'];
                $color  = $colors[$loop->index % count($colors)];
                $aktive = $filterKatId === $kategoria->id;
            @endphp
            <div class="col-xxl-2 col-xl-2 col-md-3 col-sm-4 col-6">
                {{-- RIPARUAR: Klikimi tani ndryshon variablën direkt me $set për siguri të lartë në Livewire --}}
                <div class="card border border-{{ $color }} border-opacity-25 rounded-3 mb-3 bg-{{ $color }} bg-opacity-10
                            {{ $aktive ? 'border-2 border-' . $color . ' border-opacity-100 shadow-sm' : '' }}"
                     wire:click="$set('filterKatId', {{ $kategoria->id }})"
                     style="cursor:pointer; transition: transform .15s, box-shadow .15s;
                            {{ $aktive ? 'transform:translateY(-3px)' : '' }}">
                    <div class="card-body p-2 px-3">
                        <div class="d-flex justify-content-end gap-1 mb-1">
                            @if($aktive)
                                <button wire:click.stop="$set('filterKatId', null)" class="border-0 bg-transparent p-0 lh-1" title="{{ __('Hiq filtrin') }}">
                                    <i class="material-symbols-outlined fs-14 text-danger">close</i>
                                </button>
                            @else
                                <span class="fs-14 text-transparent">&nbsp;</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2 py-1">
                            <i class="material-symbols-outlined fs-22 text-{{ $color }}">payments</i>
                            <span class="fs-13 fw-bold text-body">{{ $kategoria->kategoria }}</span>
                            @if($aktive)
                                <i class="material-symbols-outlined fs-13 text-{{ $color }} ms-auto">check_circle</i>
                            @endif
                        </div>
                        <span class="fs-11 text-secondary fw-medium">{{ __('Kliko për filtrim') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 rounded-3 mb-4">
                    <div class="card-body p-4 text-center text-secondary">
                        <i class="material-symbols-outlined fs-36 d-block mb-2 text-muted">category</i>
                        {{ __('Nuk ka kategori të disponueshme.') }}
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- ═══════════════════════════════════════
          SEKSIONI I TABELËS SË ORËVE
         ════════════════════════════════════════ --}}
    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 fw-semibold">{{ __('Orët & Çmimet') }}</h5>
                    @if($filterKatId)
                        @php $katAktive = $kategorite->firstWhere('id', $filterKatId); @endphp
                        @if($katAktive)
                            <span class="badge bg-primary bg-opacity-15 text-secondary rounded-pill px-3 py-2 fs-13">
                                {{ __('Filtri') }}: {{ $katAktive->kategoria }}
                                <button wire:click="$set('filterKatId', null)"
                                        class="border-0 bg-transparent p-0 ms-1 lh-1 text-primary align-middle"
                                        title="{{ __('Hiq filtrin') }}">
                                    <i class="material-symbols-outlined fs-14">close</i>
                                </button>
                            </span>
                        @endif
                    @endif
                </div>

                {{-- Formë kërkimi (Search) --}}
                <div class="position-relative table-src-form me-0">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control ps-5" placeholder="{{ __('Kërko fashë orësh...') }}">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y ms-3">search</i>
                </div>
            </div>

            {{-- TABELA E TË DHËNAVE --}}
            <div class="default-table-area style-two default-table-width">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('ID') }}</th>
                            <th scope="col">{{ __('Kategoria') }}</th>
                            <th scope="col">{{ __('Intervali / Mënyra Kohore') }}</th>
                            <th scope="col">{{ __('Çmimi Kryesor (ALL)') }}</th>
                            <th scope="col">{{ __('Çmime të tjera') }}</th>
                            <th scope="col" class="text-end pe-4">{{ __('Veprime') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($konfigurimet as $konfig)
                            <tr wire:key="konfig-{{ $konfig->id }}">
                                <td class="text-secondary fs-13">#{{ $konfig->id }}</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 fs-11 fw-semibold rounded-2">
                                        {{ $konfig->kategoria->kategoria ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    {{-- INTEGRUAR: Shfaqja inteligjente sipas strukturës së re të databazës --}}
                                    @if($konfig->ora_nisje)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1.5 font-mono fs-12 rounded-2">
                                            <i class="ri-time-line me-1"></i> Orar Muri: {{ $konfig->ora_nisje }} - {{ $konfig->ora_mbarimi }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark border px-2 py-1.5 font-mono fs-12 rounded-2">
                                            <i class="ri-hourglass-2-line me-1"></i> Sasi Kohe: {{ $konfig->nga }} - {{ $konfig->ne }} {{ __('orë') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fs-12 fw-bold rounded-2">
                                        {{ number_format($konfig->cmimet_mapped['ALL'] ?? 0, 0, ',', '.') }} ALL
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if(isset($konfig->cmimet_mapped['EUR']))
                                            <span class="badge border border-primary border-opacity-25 bg-primary bg-opacity-10 rounded-pill px-2 py-1 fs-11 fw-semibold text-primary">
                                                EUR: €{{ number_format($konfig->cmimet_mapped['EUR'], 2) }}
                                            </span>
                                        @endif

                                        @if(isset($konfig->cmimet_mapped['USD']))
                                            <span class="badge border border-warning border-opacity-25 bg-warning bg-opacity-10 rounded-pill px-2 py-1 fs-11 fw-semibold text-warning">
                                                USD: ${{ number_format($konfig->cmimet_mapped['USD'], 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-end gap-2 pe-3">
                                        <button type="button" wire:click="shikoOret({{ $konfig->id }})" class="p-0 border-0 bg-transparent lh-1" title="{{ __('Shiko') }}">
                                            <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                        </button>
                                        <button type="button" wire:click="editOret({{ $konfig->id }})" class="p-0 border-0 bg-transparent lh-1" title="{{ __('Edito') }}">
                                            <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                        </button>
                                        <button type="button" wire:click="fshiOret({{ $konfig->id }})"
                                                wire:confirm="{{ __('A jeni i sigurt që dëshironi ta fshini këtë fashë?') }}"
                                                class="p-0 border-0 bg-transparent lh-1" title="{{ __('Fshij') }}">
                                            <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5 fs-14">
                                    <i class="material-symbols-outlined fs-48 d-block mb-2 text-secondary">hourglass_empty</i>
                                    {{ __('Nuk ka asnjë konfigurim të regjistruar për këtë kategori.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════
          MODAL — SHTO / EDITO / SHIKO
         ════════════════════════════════════════ --}}
    @if($showOretModal)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45); backdrop-filter: blur(2px);">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold fs-16">
                            @if($isViewOnly) {{ __('Shiko Konfigurimin') }} @elseif($editingId) {{ __('Edito Konfigurimin') }} @else {{ __('Shto Konfigurim të Ri') }} @endif
                        </h5>
                        <button type="button" wire:click="$set('showOretModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body pt-3">

                        {{-- Kategoria --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium text-secondary small text-uppercase">{{ __('Kategoria e Rezervimit') }} <span class="text-danger">*</span></label>
                            <select wire:model="id_kategoria_rezervimit"
                                    {{ $isViewOnly ? 'disabled' : '' }}
                                    class="form-select rounded-2 @error('id_kategoria_rezervimit') is-invalid @enderror">
                                <option value="">-- {{ __('Zgjidh Kategorinë') }} --</option>
                                @foreach($kategorite as $kategoria)
                                    <option value="{{ $kategoria->id }}">{{ $kategoria->kategoria }}</option>
                                @endforeach
                            </select>
                            @error('id_kategoria_rezervimit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- SWITCH SELECTOR: Lejon zgjedhjen e llojit të inputit --}}
                        <div class="mb-3 p-2 bg-light rounded-2 border border-dashed">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="llojiKonfigurimit"
                                       wire:model.live="is_orar_muri" {{ $isViewOnly ? 'disabled' : '' }}>
                                <label class="form-check-label fw-semibold text-dark fs-13" for="llojiKonfigurimit">
                                    {{ __('Përdor Orar Muri (Fiks)') }}
                                </label>
                            </div>
                            <span class="text-secondary fs-11 d-block mt-1">
                                {{ $is_orar_muri ? __('Do të ruhet si fashë orari psh 14:00 - 22:00') : __('Do të ruhet si sasi orësh qëndrimi psh 0 - 12 orë') }}
                            </span>
                        </div>

                        {{-- INPUTET DINAMIKE (Ndryshojnë në bazë të vlerës së Switch-it lart) --}}
                        <div class="row g-2 mb-3">
                            @if($is_orar_muri)
                                {{-- NDRYSHIMI: Inputet tani janë të tipit "time" për përzgjedhje automatike --}}
                                <div class="col-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">{{ __('Ora e Nisjes') }} <span class="text-danger">*</span></label>
                                    <input wire:model="ora_fillestare" type="time" {{ $isViewOnly ? 'disabled' : '' }}
                                    class="form-control font-mono rounded-2 @error('ora_fillestare') is-invalid @enderror">
                                    @error('ora_fillestare') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">{{ __('Ora e Mbarimit') }} <span class="text-danger">*</span></label>
                                    <input wire:model="ora_limit" type="time" {{ $isViewOnly ? 'disabled' : '' }}
                                    class="form-control font-mono rounded-2 @error('ora_limit') is-invalid @enderror">
                                    @error('ora_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @else
                                {{-- Inputet për formatin Sasi Kohëzgjatje (numër i thjeshtë) mbeten njësoj --}}
                                <div class="col-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">{{ __('Nga (Orë)') }} <span class="text-danger">*</span></label>
                                    <input wire:model="ora_fillestare" type="number" step="0.5" min="0"
                                           {{ $isViewOnly ? 'disabled' : '' }}
                                           class="form-control font-mono rounded-2 @error('ora_fillestare') is-invalid @enderror"
                                           placeholder="p.sh. 0">
                                    @error('ora_fillestare') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-medium text-secondary small text-uppercase">{{ __('Deri Në (Orë)') }} <span class="text-danger">*</span></label>
                                    <input wire:model="ora_limit" type="number" step="0.5" min="0"
                                           {{ $isViewOnly ? 'disabled' : '' }}
                                           class="form-control font-mono rounded-2 @error('ora_limit') is-invalid @enderror"
                                           placeholder="p.sh. 12">
                                    @error('ora_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif
                        </div>

                        {{-- Seksioni i Çmimeve sipas Monedhave --}}
                        <div class="bg-light p-3 rounded-3 border">
                            <h6 class="fw-bold mb-3 text-secondary small text-uppercase tracking-wider">{{ __('Çmimet sipas Monedhave') }}</h6>

                            @foreach($monedhat as $monedha)
                                <div class="mb-2">
                                    <label class="form-label fw-medium fs-13 text-muted mb-1">{{ $monedha->emri }} ({{ $monedha->kodi }}) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <input wire:model="cmimet_monedhave.{{ $monedha->id }}" type="number" step="0.01" min="0"
                                               {{ $isViewOnly ? 'disabled' : '' }}
                                               class="form-control text-end pe-2 font-mono @error('cmimet_monedhave.' . $monedha->id) is-invalid @enderror"
                                               placeholder="0.00">
                                        <span class="input-group-text bg-white fw-bold text-secondary small" style="min-width: 50px; justify-content: center;">{{ $monedha->kodi }}</span>
                                    </div>
                                    @error('cmimet_monedhave.' . $monedha->id)
                                    <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="modal-footer border-0 pt-2">
                        <button type="button" wire:click="$set('showOretModal', false)"
                                class="btn btn-outline-secondary btn-sm rounded-2 px-3">{{ __('Anulo') }}</button>
                        @if(!$isViewOnly)
                            <button type="button" wire:click="ruajOret" class="btn btn-primary btn-sm rounded-2 px-3">
                                <span wire:loading wire:target="ruajOret" class="spinner-border spinner-border-sm me-1"></span>
                                {{ $editingId ? __('Ruaj Ndryshimet') : __('Ruaj') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
