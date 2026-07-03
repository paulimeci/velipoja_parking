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
                <div class="card border border-{{ $color }} border-opacity-25 rounded-3 mb-3 bg-{{ $color }} bg-opacity-10
                            {{ $aktive ? 'border-2 border-' . $color . ' border-opacity-100 shadow-sm' : '' }}"
                     wire:click="filtroKat({{ $kategoria->id }})"
                     style="cursor:pointer; transition: transform .15s, box-shadow .15s;
                            {{ $aktive ? 'transform:translateY(-3px)' : '' }}">
                    <div class="card-body p-2 px-3">
                        <div class="d-flex justify-content-end gap-1 mb-1">
                            @if($aktive)
                                <button wire:click.stop="filtroKat(null)" class="border-0 bg-transparent p-0 lh-1" title="{{ __('Hiq filtrin') }}">
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
                            <span class="badge bg-primary bg-opacity-15 text-secondary  rounded-pill px-3 py-2 fs-13">
                                {{ __('Filtri') }}: {{ $katAktive->kategoria }}
                                <button wire:click="filtroKat(null)"
                                        class="border-0 bg-transparent p-0 ms-1 lh-1 text-primary align-middle"
                                        title="{{ __('Hiq filtrin') }}">
                                    <i class="material-symbols-outlined fs-14">close</i>
                                </button>
                            </span>
                        @endif
                    @endif
                </div>

                {{-- Formë kërkimi (Search) --}}
                <form class="position-relative table-src-form me-0" onsubmit="event.preventDefault();">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="{{ __('Kërko fashë orësh...') }}">
                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                </form>
            </div>

            {{-- TABELA E TË DHËNAVE --}}
            <div class="default-table-area style-two default-table-width">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('ID') }}</th>
                            <th scope="col">{{ __('Kategoria') }}</th>
                            <th scope="col">{{ __('Nga (Orë)') }}</th>
                            <th scope="col">{{ __('Deri Në (Orë)') }}</th>
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
                                    {{-- RIPARUAR: Tani shfaqet emri i kategorisë si tekst (24h, ore, fikse) --}}
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 fs-11 fw-semibold rounded-2">
                                        {{ $konfig->kategoria->kategoria ?? '—' }}
                                    </span>
                                </td>
                                <td class="fw-medium text-secondary">{{ $konfig->nga }} {{ __('orë') }}</td>
                                <td class="fw-medium text-secondary">
                                    {{ $konfig->ne >= 999 ? '8+' : $konfig->ne . ' ' . __('orë') }}
                                </td>
                                <td>
                                    {{-- RIPARUAR: Përdor atribute cmimet_mapped që rregulluam në backend --}}
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
                                <td colspan="7" class="text-center text-muted py-5 fs-14">
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
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold">
                            @if($isViewOnly) {{ __('Shiko Konfigurimin') }} @elseif($editingId) {{ __('Edito Konfigurimin') }} @else {{ __('Shto Konfigurim të Ri') }} @endif
                        </h5>
                        <button type="button" wire:click="$set('showOretModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body pt-3">

                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Kategoria e Rezervimit') }} <span class="text-danger">*</span></label>
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

                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Nga (Kohëzgjatja në Orë)') }} <span class="text-danger">*</span></label>
                            <input wire:model="ora_fillestare" type="number" step="0.01" min="0"
                                   {{ $isViewOnly ? 'disabled' : '' }}
                                   class="form-control rounded-2 @error('ora_fillestare') is-invalid @enderror"
                                   placeholder="{{ __('p.sh. 0') }}">
                            @error('ora_fillestare') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Deri Në (Kohëzgjatja në Orë)') }} <span class="text-danger">*</span></label>
                            <input wire:model="ora_limit" type="number" step="0.01" min="0"
                                   {{ $isViewOnly ? 'disabled' : '' }}
                                   class="form-control rounded-2 @error('ora_limit') is-invalid @enderror"
                                   placeholder="{{ __('p.sh. 2') }}">
                            @error('ora_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="text-muted my-3">
                        <h6 class="fw-semibold mb-3 text-secondary">{{ __('Çmimet sipas Monedhave') }}</h6>

                        @foreach($monedhat as $monedha)
                            <div class="mb-3">
                                <label class="form-label fw-medium">{{ __('Vlera në') }} {{ $monedha->emri }} ({{ $monedha->kodi }}) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="cmimet_monedhave.{{ $monedha->id }}" type="number" step="0.01" min="0"
                                           {{ $isViewOnly ? 'disabled' : '' }}
                                           class="form-control @error('cmimet_monedhave.' . $monedha->id) is-invalid @enderror"
                                           placeholder="{{ __('Vendos vlerën për') }} {{ $monedha->kodi }}">
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
                                class="btn btn-outline-secondary rounded-2">{{ __('Anulo') }}</button>
                        @if(!$isViewOnly)
                            <button type="button" wire:click="ruajOret" class="btn btn-primary rounded-2">
                                <span wire:loading wire:target="ruajOret" class="spinner-border spinner-border-sm me-1"></span>
                                {{ $editingId ? __('Ruaj Ndryshimet') : __('Ruaj Konfigurimin') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
