<div>
    @section('page-title', __('Menaxhimi i Gjuhëve'))

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">{{ __('Gjuhët') }}</span></li>
            </ol>
        </nav>
    @endsection

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-semibold">{{ __('Gjuhët') }}</h5>
                        <button wire:click="$set('showAddLanguageModal', true)" class="btn btn-sm btn-primary">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>

                    <div class="list-group">
                        @foreach($languages as $code)
                            <button type="button"
                                wire:click="selectLanguage('{{ $code }}')"
                                class="list-group-item list-group-item-action {{ $selectedLanguage == $code ? 'active' : '' }} d-flex justify-content-between align-items-center">
                                {{ strtoupper($code) }}
                                @if($selectedLanguage == $code)
                                    <i class="ri-check-line"></i>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if($selectedLanguage)
                <div class="card bg-white border-0 rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-semibold">{{ __('Përkthimet për') }}: {{ strtoupper($selectedLanguage) }}</h5>
                            <button wire:click="saveTranslations" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> {{ __('Ruaj Përkthimet') }}
                            </button>
                        </div>

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 40%">{{ __('Key') }}</th>
                                        <th>{{ __('Translation') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($translations as $key => $value)
                                        <tr>
                                            <td class="text-secondary">{{ $key }}</td>
                                            <td>
                                                <input type="text" wire:model="translations.{{ $key }}" class="form-control">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card bg-white border-0 rounded-3 mb-4">
                    <div class="card-body p-5 text-center">
                        <i class="ri-translate-2 fs-1 text-muted d-block mb-3"></i>
                        <h6 class="text-secondary">{{ __('Zgjidhni një gjuhë për të edituar përkthimet.') }}</h6>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($showAddLanguageModal)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Shto Gjuhë të Re') }}</h5>
                        <button type="button" wire:click="$set('showAddLanguageModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Kodi i Gjuhës (2 shkronja)') }}</label>
                            <input type="text" wire:model="newLanguageCode" class="form-control @error('newLanguageCode') is-invalid @enderror" placeholder="{{ __('p.sh. en, it, de') }}">
                            @error('newLanguageCode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted d-block mt-1">{{ __('Gjuha do të krijohet duke kopjuar çelësat nga gjuha Shqipe (sq).') }}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="$set('showAddLanguageModal', false)" class="btn btn-outline-secondary">{{ __('Anulo') }}</button>
                        <button type="button" wire:click="addLanguage" class="btn btn-primary">{{ __('Shto Gjuhën') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
