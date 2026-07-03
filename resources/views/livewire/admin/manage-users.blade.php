<div>
    @section('page-title', 'Menaxhimi i Përdoruesve')

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">{{ __('Menaxhimi i Përdoruesve') }}</span></li>
            </ol>
        </nav>
    @endsection

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <h5 class="mb-0 fw-semibold">{{ __('Përdoruesit e Sistemit') }}</h5>
                <div class="position-relative">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="{{ __('Kërko përdorues...') }}">

                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Emri') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Rolet') }}</th>
                            <th class="text-end">{{ __('Veprime') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <button wire:click="editUser({{ $user->id }})" class="btn btn-sm btn-outline-primary">
                                        <i class="material-symbols-outlined fs-18">edit</i> {{ __('Menaxho Rolet') }}
                                    </button>
                                    @can('admin.delete-users')
                                        @if($user->id !== auth()->id() && $user->email !== 'paulin.meci@gmail.com')
                                            <button wire:click="deleteUser({{ $user->id }})" wire:confirm="{{ __('A jeni i sigurt që dëshironi ta fshini këtë përdorues?') }}" class="btn btn-sm btn-outline-danger ms-2">
                                                <i class="material-symbols-outlined fs-18">delete</i> {{ __('Fshij') }}
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @if($showUserModal)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Menaxho Rolet për') }} {{ $name }}</h5>
                        <button type="button" wire:click="$set('showUserModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">{{ __('Zgjidh Rolet') }}</label>
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $role->name }}" wire:model="selectedRoles" id="role-{{ $role->id }}">
                                            <label class="form-check-label" for="role-{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="$set('showUserModal', false)" class="btn btn-outline-secondary">{{ __('Anulo') }}</button>
                        <button type="button" wire:click="saveUser" class="btn btn-primary">{{ __('Ruaj Ndryshimet') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
