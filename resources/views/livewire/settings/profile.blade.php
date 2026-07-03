<div>
    @section('page-title', __('Profili Im'))

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">{{ __('Cilësimet e Profilit') }}</span></li>
            </ol>
        </nav>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-2 fw-semibold">{{ __('Informacioni i Profilit') }}</h5>
                    <p class="text-secondary mb-4">{{ __('Përditëso emrin dhe adresën tuaj të email-it') }}</p>

                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit="updateProfileInformation">
                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Emri') }}</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" required autocomplete="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Email') }}</label>
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            @if ($this->hasUnverifiedEmail)
                                <div class="mt-2 text-warning fs-13">
                                    {{ __('Adresa juaj e email-it është e paverifikuar.') }}
                                    <button type="button" class="btn btn-link p-0 text-decoration-none fs-13" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Kliko këtu për të ridërguar email-in e verifikimit.') }}
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <span wire:loading wire:target="updateProfileInformation" class="spinner-border spinner-border-sm me-1"></span>
                                {{ __('Ruaj Ndryshimet') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($this->showDeleteUser)
                <div class="card bg-white border-0 rounded-3 mb-4 border-top border-danger border-3">
                    <div class="card-body p-4">
                        <h5 class="mb-2 fw-semibold text-danger">{{ __('Fshij Llogarinë') }}</h5>
                        <p class="text-secondary mb-4">{{ __('Pasi llogaria juaj të fshihet, të gjitha burimet dhe të dhënat e saj do të fshihen përgjithmonë.') }}</p>

                        <livewire:settings.delete-user-form />
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
