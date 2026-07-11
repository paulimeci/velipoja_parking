<div>
@section('page-title', __('Kryej Operacionet'))

{{-- ═══════════════════════════════════════
      SEKSIONI 1: FORMA E REGJISTRIMIT
     ════════════════════════════════════════ --}}
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card bg-white border-0 rounded-3 mb-4">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fs-18 mb-0">{{ __('Regjistro Hyrjen / Operacionin') }}</h4>
                    @if (session()->has('success'))
                        <span class="badge bg-success bg-opacity-10 text-success p-2 px-3 rounded-2 fs-13">
                                <i class="ri-checkbox-circle-line align-middle me-1"></i> {{ session('success') }}
                            </span>
                    @endif
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="preview-tab-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                        {{-- ═══ Forma e regjistrimit ═══ --}}
                        <form wire:submit.prevent="ruajOperacionin">
                            <div class="row align-items-end">

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label class="label text-secondary fw-medium mb-2">{{ __('Targa e Makinës') }} <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="targa"
                                               class="form-control h-60 rounded-3 @error('targa') is-invalid @enderror"
                                               placeholder="{{ __('Shkruaj targën (p.sh. AB123CD)') }}">
                                        @error('targa') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4 d-flex align-items-center h-60">
                                        <div class="form-check form-switch custom-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="paguarSwitch"
                                                   wire:model.live="eshte_paguar" style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                            <label class="form-check-input-label text-secondary fw-medium ms-2" for="paguarSwitch" style="cursor: pointer;">
                                                {{ __('Është Paguar?') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-end mt-2">
                                    <button type="submit" class="btn btn-primary py-2 px-4 fs-14 fw-semibold rounded-3 shadow-sm">
                                        <span wire:loading wire:target="ruajOperacionin" class="spinner-border spinner-border-sm me-2"></span>
                                        <i class="ri-save-line me-1"></i> {{ __('Regjistro Operacionin') }}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
      SEKSIONI 2: KËRKIMI DHE MJETET PREZENT
     ════════════════════════════════════════ --}}
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mt-2">
    <h5 class="fs-16 fw-semibold mb-0">{{ __('Mjetet Prezent në Parking') }}</h5>

    <div class="position-relative" style="min-width: 260px;">
        <input type="text" wire:model.live="kerkoTarge"
               class="form-control bg-white border border-secondary border-opacity-25 rounded-3 py-2 ps-4 pe-5 fs-13"
               placeholder="{{ __('Kërko targë në parking...') }}">
        <i class="ri-search-line position-absolute top-50 end-0 translate-middle-y me-3 text-secondary fs-16"></i>
    </div>
