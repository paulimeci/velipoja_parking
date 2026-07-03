<div class="dropdown notifications language">
    <button class="btn btn-secondary dropdown-toggle border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="material-symbols-outlined">translate</span>
        <span class="ms-1 fs-12 fw-bold">{{ strtoupper($currentLocale) }}</span>
    </button>
    <div class="dropdown-menu dropdown-lg p-0 border-0 dropdown-menu-end">
        <ul class="ps-0 mb-0 list-unstyled">
            @foreach($languages as $code)
                <li>
                    <button type="button" wire:click="changeLocale('{{ $code }}')" class="dropdown-item d-flex align-items-center py-2 {{ $currentLocale == $code ? 'bg-light' : '' }} w-100 border-0 bg-transparent text-start">
                        <span class="material-symbols-outlined fs-18 me-2">language</span>
                        <span>{{ strtoupper($code) }}</span>
                        @if($currentLocale == $code)
                            <i class="ri-check-line ms-auto text-success"></i>
                        @endif
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
