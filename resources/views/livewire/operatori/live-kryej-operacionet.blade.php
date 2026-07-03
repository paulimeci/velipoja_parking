<div>
    @section('page-title', __('Kryej Operacionet'))

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fs-18 mb-0">{{ __('Regjistro Hyrjen / Operacionin') }}</h4>
                        @if (session()->has('success'))
                            <span class="badge bg-success bg-opacity-10 text-success p-2 px-3 rounded-2 fs-13">
                                <i class="ri-checkbox-circle-line align-middle me-1"></i> {{ session('success') }}
                            </span>
                        @endif
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="preview-tab-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                            <form wire:submit.prevent="ruajOperacionin">
                                <div class="row align-items-end">

                                    {{-- INPUT 1: TARGA E MAKINËS --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fw-medium mb-2">{{ __('Targa e Makinës') }} <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="targa"
                                                   class="form-control h-60 rounded-3 @error('targa') is-invalid @enderror"
                                                   placeholder="{{ __('Shkruaj targën (p.sh. AB123CD)') }}">
                                            @error('targa') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- SELECT 2: KATEGORIA E SHËRBIMIT (24h, ore, dite_nate) --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fw-medium mb-2">{{ __('Zgjidh Shërbimin') }} <span class="text-danger">*</span></label>
                                            <div class="form-group position-relative">
                                                <select wire:model="id_kategoria" class="form-select form-control h-60 rounded-3 @error('id_kategoria') is-invalid @enderror">
                                                    <option value="" class="text-dark">-- {{ __('Zgjidh Shërbimin') }} --</option>
                                                    @foreach($kategorite as $kategoria)
                                                        <option value="{{ $kategoria->id }}" class="text-dark">{{ $kategoria->kategoria }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_kategoria') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SELECT 3: PERZGJEDHJA E MONEDHËS (Default: LEK/ALL) --}}
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fw-medium mb-2">{{ __('Monedha e Pagesës') }} <span class="text-danger">*</span></label>
                                            <div class="form-group position-relative">
                                                <select wire:model="id_monedha" class="form-select form-control h-60 rounded-3 @error('id_monedha') is-invalid @enderror">
                                                    <option value="" class="text-dark">-- {{ __('Zgjidh Monedhën') }} --</option>
                                                    @foreach($monedhat as $monedha)
                                                        <option value="{{ $monedha->id }}" class="text-dark">{{ $monedha->emri }} ({{ $monedha->kodi }})</option>
                                                    @endforeach
                                                </select>
                                                @error('id_monedha') <div class="invalid-feedback mt-1">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BUTONI PËR KRYERJEN E OPERACIONIT --}}
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary py-3 px-5 fs-14 fw-semibold rounded-3 shadow-sm">
                                            <span wire:loading wire:target="ruajOperacionin" class="spinner-border spinner-border-sm me-2"></span>
                                            <i class="ri-save-line me-1"></i> {{ __('Regjistro Operacionin') }}
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
