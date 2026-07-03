<div>
    @section('page-title', __('Ndrysho Fjalëkalimin'))

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">{{ __('Ndrysho Fjalëkalimin') }}</span></li>
            </ol>
        </nav>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-semibold">{{ __('Përditëso Fjalëkalimin') }}</h5>

                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit="updatePassword">
                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Fjalëkalimi Aktual') }}</label>
                            <input type="password" wire:model="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Fjalëkalimi i Ri') }}</label>
                            <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Konfirmo Fjalëkalimin e Ri') }}</label>
                            <input type="password" wire:model="password_confirmation" class="form-control">
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <span wire:loading wire:target="updatePassword" class="spinner-border spinner-border-sm me-1"></span>
                                {{ __('Ruaj Ndryshimet') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
