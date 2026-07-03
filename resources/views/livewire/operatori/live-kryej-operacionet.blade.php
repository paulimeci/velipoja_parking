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
                            <form wire:submit.prevent="ruajOperacionin">
                                <div class="row align-items-end">

                                    {{-- INPUT 1: TARGA E MAKINËS --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fw-medium mb-2">{{ __('Targa e Makinës') }} <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="targa"
                                                   class="form-control h-60 rounded-3 @error('targa') is-invalid @enderror"
                                                   placeholder="{{ __('Shkruaj targën (p.sh. AB123CD)') }}">
                                            @error('targa') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- SELECT 2: KATEGORIA E SHËRBIMIT (24h, ore, dite_nate) --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fw-medium mb-2">{{ __('Zgjidh Shërbimin') }} <span class="text-danger">*</span></label>
                                            <div class="form-group position-relative">
                                                <select wire:model="id_kategoria" class="form-select form-control h-60 rounded-3 @error('id_kategoria') is-invalid @enderror">
                                                    <option value="" class="text-dark">-- {{ __('Zgjidh Shërbimin') }} --</option>
                                                    @foreach($kategorite as $kategoria)
                                                        <option value="{{ $kategoria->id }}" class="text-dark">{{ $kategoria->kategoria }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_kategoria') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SELECT 3: PERZGJEDHJA E MONEDHËS (Default: LEK/ALL) --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fw-medium mb-2">{{ __('Monedha e Pagesës') }} <span class="text-danger">*</span></label>
                                            <div class="form-group position-relative">
                                                <select wire:model="id_monedha" class="form-select form-control h-60 rounded-3 @error('id_monedha') is-invalid @enderror">
                                                    <option value="" class="text-dark">-- {{ __('Zgjidh Monedhën') }} --</option>
                                                    @foreach($monedhat as $monedha)
                                                        <option value="{{ $monedha->id }}" class="text-dark">{{ $monedha->emri }} ({{ $monedha->kodi }})</option>
                                                    @endforeach
                                                </select>
                                                @error('id_monedha') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SHTUESI 1: CHECKBOX "PAGUAR" --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4 d-flex align-items-center h-60">
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="paguarSwitch" wire:model.live="eshte_paguar" style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                                <label class="form-check-input-label text-secondary fw-medium ms-2" for="paguarSwitch" style="cursor: pointer;">
                                                    {{ __('Është Paguar?') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SHTUESI 2: FUSHA DINAMIKE E SHIFRËS --}}
                                    <div class="col-lg-4">
                                        @if($eshte_paguar)
                                            <div class="form-group mb-4 transition-element">
                                                <label class="label text-secondary fw-medium mb-2">{{ __('Shifra e Paguar (Vlera)') }} <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" wire:model="shuma_paguar"
                                                       class="form-control h-60 rounded-3 @error('shuma_paguar') is-invalid @enderror"
                                                       placeholder="{{ __('Vendos shifrën...') }}">
                                                @error('shuma_paguar') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-lg-4"></div>

                                    {{-- BUTONI PËR KRYERJEN E OPERACIONIT (I zvogëluar siç kërkove) --}}
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

        {{-- Kjo është fusha e kërkimit (Searchbox) në krah të djathtë --}}
        <div class="position-relative" style="min-width: 260px;">
            <input type="text" wire:model.live="kerkoTarge"
                   class="form-control bg-white border border-secondary border-opacity-25 rounded-3 py-2 ps-4 pe-5 fs-13"
                   placeholder="{{ __('Kërko targë në parking...') }}">
            <i class="ri-search-line position-absolute top-50 end-0 translate-middle-y me-3 text-secondary fs-16"></i>
        </div>
    </div>

    <div class="row gx-2 gy-2">

        @forelse($mjetePrezent as $mjeti)
            <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card bg-primary bg-opacity-10 border-0 rounded-3 mb-2 file-for-dark shadow-sm">
                    <div class="card-body p-2.5">

                        {{-- SEKSIONI SIPËR: STATUSI DHE ORA NË KRAH --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-1">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-1.5 py-0.5 fs-10 fw-medium">
                                    <i class="ri-checkbox-blank-circle-fill fs-7 align-middle me-0.5"></i>{{ __('Prezent') }}
                                </span>
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
                            <div class="d-inline-flex align-items-center justify-content-center bg-white border border-dark border-2 rounded-2 w-100 shadow-sm" style="height: 40px;">
                                <span class="fs-18 fw-bolder text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                    {{ $mjeti->targa }}
                                </span>
                            </div>
                        </div>

                        {{-- SEKSIONI POSHTË: STATUSI I PAGESËS --}}
                        <div class="d-flex justify-content-between align-items-center border-top border-dark border-opacity-10 pt-1.5">
                            <span class="fs-10 text-secondary">{{ __('Pagesa') }}:</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-2 px-1.5 py-0.5 fs-10 fw-bold">
                                {{ __('Pa Paguar') }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-secondary text-center py-4 bg-white rounded-3 border">{{ __('Nuk u gjet asnjë mjet prezent me këtë targë.') }}</p>
            </div>
        @endforelse

    </div>
</div>
