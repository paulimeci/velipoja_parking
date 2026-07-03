<div>
    @section('page-title', __('Pamja'))

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">{{ __('Cilësimet e Pamjes') }}</span></li>
            </ol>
        </nav>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-2 fw-semibold">{{ __('Pamja') }}</h5>
                    <p class="text-secondary mb-4">{{ __('Përditëso cilësimet e pamjes për llogarinë tuaj') }}</p>

                    <div class="d-flex gap-3">
                         {{--
                            Note: This part depends on how your theme handles dark/light mode.
                            The original Flux UI switcher is replaced with a simpler Bootstrap button group.
                         --}}
                        <button type="button" class="btn btn-outline-primary active">{{ __('Light') }}</button>
                        <button type="button" class="btn btn-outline-primary">{{ __('Dark') }}</button>
                        <button type="button" class="btn btn-outline-primary">{{ __('System') }}</button>
                    </div>

                    <p class="mt-3 text-muted fs-12 italic">
                        * {{ __('Cilësimet e pamjes varen nga tema e instaluar.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
