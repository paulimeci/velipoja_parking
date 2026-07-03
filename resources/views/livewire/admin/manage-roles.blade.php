<div>
    @section('page-title', 'Rolet & Permissionet')

    @section('breadcrumb')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                        <span class="text-secondary fw-medium">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span class="fw-medium">Rolet & Permissionet</span></li>
            </ol>
        </nav>
    @endsection

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-semibold">Menaxhimi i Roleve</h5>
                <button wire:click="$set('showCreateModal', true)" class="btn btn-primary">
                    <i class="ri-add-line"></i> Shto Rol të Ri
                </button>
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
                            <th>Emri i Rolit</th>
                            <th>Permissionet</th>
                            <th class="text-end">Veprime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="fw-bold text-primary">{{ strtoupper($role->name) }}</td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $role->permissions->count() }} Permissione
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button wire:click="editRole({{ $role->id }})" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="material-symbols-outlined fs-18">security</i> Konfiguro
                                    </button>
                                    @if($role->name !== 'admin')
                                        <button wire:confirm="A jeni i sigurt që dëshironi ta fshini këtë rol?" wire:click="deleteRole({{ $role->id }})" class="btn btn-sm btn-outline-danger">
                                            <i class="material-symbols-outlined fs-18">delete</i> Fshij
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($showCreateModal)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">Shto Rol të Ri</h5>
                        <button type="button" wire:click="$set('showCreateModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Emri i Rolit</label>
                            <input type="text" wire:model="newRoleName" class="form-control @error('newRoleName') is-invalid @enderror" placeholder="p.sh. operator">
                            @error('newRoleName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="$set('showCreateModal', false)" class="btn btn-outline-secondary">Anulo</button>
                        <button type="button" wire:click="createRole" class="btn btn-primary">Krijo Rolin</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showRoleModal)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfiguro Permissionet për Rolin: {{ strtoupper($roleName) }}</h5>
                        <button type="button" wire:click="$set('showRoleModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($permissionsByModule as $module => $permissions)
                            <div class="mb-4">
                                <h6 class="fw-bold border-bottom pb-2 mb-3 text-secondary">{{ $module ?: 'Të tjera' }}</h6>
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $permission->name }}" wire:model="selectedPermissions" id="perm-{{ $permission->id }}">
                                                <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                    <span class="d-block fw-medium">{{ $permission->label ?: $permission->name }}</span>
                                                    <small class="text-muted">{{ $permission->name }}</small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="$set('showRoleModal', false)" class="btn btn-outline-secondary">Anulo</button>
                        <button type="button" wire:click="saveRolePermissions" class="btn btn-primary">Ruaj Ndryshimet</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
