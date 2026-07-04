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
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Data') }}</th>
                            <th scope="col">{{ __('Nr_Mjeteve') }}</th>
                            <th scope="col">{{ __('Pagesa Lek') }}</th>
                            <th scope="col">{{ __('Monedha te tjera') }}</th>
                            <th scope="col">{{ __('View More') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($raportet as $index => $rreshti)
                            <tr>
                                <td class="text-body">{{ $index + 1 }}</td>
                                <td class="text-secondary">
                                    {{ \Carbon\Carbon::parse($rreshti->data)->format('d/m/Y') }}
                                </td>
                                <td class="text-secondary">{{ $rreshti->nr_mjeteve }}</td>
                                <td class="text-secondary">{{ number_format($rreshti->pagesa_lek, 2) }} L</td>
                                <td class="text-secondary">{{ number_format($rreshti->monedha_te_tjera, 2) }}</td>
                                <td>
                                    <button type="button"
                                            wire:click="shfaqDetajetEDates('{{ $rreshti->data }}')"
                                            class="btn btn-link text-primary fs-13 fw-medium p-0 border-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetajeTransaksioneve">
                                        {{ __('Shiko') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">
                                    {{ __('Nuk ka të dhëna për këtë periudhë.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="modalDetajeTransaksioneve" tabindex="-1" aria-labelledby="modalDetajeTransaksioneveLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light py-3">
                    <h5 class="modal-title fw-bold text-dark fs-16" id="modalDetajeTransaksioneveLabel">
                        📊 Detajet e Mjeteve për Datën: <span class="text-primary">{{ $dataEPerzgjedhur }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">

                    @if(count($detajetMjeteve) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle table-hover border">
                                <thead class="bg-light bg-opacity-70 text-secondary fs-12 uppercase fw-bold">
                                <tr>
                                    <th scope="col" class="ps-3">Targa</th>
                                    <th scope="col">Hyrja</th>
                                    <th scope="col">Ikja</th>
                                    <th scope="col">Lloji Qëndrimit</th>
                                    <th scope="col" class="text-end pe-3">Pagesa</th>
                                </tr>
                                </thead>
                                <tbody class="fs-13">
                                @foreach($detajetMjeteve as $mjeti)
                                    <tr>
                                        <td class="ps-3">
                                            <span class="d-inline-block bg-light border border-dark rounded px-2 py-0.5 fw-bold text-dark text-uppercase font-monospace fs-12">
                                                {{ $mjeti['targa'] }}
                                            </span>
                                        </td>
                                        <td class="text-secondary">
                                            {{ \Carbon\Carbon::parse($mjeti['koha_hyrjes'])->format('H:i') }}
                                            <small class="d-block text-muted fs-11">{{ \Carbon\Carbon::parse($mjeti['koha_hyrjes'])->format('d/m/Y') }}</small>
                                        </td>
                                        <td class="text-secondary">
                                            {{ \Carbon\Carbon::parse($mjeti['koha_ikjes'])->format('H:i') }}
                                            <small class="d-block text-muted fs-11">{{ \Carbon\Carbon::parse($mjeti['koha_ikjes'])->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill fs-11 fw-medium px-2 py-1">
                                                {{ $mjeti['lloji_qendrimit'] }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3 fw-bold text-dark">
                                            {{ number_format($mjeti['shuma'], 2) }} {{ $mjeti['monedha_kodi'] }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="ri-information-line fs-24 d-block mb-2"></i>
                            Duke ngarkuar të dhënat...
                        </div>
                    @endif

                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary fs-13 py-2 px-4 rounded-3" data-bs-dismiss="modal">Mbyll</button>
                </div>
            </div>
        </div>
    </div>
</div>
