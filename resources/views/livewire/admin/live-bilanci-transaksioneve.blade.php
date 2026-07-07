<div>

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">

            {{-- ═══════════════════════════════════════
                  TABET: JAVA / MUAJI / PËRCAKTO
                 ════════════════════════════════════════ --}}
            <ul class="nav nav-tabs border-0 gap-3 mb-lg-4 mb-3 seller-tabs">
                <li class="nav-item">
                    <button type="button"
                            class="nav-link border-0 bg-body-bg text-secondary fw-medium fs-16 rounded-3 px-md-5 px-4 {{ $tipiPeriudhes === 'java' ? 'active' : '' }}"
                            wire:click="zgjidhTipin('java')">
                        <span class="d-inline-block py-1">{{ __('Java') }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button"
                            class="nav-link border-0 bg-body-bg text-secondary fw-medium fs-16 rounded-3 px-md-5 px-4 {{ $tipiPeriudhes === 'muaji' ? 'active' : '' }}"
                            wire:click="zgjidhTipin('muaji')">
                        <span class="d-inline-block py-1">{{ __('Muaji') }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button"
                            class="nav-link border-0 bg-body-bg text-secondary fw-medium fs-16 rounded-3 px-md-5 px-4 {{ $tipiPeriudhes === 'percaktuar' ? 'active' : '' }}"
                            wire:click="zgjidhTipin('percaktuar')">
                        <span class="d-inline-block py-1">{{ __('Përcakto') }}</span>
                    </button>
                </li>
            </ul>

            {{-- ═══════════════════════════════════════
                  FILTRAT SIPAS TIPIT TË ZGJEDHUR
                 ════════════════════════════════════════ --}}
            <div class="row g-3 mb-4">

                @if($tipiPeriudhes === 'java')
                    <div class="col-lg-4 col-md-6">
                        <label class="label text-secondary fw-medium mb-2">{{ __('Zgjidh Javën') }}</label>
                        <select wire:model.live="javaZgjedhur" class="form-select h-50 rounded-3">
                            <option value="aktuale">{{ __('Java Aktuale') }}</option>
                            <option value="e_shkuar">{{ __('Java e Kaluar') }}</option>
                            <option value="2javet">{{ __('2 Javët e Fundit') }}</option>
                            <option value="3javet">{{ __('3 Javët e Fundit') }}</option>
                            <option value="4javet">{{ __('4 Javët e Fundit') }}</option>
                        </select>
                    </div>
                @endif

                @if($tipiPeriudhes === 'muaji')
                    <div class="col-lg-3 col-md-6">
                        <label class="label text-secondary fw-medium mb-2">{{ __('Muaji') }}</label>
                        <select wire:model.live="muajiZgjedhur" class="form-select h-50 rounded-3">
                            @php
                                $muajt = [
                                    1 => 'Janar', 2 => 'Shkurt', 3 => 'Mars', 4 => 'Prill',
                                    5 => 'Maj', 6 => 'Qershor', 7 => 'Korrik', 8 => 'Gusht',
                                    9 => 'Shtator', 10 => 'Tetor', 11 => 'Nëntor', 12 => 'Dhjetor',
                                ];
                            @endphp
                            @foreach($muajt as $numri => $emri)
                                <option value="{{ $numri }}">{{ $emri }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="label text-secondary fw-medium mb-2">{{ __('Viti') }}</label>
                        <select wire:model.live="vitiZgjedhur" class="form-select h-50 rounded-3">
                            @for($v = now()->year; $v >= now()->year - 3; $v--)
                                <option value="{{ $v }}">{{ $v }}</option>
                            @endfor
                        </select>
                    </div>
                @endif

                @if($tipiPeriudhes === 'percaktuar')
                    <div class="col-lg-3 col-md-6">
                        <label class="label text-secondary fw-medium mb-2">{{ __('Nga Data') }}</label>
                        <input type="date" wire:model.live="data_nga" class="form-control h-50 rounded-3">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="label text-secondary fw-medium mb-2">{{ __('Deri Datë') }}</label>
                        <input type="date" wire:model.live="data_deri" class="form-control h-50 rounded-3">
                    </div>
                @endif

            </div>



            {{-- ═══════════════════════════════════════
                  TABELA E RAPORTIT
                 ════════════════════════════════════════ --}}
            <div class="default-table-area">
                <div class="table-responsive">

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <p class="text-secondary fs-13 mb-0">
                                {{ __('Periudha') }}: <strong>{{ $fillimi->format('d/m/Y') }} - {{ $fundi->format('d/m/Y') }}</strong>
                            </p>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            {{-- NEW: Dropdown filtri sipas Operatorit --}}
                            <select wire:model.live="operatoriZgjedhur" class="form-select form-select-sm rounded-3" style="min-width: 180px;">
                                <option value="">{{ __('Të gjithë Operatorët') }}</option>
                                @foreach($operatoret as $operatori)
                                    <option value="{{ $operatori->id }}">{{ $operatori->name }}</option>
                                @endforeach
                            </select>

                            <button type="button"
                                    wire:click="eksportoRaportinNeExcel"
                                    class="btn btn-success border-0 fw-bold fs-14 py-2 px-4 rounded-3 d-inline-flex align-items-center gap-1">
                                <span wire:loading wire:target="eksportoRaportinNeExcel" class="spinner-border spinner-border-sm"></span>
                                <i class="ri-file-excel-2-line fs-16"></i> {{ __('Eksporto Raportin') }}
                            </button>
                        </div>
                    </div>
                    <table class="table align-middle table-hover">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 60px;">#</th>
                            <th scope="col">{{ __('Data') }}</th>
                            <th scope="col">{{ __('Nr. Mjeteve') }}</th>
                            <th scope="col">{{ __('Pagesa Lek') }}</th>
                            <th scope="col">{{ __('Monedha të tjera') }}</th>
                            {{-- Rregulluar thirja e header-it që të përputhet me butonin --}}
                            <th scope="col" style="width: 140px;">{{ __('Veprimi') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($raportet as $index => $rreshti)
                            <tr>
                                <td class="text-body fw-medium">{{ $index + 1 }}</td>
                                <td class="text-secondary fw-medium">
                                    {{ \Carbon\Carbon::parse($rreshti['data'])->format('d/m/Y') }}
                                </td>
                                <td class="text-dark fw-bold">
                                    {{ $rreshti['nr_mjeteve'] }} Mjete
                                </td>
                                <td class="text-success fw-bold">
                                    {{ number_format($rreshti['pagesa_lek'], 2) }} LEK
                                </td>
                                <td class="text-secondary">
                                    @if(!empty($rreshti['monedhat_e_tjera']))
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($rreshti['monedhat_e_tjera'] as $kodiMonedhes => $vleraMonedhes)
                                                <div>
                                                    <span class="badge bg-light text-dark border border-light-subtle fw-bold fs-12 font-monospace">
                                                        {{ number_format($vleraMonedhes, 2) }} {{ $kodiMonedhes }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted fs-12">-</span>
                                    @endif
                                </td>
                                {{-- KORRIGJIMI: Hoqëm text-end dhe vendosëm gjerësi që të rrijë afër të dhënave --}}
                                <td>
                                    <button type="button"
                                            wire:click="shfaqDetajetEDates('{{ $rreshti['data'] }}')"
                                            class="btn btn-sm btn-light border border-light-subtle text-primary fw-semibold px-3 d-inline-flex align-items-center gap-1">
                                        <i class="ri-eye-line fs-14"></i> Detaje
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Nuk ka transaksione për këtë periudhë.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @if($shfaqModalDetaje)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1050;">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden bg-white">

                    {{-- HEADER MODAL --}}
                    <div class="modal-header bg-white border-bottom border-light-subtle py-3 px-4">
                        <h5 class="modal-title fw-bold text-dark fs-18 d-flex align-items-center">
                        <span class="p-2 bg-primary-subtle text-primary rounded-3 me-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="ri-history-fill fs-18"></i>
                        </span>
                            <span>Detajet e Mjeteve për Datën: <span class="text-primary fw-black font-monospace ms-1">{{ $dataEPerzgjedhur }}</span></span>
                        </h5>
                        <button type="button" class="btn-close shadow-none" wire:click="mbyllModalin()"></button>
                    </div>

                    {{-- BODY MODAL --}}
                    <div class="modal-body p-4 bg-white" style="max-height: 75vh; overflow-y: auto;">
                        @if(count($detajetMjeteve) > 0)
                            <div class="table-responsive rounded-3 bg-white border border-light-subtle shadow-sm">
                                <table class="table align-middle table-hover mb-0 text-nowrap">
                                    <thead class="bg-light border-bottom border-light-subtle text-uppercase text-secondary fs-12 fw-bold tracking-wider">
                                    <tr>
                                        <th scope="col" class="ps-4 py-3" style="width: 15%;">Targa</th>
                                        <th scope="col" style="width: 15%;">Hyrja</th>
                                        <th scope="col" style="width: 15%;">Ikja</th>
                                        <th scope="col" style="width: 20%;">Lloji Qëndrimit</th>
                                        <th scope="col" style="width: 15%;">Operatori</th>
                                        <th scope="col" class="text-end style="width: 10%;">Pagesa</th>
                                        <th scope="col" class="text-center pe-4" style="width: 10%;">Veprimi</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-14">
                                    @foreach($detajetMjeteve as $mjeti)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-inline-flex align-items-center bg-white border border-dark border-opacity-75 rounded shadow-sm px-3 py-1" style="height: 32px;">
                                                <span class="fs-14 fw-black text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                                    {{ $mjeti['targa'] }}
                                                </span>
                                                </div>
                                            </td>

                                            <td class="text-dark py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-login-box-line text-success opacity-75 me-2 fs-16"></i>
                                                    <div>
                                                        <span class="fw-bold text-dark fs-14">{{ \Carbon\Carbon::parse($mjeti['koha_hyrjes'])->format('H:i') }}</span>
                                                        <small class="d-block text-muted fs-11 font-monospace">{{ \Carbon\Carbon::parse($mjeti['koha_hyrjes'])->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-dark py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-logout-box-line text-danger opacity-75 me-2 fs-16"></i>
                                                    <div>
                                                        <span class="fw-bold text-dark fs-14">{{ \Carbon\Carbon::parse($mjeti['koha_ikjes'])->format('H:i') }}</span>
                                                        <small class="d-block text-muted fs-11 font-monospace">{{ \Carbon\Carbon::parse($mjeti['koha_ikjes'])->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-3">
                                                <div class="d-inline-flex align-items-center gap-1.5 flex-wrap">
                                                <span class="badge bg-indigo-subtle text-indigo border border-indigo-subtle rounded-pill fs-12 fw-semibold px-2.5 py-1"
                                                      style="background-color: #e0e7ff; color: #4338ca; border-color: #c7d2fe;">
                                                    {{ $mjeti['lloji_qendrimit'] }}
                                                </span>

                                                    @if($mjeti['njesia_matjes'] === 'dite' && !empty($mjeti['sasia']))
                                                        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle rounded-3 fs-11 fw-bold font-monospace px-2 py-0.5">
                                                        x{{ $mjeti['sasia'] }} {{ __('Ditë') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="py-3 text-secondary fw-medium">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="ri-user-received-2-line text-primary opacity-75 fs-15"></i>
                                                    <span class="fs-13 text-truncate" style="max-width: 120px;" title="{{ $mjeti['emri_operatorit'] }}">
                                                    {{ $mjeti['emri_operatorit'] ?? __('Pa emër') }}
                                                </span>
                                                </div>
                                            </td>

                                            <td class="text-end py-3 fw-bold text-dark fs-15">
                                                <span class="text-success-emphasis font-monospace fw-black">{{ number_format($mjeti['shuma'], 2) }}</span>
                                                <small class="text-secondary fw-bold fs-11 ms-1">{{ $mjeti['monedha_kodi'] }}</small>
                                            </td>

                                            <td class="text-center pe-4 py-3">
                                                <button type="button"
                                                        wire:click="editoTransaksionin({{ $mjeti['transaksioni_id'] }})"
                                                        class="btn btn-sm btn-warning bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle rounded-3 fw-semibold px-3 py-1 d-inline-flex align-items-center gap-1">
                                                    <i class="ri-edit-box-line fs-14"></i> {{ __('Edito') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 bg-white rounded-3 border border-light-subtle shadow-sm">
                                <div class="spinner-border text-primary mb-3" role="status" style="width: 2rem; height: 2rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-secondary mb-0 fs-14 fw-semibold">Duke ngarkuar listën e mjeteve...</p>
                            </div>
                        @endif
                    </div>

                    {{-- FOOTER MODAL --}}
                    <div class="modal-footer bg-white border-top border-light-subtle py-3 px-4">
                        <button type="button"
                                wire:click="eksportoDetajetNeExcel"
                                class="btn btn-success border-0 fw-bold fs-14 py-2 px-4 rounded-3 d-inline-flex align-items-center gap-1">
                            <span wire:loading wire:target="eksportoDetajetNeExcel" class="spinner-border spinner-border-sm"></span>
                            <i class="ri-file-excel-2-line fs-16"></i> {{ __('Eksporto në Excel') }}
                        </button>

                        <button type="button" class="btn btn-light border border-light-subtle text-secondary fw-bold fs-14 py-2 px-4 rounded-3" wire:click="mbyllModalin()">
                            Mbyll Dritaren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════
          MODAL I DYTË: EDITO / FSHIJ TRANSAKSIONIN
         ════════════════════════════════════════ --}}
    @if($shfaqModalEdit)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(2px); z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow-lg bg-white">

                    <div class="modal-header bg-light border-bottom py-3 px-4">
                        <h5 class="modal-title fw-bold text-dark fs-16">
                            <i class="ri-edit-2-fill text-warning me-1"></i> Modifiko Transaksionin
                        </h5>
                        <button type="button" class="btn-close shadow-none" wire:click="$set('shfaqModalEdit', false)"></button>
                    </div>

                    <form wire:submit.prevent="ruajNdryshimet">
                        <div class="modal-body p-4 bg-white">

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Targa</label>
                                <input type="text" wire:model="editTarga" class="form-control text-uppercase font-monospace fw-bold">
                                @error('editTarga') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold text-secondary fs-12">Monedha</label>
                                    <select wire:model.live="editMonedha" class="form-select fs-13 py-2 rounded-3">
                                        @foreach(\App\Models\Admin\Monedhat::all() as $monedha)
                                            <option value="{{ $monedha->id }}">{{ $monedha->kodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold text-secondary fs-12">Kategoria Qëndrimit</label>
                                    <select wire:model.live="editKategoria" class="form-select fs-13 py-2 rounded-3">
                                        @foreach(\DB::table('adm_kategoria_pageses')->get() as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->kategoria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- DINAMIKE SIPAS NJËSISË SË MATJES --}}
                            <div class="row g-3 mb-3">
                                @php
                                    $kategoriaAktualeEdit = \DB::table('adm_kategoria_pageses')->find($editKategoria);
                                @endphp

                                @if($kategoriaAktualeEdit && $kategoriaAktualeEdit->njesia_matjes === 'dite')
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-secondary fs-12">Sa Ditë / Netë?</label>
                                        <input type="number" step="1" min="1" wire:model.live="editSasia" class="form-control fs-13 py-2 rounded-3">
                                    </div>
                                @else
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-secondary fs-12">Fasha Orare</label>
                                        <select wire:model.live="editIdFasha" class="form-select fs-13 py-2 rounded-3">
                                            @forelse($editFashatOrare as $fasha)
                                                <option value="{{ $fasha->id }}">{{ $fasha->nga }} - {{ $fasha->ne }} orë</option>
                                            @empty
                                                <option value="">Nuk ka fasha të përcaktuara për këtë shërbim</option>
                                            @endforelse
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary fs-12">Vlera për t'u Paguar</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" wire:model="editVlera" class="form-control fw-bold text-success fs-14 py-2 bg-light shadow-sm">
                                    <span class="input-group-text bg-light text-secondary border-start-0 fw-bold fs-12">
            {{ \App\Models\Admin\Monedhat::find($editMonedha)?->kodi ?? 'LEK' }}
        </span>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer bg-light border-top d-flex justify-content-between py-3 px-4">
                            <button type="button"
                                    wire:click="fshiTransaksionin"
                                    wire:confirm="A jeni i sigurt që dëshironi ta fshini këtë transaksion?"
                                    class="btn btn-danger fw-bold rounded-3">
                                <i class="ri-delete-bin-line"></i> Fshij
                            </button>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light border text-secondary fw-bold rounded-3" wire:click="$set('shfaqModalEdit', false)">
                                    Anulo
                                </button>
                                <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">
                                    Ruaj Ndryshimet
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif
</div>