</div>

    <div class="row gx-2 gy-2">

        @forelse($mjetePrezent as $mjeti)
            @php
                $statusi = $this->statusiSkadimit($mjeti);
            @endphp
            <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6" wire:key="mjeti-{{ $mjeti->id }}">
                <div class="card {{ $statusi['skaduar'] ? 'bg-warning bg-opacity-10' : 'bg-primary bg-opacity-10' }} border-0 rounded-3 mb-2 file-for-dark shadow-sm">
                    <div class="card-body p-2.5">

                        {{-- SEKSIONI SIPËR: STATUSI DHE ORA NË KRAH --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-1">
                                @if($statusi['skaduar'])
                                    <span class="badge bg-warning bg-opacity-25 rounded-pill px-1.5 py-0.5 fs-10 fw-bold" style="color:#997404;">
                                    <i class="ri-alarm-warning-fill fs-7 align-middle me-0.5"></i>{{ __('Skaduar') }}
                                </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-1.5 py-0.5 fs-10 fw-medium">
                                    <i class="ri-checkbox-blank-circle-fill fs-7 align-middle me-0.5"></i>{{ __('Prezent') }}
                                </span>
                                @endif
                                <span class="text-secondary fw-medium" style="font-size: 11px;">
                                {{ \Carbon\Carbon::parse($mjeti->nisja)->format('H:i') }}
                            </span>
                            </div>

                            {{-- Menuja e opsioneve (Dropdown) --}}
                            <div class="dropdown action-opt">
                                <button class="p-0 border-0 bg-transparent line-height-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-symbols-outlined text-body hover fs-18">more_horiz</i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow py-1">
                                    <li><a class="dropdown-item py-1 fs-12" href="javascript:void(0);">{{ __('Detajet') }}</a></li>
                                    <li><a class="dropdown-item py-1 fs-12" href="javascript:void(0);">{{ __('Edito') }}</a></li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger py-1 fs-12" href="javascript:void(0);"
                                           wire:click="largoMjetin({{ $mjeti->id }})"
                                           wire:confirm="A je i sigurt që dëshiron ta largosh këtë mjet?">
                                            {{ __('Largo') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- SEKSIONI QENDROR: TARGA --}}
                        <div class="text-center py-2.5 my-1">
                            <div class="d-inline-flex align-items-center justify-content-center bg-white border {{ $statusi['skaduar'] ? 'border-warning' : 'border-dark' }} border-2 rounded-2 w-100 shadow-sm"
                                 style="height: 40px; cursor: pointer;"
                                 wire:click="shfaqModalPagesen({{ $mjeti->id }})">
                            <span class="fs-18 fw-bolder text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                {{ $mjeti->targa }}
                            </span>
                            </div>
                        </div>

                        {{-- SEKSIONI POSHTË: STATUSI I PAGESËS --}}
                        <div class="d-flex justify-content-between align-items-center border-top border-dark border-opacity-10 pt-1.5">
                            <span class="fs-10 text-secondary">{{ __('Pagesa') }}:</span>
                            @if($statusi['skaduar'])
                                <span class="badge bg-warning bg-opacity-25 rounded-2 px-1.5 py-0.5 fs-10 fw-bold" style="color:#997404;" title="{{ __('Ka kaluar koha e paguar') }}">
                                <i class="ri-time-line me-1"></i>{{ __('Skaduar') }}
                            </span>
                            @elseif($statusi['paguar'])
                                <span class="badge bg-success bg-opacity-10 text-success rounded-2 px-1.5 py-0.5 fs-10 fw-bold">
                                {{ __('Paguar') }}
                            </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-2 px-1.5 py-0.5 fs-10 fw-bold">
                                {{ __('Pa Paguar') }}
                            </span>
                            @endif
                        </div>

                        {{-- NEW: buton shtesë kur ka skaduar, për rinovim të shpejtë --}}
                        @if($statusi['skaduar'])
                            <button type="button"
                                    wire:click="shfaqModalPagesen({{ $mjeti->id }})"
                                    class="btn btn-warning btn-sm w-100 mt-2 py-1 fs-11 fw-bold rounded-2">
                                <i class="ri-refresh-line me-1"></i>{{ __('Rinovo Pagesën') }}
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-secondary text-center py-4 bg-white rounded-3 border">{{ __('Nuk u gjet asnjë mjet prezent.') }}</p>
            </div>
        @endforelse
    </div>

{{-- ═══════════════════════════════════════
      SEKSIONI 3: MODAL POP-UP (PAGESA / MBYLLJA)
     ════════════════════════════════════════ --}}
@if($klickedTarga)
    <div class="modal fade show d-block" id="modalPagesaMjetit" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-white shadow rounded-3">

                {{-- KOKA E MODALIT --}}
                <div class="modal-header border-bottom p-4">
                    <h5 class="modal-title fs-16 fw-semibold">
                        <i class="ri-money-dollar-circle-line align-middle me-1 text-primary fs-20"></i>
                        @if($eshteRegjistrimParaprak)
                            {{ __('Pagesa Paraprake — Mjeti Mbetet Prezent') }}
                        @else
                            {{ __('Procedo me Mbylljen / Pagesën') }}
                        @endif
                    </h5>
                    <button type="button" class="btn-close shadow-none" wire:click="$set('klickedTarga', false)"></button>
                </div>

                {{-- TRUPI --}}
                <div class="modal-body p-4">
                    @if($mjetiZgjedhur)
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light border border-dark border-2 rounded-2 px-4 py-1" style="min-width: 160px; height: 45px;">
                                    <span class="fs-20 fw-black text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                        {{ $mjetiZgjedhur->targa }}
                                    </span>
                            </div>
                        </div>

                        <table class="table table-sm table-borderless fs-13 mb-3">
                            <tbody>
                            <tr class="border-bottom border-light">
                                <td class="text-secondary py-2 fw-medium">{{ __('Koha e Hyrjes') }}:</td>
                                <td class="text-dark py-2 fw-semibold text-end">
                                    {{ \Carbon\Carbon::parse($mjetiZgjedhur->nisja)->format('d/m/Y - H:i') }}
                                </td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="text-secondary py-2 fw-medium">{{ __('Koha Aktuale') }}:</td>
                                <td class="text-primary py-2 fw-semibold text-end">
                                    {{ \Carbon\Carbon::now()->format('d/m/Y - H:i') }}
                                </td>
                            </tr>
                            <tr class="border-bottom border-light bg-light bg-opacity-50">
                                <td class="text-secondary py-2 fw-bold text-danger">{{ __('Koha e Qëndrimit') }}:</td>
                                <td class="text-danger py-2 fw-bold text-end fs-14">
                                    <i class="ri-time-line me-1"></i> {{ $koha_qendrimit }}
                                </td>
                            </tr>
                            @if($transaksioniIRuajtur && $transaksioniIRuajtur->fashaOrare)
                                <tr class="border-bottom border-light">
                                    <td class="text-secondary py-2 fw-medium">{{ __('Statusi') }}:</td>
                                    <td class="py-2 text-end">
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-2 px-2 py-1 fs-12 fw-bold">
                                                    {{ __('Paguar') }} [{{ $transaksioniIRuajtur->fashaOrare->nga }}-{{ $transaksioniIRuajtur->fashaOrare->ne }}]
                                                </span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        <div class="row g-3 mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="label text-secondary fw-medium mb-1 fs-12">{{ __('Ndrysho Shërbimin') }}</label>
                                    <select wire:model.live="modal_id_kategoria" class="form-select fs-13 py-2 rounded-3">
                                        @foreach($kategorite as $kategoria)
                                            <option value="{{ $kategoria->id }}">{{ $kategoria->kategoria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="label text-secondary fw-medium mb-1 fs-12">{{ __('Monedha e Pagesës') }}</label>
                                    <select wire:model.live="modal_id_monedha" class="form-select fs-13 py-2 rounded-3">
                                        @foreach($monedhat as $monedha)
                                            <option value="{{ $monedha->id }}">{{ $monedha->kodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if($kategoriaAktuale && $kategoriaAktuale->njesia_matjes === 'dite')
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="label text-secondary fw-medium mb-1 fs-12">{{ __('Sa Ditë / Netë?') }}</label>
                                        <input type="number" step="1" min="1" wire:model.live="modal_sasia" class="form-control fs-13 py-2 rounded-3" placeholder="{{ __('p.sh. 2') }}">
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="label text-secondary fw-medium mb-1 fs-12">{{ __('Fasha Orare') }}</label>
                                        <select wire:model.live="modal_id_fasha" class="form-select fs-13 py-2 rounded-3">
                                            @forelse($fashatOrare as $fasha)
                                                <option value="{{ $fasha->id }}">{{ $fasha->nga }} - {{ $fasha->ne }} {{ __('orë') }}</option>
                                            @empty
                                                <option value="">{{ __('Nuk ka fasha të përcaktuara për këtë shërbim') }}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="label text-secondary fw-medium mb-1 fs-12">{{ __('Mënyra e Pagesës') }}</label>
                                    <select wire:model.live="metoda_pageses" class="form-select fs-13 py-2 rounded-3">
                                        <option value="kesh">💵 {{ __('Kesh / Cash') }}</option>
                                        <option value="karte">💳 {{ __('Kartë Debiti/Krediti') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="label text-secondary fw-medium mb-1 fs-12">{{ __('Vlera për t\'u Paguar') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" wire:model="modal_vlera" class="form-control fs-14 fw-semibold py-2 rounded-start-3 @error('modal_vlera') is-invalid @enderror" placeholder="0.00">
                                        <span class="input-group-text bg-light text-secondary border-start-0 fw-bold fs-12 rounded-end-3">
                                                {{ collect($monedhat)->firstWhere('id', $modal_id_monedha)->kodi ?? 'LEK' }}
                                            </span>
                                    </div>
                                    @error('modal_vlera') <div class="invalid-feedback d-block mt-1 fs-12">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                            <p class="text-secondary fs-12 mt-2 mb-0">{{ __('Duke ngarkuar të dhënat...') }}</p>
                        </div>
                    @endif
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-top p-3 d-flex justify-content-end gap-2 bg-light bg-opacity-50">
                    <button type="button" class="btn btn-secondary py-2 px-3 fs-13 fw-semibold rounded-3 text-dark border-0 bg-gray bg-opacity-10" wire:click="$set('klickedTarga', false)">
                        {{ __('Anulo') }}
                    </button>
                    <button type="button" class="btn btn-success py-2 px-3 fs-13 fw-semibold rounded-3 text-white" wire:click="ruajTransaksionin">
                        <i class="ri-check-double-line me-1"></i>
                        @if($eshteRegjistrimParaprak)
                            {{ __('Ruaj Pagesën') }}
                        @else
                            {{ __('Përfundo & Mbyll Operacionin') }}
                        @endif
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif


    {{-- ═══════════════════════════════════════
          MODAL POP-UP: SKADIMI I KOHËS SË PAGUAR
         ════════════════════════════════════════ --}}
    @if($shfaqModalSkadimi && $mjetiSkaduarZgjedhur)
        <div class="modal fade show d-block" id="modalSkadimi" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.6); z-index: 1075;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 bg-white shadow rounded-3" style="border: 2px solid #ffc107 !important;">

                    <div class="modal-header border-bottom p-4" style="background: rgba(255,193,7,0.08);">
                        <h5 class="modal-title fs-16 fw-bold text-dark mb-0">
                            <i class="ri-alarm-warning-fill align-middle me-1 text-warning fs-22"></i>
                            {{ __('Koha e Paguar Ka Skaduar!') }}
                        </h5>
                        <button type="button" class="btn-close shadow-none" wire:click="mbyllModalSkadimi"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light border border-dark border-2 rounded-2 px-4 py-1" style="min-width: 160px; height: 45px;">
                            <span class="fs-20 fw-black text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                {{ $mjetiSkaduarZgjedhur->targa }}
                            </span>
                            </div>
                        </div>

                        @php
                            $oreLejuara = $detajetSkadimit['oreLejuara'] ?? 0;
                            $oreReale = $detajetSkadimit['oreReale'] ?? 0;
                            $teper = max($oreReale - $oreLejuara, 0);
                            $vleraEPaguar = $mjetiSkaduarZgjedhur->transaksioni->vlera ?? 0;
                            $kodiMonedhes = $mjetiSkaduarZgjedhur->transaksioni->monedhaRelacion->kodi ?? '';
                            $totaliIRi = $vleraEPaguar + $vlera_shtese;
                        @endphp

                        <table class="table table-sm table-borderless fs-13 mb-3">
                            <tbody>
                            <tr class="border-bottom border-light">
                                <td class="text-secondary py-2 fw-medium">{{ __('Koha e Hyrjes') }}:</td>
                                <td class="text-dark py-2 fw-semibold text-end">
                                    {{ \Carbon\Carbon::parse($mjetiSkaduarZgjedhur->nisja)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="text-secondary py-2 fw-medium">{{ __('Ora e Lejuar (Paguar)') }}:</td>
                                <td class="text-dark py-2 fw-semibold text-end">{{ round($oreLejuara, 2) }} {{ __('orë') }}</td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="text-secondary py-2 fw-medium">{{ __('Koha Reale e Qëndrimit') }}:</td>
                                <td class="text-dark py-2 fw-semibold text-end">{{ round($oreReale, 2) }} {{ __('orë') }}</td>
                            </tr>
                            <tr class="bg-danger bg-opacity-10">
                                <td class="text-danger py-2 fw-bold">{{ __('Tejkalimi') }}:</td>
                                <td class="text-danger py-2 fw-bold text-end">+{{ round($teper, 2) }} {{ __('orë') }}</td>
                            </tr>
                            </tbody>
                        </table>

                        {{-- NEW: një kuti e vetme, editueshme, pa dyfishim --}}
                        <div class="bg-warning bg-opacity-10 border border-warning rounded-3 p-3 mb-3">
                            <label class="label text-dark fw-bold mb-2 fs-13">
                                <i class="ri-edit-2-line me-1"></i>{{ __('Vlera Shtesë për t\'u Paguar') }}
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-warning bg-opacity-25 fw-bold border-warning">+</span>
                                <input type="number" step="0.01" min="0" wire:model.live="vlera_shtese"
                                       class="form-control fw-bolder text-warning fs-20 border-warning @error('vlera_shtese') is-invalid @enderror">
                                <span class="input-group-text bg-warning bg-opacity-25 fw-bold border-warning">{{ $kodiMonedhes }}</span>
                            </div>
                            @error('vlera_shtese') <div class="invalid-feedback d-block mt-1 fs-12">{{ $message }}</div> @enderror
                            <p class="text-secondary fs-11 mt-2 mb-0">{{ __('Kjo është VLERA TOTALE shtesë që do të regjistrohet si 1 pagesë. Mund ta ndryshoni.') }}</p>
                        </div>

                        <table class="table table-sm table-borderless fs-13 mb-0">
                            <tbody>
                            <tr class="border-bottom border-light">
                                <td class="text-secondary py-2 fw-medium">{{ __('Vlera e Paguar') }}:</td>
                                <td class="text-dark py-2 fw-semibold text-end">{{ number_format($vleraEPaguar, 2) }} {{ $kodiMonedhes }}</td>
                            </tr>
                            <tr class="border-bottom border-light">
                                <td class="text-warning py-2 fw-bold">{{ __('Vlera Shtesë (sugjeruar)') }}:</td>
                                <td class="text-warning py-2 fw-bold text-end">+ {{ number_format($vlera_shtese, 2) }} {{ $kodiMonedhes }}</td>
                            </tr>
                            <tr class="bg-success bg-opacity-10 rounded-2">
                                <td class="text-success py-2 fw-bold ps-2">{{ __('TOTALI I RI') }}:</td>
                                <td class="text-success py-2 fw-bolder text-end pe-2 fs-15">{{ number_format($totaliIRi, 2) }} {{ $kodiMonedhes }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer border-top p-3 d-flex flex-column gap-2 bg-light bg-opacity-50">
                        <button type="button" class="btn btn-success w-100 py-2 fs-13 fw-semibold rounded-3" wire:click="ruajPagesenShtese">
                            <span wire:loading wire:target="ruajPagesenShtese" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="ri-add-circle-line me-1"></i> {{ __('Regjistro Pagesën Shtesë') }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary w-100 py-2 fs-13 fw-semibold rounded-3" wire:click="injoroVlerenShtese">
                            <i class="ri-close-circle-line me-1"></i> {{ __('Injoro Shtesën (Tejkalim i Vogël)') }}
                        </button>
                        <button type="button" class="btn btn-link text-secondary w-100 py-1 fs-12" wire:click="mbyllModalSkadimi">
                            {{ __('Anulo') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif


{{-- ═══════════════════════════════════════
          SEKSIONI I RI: MJETET E SHËRBYERA (LARGUR)
         ════════════════════════════════════════ --}}
<div class="card bg-white border-0 rounded-3 mb-4 mt-5 shadow-sm">
    <div class="card-body p-4">

        {{-- Koka e seksionit dhe Tabet --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4 gap-3">
            <div>
                <h5 class="fs-16 fw-semibold mb-1"><i class="ri-history-line me-1 text-secondary"></i> {{ __('Mjetet e Shërbyera') }}</h5>
                <p class="text-secondary fs-12 mb-0">{{ __('Lista e makinave që kanë përfunduar operacionin dhe janë larguar.') }}</p>
            </div>

            {{-- Navigimi i Tabeve --}}
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="btn-group p-1 bg-light rounded-3" role="group">
                    <button type="button" wire:click="$set('tabiAktiv', 'sot')"
                            class="btn btn-sm rounded-2 px-3 fs-13 fw-medium {{ $tabiAktiv === 'sot' ? 'btn-primary text-white shadow-sm' : 'btn-light border-0 text-secondary' }}">
                        {{ __('Sot') }}
                    </button>
                    <button type="button" wire:click="$set('tabiAktiv', 'dje')"
                            class="btn btn-sm rounded-2 px-3 fs-13 fw-medium {{ $tabiAktiv === 'dje' ? 'btn-primary text-white shadow-sm' : 'btn-light border-0 text-secondary' }}">
                        {{ __('Dje') }}
                    </button>
                    <button type="button" wire:click="$set('tabiAktiv', 'cakto_daten')"
                            class="btn btn-sm rounded-2 px-3 fs-13 fw-medium {{ $tabiAktiv === 'cakto_daten' ? 'btn-primary text-white shadow-sm' : 'btn-light border-0 text-secondary' }}">
                        {{ __('Cakto Datën') }}
                    </button>
                </div>

                {{-- Shfaqet vetëm nëse klikohet tab-i "Cakto Datën" --}}
                @if($tabiAktiv === 'cakto_daten')
                    <div class="animate__animated animate__fadeIn">
                        <input type="date" wire:model.live="dataSpecifike" class="form-control form-control-sm border-secondary border-opacity-25 rounded-3 fs-13 py-1.5 px-2" style="width: 150px;">
                    </div>
                @endif
            </div>
        </div>

        {{-- Lista e makinave të larguara --}}
        <div class="row gx-2 gy-2">
            @forelse($mjeteLarguar as $mLarguar)
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="card bg-light border-0 rounded-3 mb-2 shadow-sm position-relative opacity-85">
                        <div class="card-body p-2.5">

                            <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-1.5 py-0.5 fs-10 fw-medium">
                                        <i class="ri-checkbox-circle-fill fs-7 align-middle me-0.5 text-muted"></i>{{ __('Larguar') }}
                                    </span>
                                <span class="text-secondary fw-semibold" style="font-size: 11px;">
                                        🕒 {{ \Carbon\Carbon::parse($mLarguar->ikja)->format('H:i') }}
                                    </span>
                            </div>

                            <div class="text-center py-2.5 my-1">
                                <div class="d-inline-flex align-items-center justify-content-center bg-white border border-secondary border-opacity-50 rounded-2 w-100"
                                     style="height: 40px; background-color: #fcfcfc !important; cursor: pointer;"
                                     wire:click="shfaqDetajetMjetitLarguar({{ $mLarguar->id }})">
                                        <span class="fs-16 fw-bold text-dark font-monospace text-uppercase" style="letter-spacing: 0.5px;">
            {{ $mLarguar->targa }}
        </span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top border-dark border-opacity-10 pt-1.5 fs-11 text-secondary">
                                <span>{{ __('Hyrja') }}: <b>{{ \Carbon\Carbon::parse($mLarguar->nisja)->format('H:i') }}</b></span>
                                @if($mLarguar->transaksioni)
                                    <span class="text-dark fw-bold">
                                        {{ number_format($mLarguar->vlera_totale_paguar, 2) }} {{ $mLarguar->transaksioni->monedhaRelacion->kodi ?? '' }}
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-light bg-opacity-50 rounded-3 border border-dashed">
                        <i class="ri-inbox-archive-line fs-32 text-secondary text-opacity-40"></i>
                        <p class="text-secondary fs-13 mt-2 mb-0">
                            {{ __('Nuk ka asnjë mjet të shërbyer për këtë përzgjedhje.') }}
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
{{-- ═══════════════════════════════════════
      MODAL POP-UP: DETAJET E MJETIT TË LARGUR
     ════════════════════════════════════════ --}}
@if($shfaqModalDetajet)
    <div class="modal fade show d-block" id="modalDetajetMjetit" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5); z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-white shadow rounded-3">

                {{-- KOKA E MODALIT --}}
                <div class="modal-header border-bottom p-4">
                    <h5 class="modal-title fs-16 fw-semibold text-secondary">
                        <i class="ri-information-line align-middle me-1 text-info fs-20"></i>
                        {{ __('Historiku & Detajet e Operacionit') }}
                    </h5>
                    <button type="button" class="btn-close shadow-none" wire:click="$set('shfaqModalDetajet', false)"></button>
                </div>

                {{-- TRUPI I MODALIT --}}
                <div class="modal-body p-4">
                    @if($mjetiLarguarZgjedhur)
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-dark text-white border border-dark rounded-2 px-4 py-1" style="min-width: 160px; height: 45px;">
                                    <span class="fs-20 fw-black font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                        {{ $mjetiLarguarZgjedhur->targa }}
                                    </span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs-13 mb-0">
                                <tbody>
                                <tr class="border-bottom border-light">
                                    <td class="text-secondary py-2.5 fw-medium">{{ __('Data/Ora Hyrjes') }}:</td>
                                    <td class="text-dark py-2.5 fw-semibold text-end">
                                        {{ \Carbon\Carbon::parse($mjetiLarguarZgjedhur->nisja)->format('d/m/Y - H:i:s') }}
                                    </td>
                                </tr>
                                <tr class="border-bottom border-light">
                                    <td class="text-secondary py-2.5 fw-medium">{{ __('Data/Ora Daljes') }}:</td>
                                    <td class="text-dark py-2.5 fw-semibold text-end">
                                        {{ $mjetiLarguarZgjedhur->ikja ? \Carbon\Carbon::parse($mjetiLarguarZgjedhur->ikja)->format('d/m/Y - H:i:s') : '-' }}
                                    </td>
                                </tr>
                                <tr class="border-bottom border-light">
                                    <td class="text-secondary py-2.5 fw-medium">{{ __('Koha totale e qëndrimit') }}:</td>
                                    <td class="text-danger py-2.5 fw-bold text-end">
                                        @php
                                            $hyrja = \Carbon\Carbon::parse($mjetiLarguarZgjedhur->nisja);
                                            $ikja = \Carbon\Carbon::parse($mjetiLarguarZgjedhur->ikja);
                                            echo $hyrja->diffForHumans($ikja, true);
                                        @endphp
                                    </td>
                                </tr>
                                <tr class="border-bottom border-light">
                                    <td class="text-secondary py-2.5 fw-medium">{{ __('Operatori Shërbyes') }}:</td>
                                    <td class="text-dark py-2.5 fw-semibold text-end">
                                                <span class="badge bg-light text-dark p-2 border">
                                                    👤 {{ $mjetiLarguarZgjedhur->operatori->name ?? __('I panjohur') }}
                                                </span>
                                    </td>
                                </tr>

                                @if($mjetiLarguarZgjedhur->transaksioni)
                                    <tr class="border-bottom border-light">
                                        <td class="text-secondary py-2.5 fw-medium">{{ __('Mënyra e Prenotimit/Shërbimi') }}:</td>
                                        <td class="text-primary py-2.5 fw-semibold text-end">
                                            {{ $mjetiLarguarZgjedhur->transaksioni->prenotimi->kategoria ?? __('Standard') }}
                                        </td>
                                    </tr>
                                    <tr class="border-bottom border-light">
                                        <td class="text-secondary py-2.5 fw-medium">{{ __('Fasha / Kohëzgjatja') }}:</td>
                                        <td class="text-dark py-2.5 fw-semibold text-end">
                                            @if($mjetiLarguarZgjedhur->transaksioni->prenotimi && $mjetiLarguarZgjedhur->transaksioni->prenotimi->njesia_matjes === 'dite')
                                                <span class="badge bg-warning bg-opacity-10 text-dark px-2 py-1 rounded" style="color: #856404;">
                <i class="ri-calendar-line me-1"></i>{{ $mjetiLarguarZgjedhur->transaksioni->sasia }} {{ __('Ditë') }}
            </span>
                                            @else
                                                @if($mjetiLarguarZgjedhur->transaksioni->fashaOrare)
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">
                    <i class="ri-time-line me-1"></i>{{ $mjetiLarguarZgjedhur->transaksioni->fashaOrare->nga }} - {{ $mjetiLarguarZgjedhur->transaksioni->fashaOrare->ne }} {{ __('orë') }}
                </span>
                                                @else
                                                    <span class="text-muted fs-12">{{ __('Standard') }}</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-bottom border-light">
                                        <td class="text-secondary py-2.5 fw-medium">{{ __('Mënyra e Pagesës') }}:</td>
                                        <td class="text-dark py-2.5 fw-semibold text-end text-capitalize">
                                            {{ $mjetiLarguarZgjedhur->transaksioni->metoda_pageses ?? 'Kesh' }}
                                        </td>
                                    </tr>
                                    <tr class="bg-success bg-opacity-10 rounded-2">
                                        <td class="text-success py-2.5 fw-bold ps-2">{{ __('Vlera e Paguar') }}:</td>
                                        <td class="text-success py-2.5 fw-bolder text-end pe-2 fs-15">
                                            {{ $mjetiLarguarZgjedhur->transaksioni->vlera }} {{ $mjetiLarguarZgjedhur->transaksioni->monedhaRelacion->kodi ?? 'ALL' }}
                                        </td>
                                    </tr>
                                @else
                                    <tr class="bg-danger bg-opacity-10 rounded-2">
                                        <td class="text-danger py-2.5 fw-bold ps-2">{{ __('Statusi') }}:</td>
                                        <td class="text-danger py-2.5 fw-bold text-end pe-2">
                                            {{ __('Pa transaksion të dokumentuar') }}
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="spinner-border text-info spinner-border-sm" role="status"></div>
                            <p class="text-secondary fs-12 mt-2 mb-0">{{ __('Duke ngarkuar të dhënat...') }}</p>
                        </div>
                    @endif
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-top p-3 bg-light bg-opacity-50 d-flex justify-content-between gap-2">

                    <button type="button" class="btn btn-primary py-2 px-3 fs-13 fw-semibold rounded-3 text-white border-0"
                            wire:click="printoHistorikunMjetitLarguar">
                        <span wire:loading wire:target="printoHistorikunMjetitLarguar" class="spinner-border spinner-border-sm me-1"></span>
                        <i class="ri-printer-line me-1"></i> {{ __('Printo Kupon Termik') }}
                    </button>

                    <button type="button" class="btn btn-secondary py-2 px-3 fs-13 fw-semibold rounded-3 text-dark border-0 bg-gray bg-opacity-20"
                            wire:click="$set('shfaqModalDetajet', false)">
                        {{ __('Mbyll dritaren') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
@endif

{{-- ═══════════════════════════════════════
      MODAL I RI: ZGJEDHJA E PRINTERIT (RawBT / Sistemi / GOOJPRT Bluetooth)
     ════════════════════════════════════════ --}}
    <div id="zonaPrintimitAutomatik" style="display: none;"></div>

    <script>
        // ══════════════════════════════════════════
        // PRINTIM AUTOMATIK ME PROTOKOLLIN RAWBT
        // ══════════════════════════════════════════
        document.addEventListener('livewire:init', () => {

            // 1. Kapja e eventit për daljen e mjetit
            Livewire.on('printo-ne-bluetooth', (event) => {
                ekzekutoPrintiminMeProtokoll(event.rawContent);
            });

            // 2. Kapja e eventit për parapagesën (fallback)
            Livewire.on('printo-bluetooth-fallback', (event) => {
                ekzekutoPrintiminMeProtokoll(event.rawContent);
            });
        });

        function ekzekutoPrintiminMeProtokoll(rawContent) {
            if (!rawContent) {
                console.error('[RawBT] Nuk ka përmbajtje tekstuale për faturën.');
                return;
            }

            try {
                console.log('[RawBT] Duke dërguar faturën automatikisht përmes Protokollit...');

                // Konvertim i sigurt në Base64 për të evituar problemet me karakteret shqip (ë, ç) ose kodet binarë ESC/POS
                const base64Content = btoa(unescape(encodeURIComponent(rawContent)));

                // Ndërtimi i skemës së saktë të Protokollit (Mënyra alternative që kërkove)
                const schemeUrl = 'rawbt:base64,' + base64Content;

                // Thirrja e menjëhershme e aplikacionit pa asnjë dritare ndërmjetëse
                window.location.href = schemeUrl;

            } catch (error) {
                console.error("[RawBT] Gabim gjatë procesimit të faturës:", error);
            }
        }
    </script>
</div>
