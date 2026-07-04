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

            <p class="text-secondary fs-13 mb-3">
                {{ __('Periudha') }}: <strong>{{ $fillimi->format('d/m/Y') }} - {{ $fundi->format('d/m/Y') }}</strong>
            </p>

            {{-- ═══════════════════════════════════════
                  TABELA E RAPORTIT
                 ════════════════════════════════════════ --}}
            <div class="default-table-area">
                <div class="table-responsive">
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
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
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
                    <div class="modal-body p-4 bg-white" style="max-height: 70vh; overflow-y: auto;">
                        @if(count($detajetMjeteve) > 0)
                            <div class="table-responsive rounded-3 bg-white border border-light-subtle shadow-sm">
                                <table class="table align-middle table-hover mb-0">
                                    <thead class="bg-white border-bottom border-light-subtle text-uppercase text-secondary fs-13 fw-bold tracking-wider">
                                    <tr>
                                        <th scope="col" class="ps-4 py-3">Targa</th>
                                        <th scope="col">Hyrja</th>
                                        <th scope="col">Ikja</th>
                                        <th scope="col">Lloji Qëndrimit</th>
                                        <th scope="col" class="text-end pe-4 py-3">Pagesa</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-15">
                                    @foreach($detajetMjeteve as $mjeti)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-inline-flex align-items-center bg-white border border-dark border-opacity-75 rounded shadow-sm px-3 py-1" style="height: 34px;">
                                                    <span class="fs-15 fw-black text-dark font-monospace text-uppercase" style="letter-spacing: 0.8px;">
                                                        {{ $mjeti['targa'] }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-dark py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-login-box-line text-success opacity-75 me-2 fs-16"></i>
                                                    <div>
                                                        <span class="fw-bold text-dark fs-15">{{ \Carbon\Carbon::parse($mjeti['koha_hyrjes'])->format('H:i') }}</span>
                                                        <small class="d-block text-muted fs-12 font-monospace">{{ \Carbon\Carbon::parse($mjeti['koha_hyrjes'])->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-dark py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-logout-box-line text-danger opacity-75 me-2 fs-16"></i>
                                                    <div>
                                                        <span class="fw-bold text-dark fs-15">{{ \Carbon\Carbon::parse($mjeti['koha_ikjes'])->format('H:i') }}</span>
                                                        <small class="d-block text-muted fs-12 font-monospace">{{ \Carbon\Carbon::parse($mjeti['koha_ikjes'])->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-indigo-subtle text-indigo border border-indigo-subtle rounded-pill fs-13 fw-semibold px-3 py-1.5" style="background-color: #e0e7ff; color: #4338ca; border-color: #c7d2fe;">
                                                    {{ $mjeti['lloji_qendrimit'] }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4 py-3 fw-bold text-dark fs-16">
                                                <span class="text-success-emphasis font-monospace fw-black">{{ number_format($mjeti['shuma'], 2) }}</span>
                                                <small class="text-secondary fw-bold fs-12 ms-1">{{ $mjeti['monedha_kodi'] }}</small>
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
                        <button type="button" class="btn btn-light border border-light-subtle text-secondary fw-bold fs-14 py-2 px-4 rounded-3" wire:click="mbyllModalin()">
                            Mbyll Dritaren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
