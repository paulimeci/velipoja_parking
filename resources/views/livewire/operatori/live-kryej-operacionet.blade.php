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
                            <div class="d-inline-flex align-items-center justify-content-center bg-white border border-dark border-2 rounded-2 w-100 shadow-sm"
                                 style="height: 40px; cursor: pointer;"
                                 wire:click="shfaqModalPagesen({{ $mjeti->id }})">
                                <span class="fs-18 fw-bolder text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                    {{ $mjeti->targa }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top border-dark border-opacity-10 pt-1.5">
                            <span class="fs-10 text-secondary">{{ __('Pagesa') }}:</span>
                            @if(isset($mjeti->transaksioni) && $mjeti->transaksioni->status_pagesa === 'paguar')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-2 px-1.5 py-0.5 fs-10 fw-bold">
                                    {{ __('Paguar') }}
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-2 px-1.5 py-0.5 fs-10 fw-bold">
                                    {{ __('Pa Paguar') }}
                                </span>
                            @endif
                        </div>

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

    {{-- STRUKTURA E FATURËS TERMRE --}}
    <div id="fatura-print" class="d-none-screen">
        <div class="fatura-container">
            <div class="text-center fw-bold fs-16 mb-1">VELIPOJA PARKING</div>
            <div class="text-center fs-11 mb-3">Faleminderit për vizitën tuaj!</div>

            <div class="vije-ndarese"></div>

            <table class="tabela-fature">
                <tr>
                    <td>TARGA:</td>
                    <td class="text-end fw-bold fs-14" id="fat-targa"></td>
                </tr>
                <tr>
                    <td>GJENDJA:</td>
                    <td class="text-end fw-bold" id="fat-status"></td>
                </tr>
                <tr>
                    <td>ORA E HYRJES:</td>
                    <td class="text-end" id="fat-hyrja"></td>
                </tr>
                <tr>
                    <td>ORA E IKJES:</td>
                    <td class="text-end" id="fat-ikja"></td>
                </tr>
                <tr>
                    <td>SHËRBIMI:</td>
                    <td class="text-end" id="fat-modaliteti"></td>
                </tr>
                <tr>
                    <td>SASIA / FASHA:</td>
                    <td class="text-end" id="fat-sasia"></td>
                </tr>
                <tr>
                    <td>PAGESA:</td>
                    <td class="text-end" id="fat-metoda"></td>
                </tr>
                <tr class="fs-13 fw-bold">
                    <td>TOTALI:</td>
                    <td class="text-end" id="fat-vlera"></td>
                </tr>
            </table>

            <div class="vije-ndarese"></div>

            <div class="text-center fs-10 mt-2">
                Operatori: <span id="fat-operatori"></span><br>
                Data: {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>

    {{-- STILE SHTESË PËR PRINTIM TË SAKTË TË FATURËS TERMRE 80mm/58mm NË A4 --}}
    <style>
        #fatura-print { display: none; }

        @media print {
            body * { display: none !important; }
            #fatura-print, #fatura-print * { display: block !important; }

            #fatura-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 40px;
                background: #fff;
                color: #000;
                font-family: 'Courier New', Courier, monospace;
            }

            .fatura-container {
                width: 120mm;
                margin: 0 auto;
                padding: 20px;
                border: 1px dashed #ccc;
            }

            .text-center { text-align: center; }
            .text-end { text-align: right; }
            .fw-bold { font-weight: bold; }
            .fs-16 { font-size: 20px; }
            .fs-14 { font-size: 16px; }
            .fs-13 { font-size: 15px; }
            .fs-11 { font-size: 13px; }
            .fs-10 { font-size: 12px; }
            .mb-1 { margin-bottom: 5px; }
            .mb-3 { margin-bottom: 15px; }
            .mt-2 { margin-top: 15px; }
            .vije-ndarese { border-top: 2px dashed #000; margin: 12px 0; }
            .tabela-fature { width: 100%; font-size: 13px; }
            .tabela-fature td { padding: 6px 0; vertical-align: top; }
        }
    </style>

    {{-- JAVASCRIPT KATCHER I EVENTIT NGA LIVEWIRE --}}
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('printo-faturen', (event) => {
                const data = event[0];

                // Mbushim HTML-në me të dhënat e faturës reale
                document.getElementById('fat-targa').innerText = data.targa;
                document.getElementById('fat-status').innerText = data.status;
                document.getElementById('fat-hyrja').innerText = data.hyrja;
                document.getElementById('fat-ikja').innerText = data.ikja;
                document.getElementById('fat-modaliteti').innerText = data.modaliteti;
                document.getElementById('fat-sasia').innerText = data.sasia; // Rregulluar këtu nga sasia_fasha në sasia
                document.getElementById('fat-metoda').innerText = data.metoda;
                document.getElementById('fat-vlera').innerText = data.vlera;
                document.getElementById('fat-operatori').innerText = data.operatori;

                setTimeout(() => {
                    window.print();
                }, 300);
            });
        });
    </script>
</div>
