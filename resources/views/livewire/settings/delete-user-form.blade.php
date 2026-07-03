<div>
    <button type="button" class="btn btn-danger" wire:click="$set('confirmingUserDeletion', true)">
        {{ __('Fshij Llogarinë') }}
    </button>

    @if($confirmingUserDeletion)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-3 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('A jeni i sigurt që dëshironi të fshini llogarinë tuaj?') }}</h5>
                        <button type="button" wire:click="$set('confirmingUserDeletion', false)" class="btn-close"></button>
                    </div>
                    <form wire:submit="deleteUser">
                        <div class="modal-body">
                            <p class="text-secondary">
                                {{ __('Pasi llogaria juaj të fshihet, të gjitha burimet dhe të dhënat e saj do të fshihen përgjithmonë. Ju lutem shkruani fjalëkalimin tuaj për të konfirmuar që dëshironi të fshini përgjithmonë llogarinë tuaj.') }}
                            </p>

                            <div class="mb-3">
                                <label class="form-label fw-medium">{{ __('Fjalëkalimi') }}</label>
                                <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Fjalëkalimi') }}">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="$set('confirmingUserDeletion', false)" class="btn btn-outline-secondary">{{ __('Anulo') }}</button>
                            <button type="submit" class="btn btn-danger">
                                <span wire:loading wire:target="deleteUser" class="spinner-border spinner-border-sm me-1"></span>
                                {{ __('Fshij Llogarinë') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
