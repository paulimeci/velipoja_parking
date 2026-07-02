@php
    use App\Http\Controllers\My_App\Raport_Ditor_Controller;

    $raportCalls = Raport_Ditor_Controller::Raport_Ditor_Calls_Nga_Programi();
    $raportMails = Raport_Ditor_Controller::Raport_Ditor_Mails_Nga_Programi();
    $raportSms = Raport_Ditor_Controller::Raport_Ditor_Sms_Nga_Programi();
@endphp
<form action="{{ route('store_raporte') }}" method="POST">
    @csrf
    <div class="row g-3">
        <!-- Emri i Punonjësit (Marrim nga Auth) -->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="hidden" class="form-control" id="id_punonjesit" name="id_punonjesit" value="{{ Auth::user()->id }}" readonly>
                <input type="text" class="form-control" id="emri" name="emri" value="{{ Auth::user()->name }}" readonly>
                <label for="id_punonjesit">Emri i Punonjësit</label>
            </div>
        </div>

        <!-- Data (Vendosim datën aktuale) -->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="date" class="form-control" id="data" name="data" value="{{ old('data', now()->format('Y-m-d')) }}">
                <label for="data">Data</label>
                @error('data')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Puna Kryer (Akordeon) -->
        <div class="col-12">
            <div class="accordion" id="accordionRaport">
                <!-- Puna Kryer -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPunetEKryera">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePunetEKryera" aria-expanded="true" aria-controls="collapsePunetEKryera">
                            Raport Automatizuar
                        </button>
                    </h2>
                    <div  {{ $raportCalls || $raportMails ? '' : 'hidden' }} id="collapsePunetEKryera" class="accordion-collapse collapse show" aria-labelledby="headingPunetEKryera" data-bs-parent="#accordionRaport">
                        <div class="accordion-body" style="padding: 0 !important;">
                           <textarea class="form-control" id="punet_e_kryera" name="punet_e_kryera" rows="5" style="height: 300px;">
                                            {!! old('punet_e_kryera') ?? ($raportCalls ? $raportCalls : '') !!}
                                                               {!! $raportMails ? $raportMails : '' !!}
                                                               {!! $raportSms ? $raportSms : '' !!}
                                        </textarea>
                            @error('punet_e_kryera')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Puna Kryer extra -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPunetEKryera2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePunetEKryera2" aria-expanded="false" aria-controls="collapsePunetEKryera2">
                            Puna Kryer te tjera
                        </button>
                    </h2>
                    <div id="collapsePunetEKryera2" class="accordion-collapse collapse  {{ $raportCalls || $raportMails ? '' : 'show' }}" aria-labelledby="headingPunetEKryera2" data-bs-parent="#accordionRaport">
                        <div class="accordion-body" style="padding: 0 !important;">
                           <textarea class="form-control" id="punet_e_kryera_2" name="punet_e_kryera_2" rows="5" style="height: 300px;">

                                        </textarea>
                            @error('punet_e_kryera')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <!-- Probleme të Hasura -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingProblemet">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProblemet" aria-expanded="false" aria-controls="collapseProblemet">
                            Probleme të Hasura
                        </button>
                    </h2>
                    <div id="collapseProblemet" class="accordion-collapse collapse" aria-labelledby="headingProblemet" data-bs-parent="#accordionRaport">
                        <div class="accordion-body" style="padding: 0 !important;">
                            <textarea class="form-control" id="problemet" name="problemet" rows="5" style="height: 300px;">{{ old('problemet') }}</textarea>
                            @error('problemet')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Arritje/Rezultate -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingArritjet">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseArritjet" aria-expanded="false" aria-controls="collapseArritjet">
                            Arritje/Rezultate
                        </button>
                    </h2>
                    <div id="collapseArritjet" class="accordion-collapse collapse" aria-labelledby="headingArritjet" data-bs-parent="#accordionRaport">
                        <div class="accordion-body" style="padding: 0 !important;">
                            <textarea class="form-control" id="arritjet" name="arritjet" rows="5" style="height: 300px;">{{ old('arritjet') }}</textarea>
                            @error('arritjet')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Propozime për Përmirësime -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPropozimet">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePropozimet" aria-expanded="false" aria-controls="collapsePropozimet">
                            Propozime për Përmirësime
                        </button>
                    </h2>
                    <div id="collapsePropozimet" class="accordion-collapse collapse" aria-labelledby="headingPropozimet" data-bs-parent="#accordionRaport">
                        <div class="accordion-body" style="padding: 0 !important;">
                            <textarea class="form-control" id="propozimet" name="propozimet" rows="5" style="height: 300px;">{{ old('propozimet') }}</textarea>
                            @error('propozimet')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-3">Dërgo Raportin</button>
        </div>
    </div>
</form>

<!-- Integrimi i TinyMCE (Versioni 4 pa API Key) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#punet_e_kryera',
        plugins: 'code lists textcolor colorpicker table',
        toolbar: 'undo redo | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | table | emoticons | code',
        menubar: false,
        statusbar: false,
        readonly: 1, // Kjo e bën editorin readonly
        setup: function(editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
    tinymce.init({
        selector: '#punet_e_kryera_2',
        plugins: 'code lists textcolor colorpicker table',
        toolbar: 'undo redo | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | table | emoticons | code',
        menubar: false,
        statusbar: false,
        setup: function(editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });

    tinymce.init({
        selector: '#problemet',
        plugins: 'code lists textcolor colorpicker table',
        toolbar: 'undo redo | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | table | emoticons | code',
        menubar: false,
        statusbar: false,
        setup: function(editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
    tinymce.init({
        selector: '#arritjet',
        plugins: 'code lists textcolor colorpicker table',
        toolbar: 'undo redo | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | table | emoticons | code',
        menubar: false,
        statusbar: false,
        setup: function(editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
    tinymce.init({
        selector: '#propozimet',
        plugins: 'code lists textcolor colorpicker table',
        toolbar: 'undo redo | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | table | emoticons | code',
        menubar: false,
        statusbar: false,
        setup: function(editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
</script>
