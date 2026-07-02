@extends('my_app.backend.master')
@section('title', 'Visits')
@section('css')

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">

@endsection
@section('main-content')

    <div class="container-fluid">
        <div class="row">
            @if (request()->filled('kompania'))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Logimet ne sistem.</h5>
                        </div>
                        <div class="card-body ps-0 pe-0">
                            <div class="table-responsive app-scroll app-datatable-default project-table">
                                <table id="projectTable" class="display table-bottom-border app-data-table table-box-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="check-box">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmark outline-secondary ms-2"></span>
                                            </label>
                                        </th>
                                        <th>User</th>
                                        <th>IP Address</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Platform</th>
                                        <th>Operating System</th>
                                        <th>Browser</th>
                                        <th>Number of Visits</th>
                                        <th>Visit Dates</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($groupedLogins as $visit)
                                        <tr>
                                            <td>
                                                <label class="check-box">
                                                    <input type="checkbox">
                                                    <span class="checkmark outline-secondary ms-2"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div>
                                                        <h6 class="f-s-15 mb-0">{{ $visit->UserDatti->name }}</h6> {{--Emails, Calls, sms--}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div>
                                                        <h6 class="f-s-15 mb-0">{{ $visit->ip_address }}</h6>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-dark f-w-500">{{ $visit->country }}</td>

                                            <td>
                                                {{ $visit->city  }}
                                            </td>
                                            <td>
                                                {{ $visit->device }}
                                            </td>
                                            <td>
                                                {{ $visit->platform }}
                                            </td>

                                            <td>
                                                {{ $visit->browser }}
                                            </td>
                                            <td>
                                            <span class="badge bg-warning">
                                                {{ $visit->num_views }}
                                            </span>
                                            </td>

                                            <td>
                                                {{ $visit->dates }}
                                            </td>


                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-body d-flex justify-content-between align-items-center bg-light rounded-top">
                            <h5 class="card-title mb-0 text-dark">
                                <i class="ti ti-briefcase me-2"></i> Kompanitë
                            </h5>
                        </div>
                    </div>
                </div>
                @forelse($Kompanite AS $Co)
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-lg hover-card">
                            <div class="card-body text-center p-4">
                                <form action="" method="GET">
                                    <input type="hidden" name="kompania" value="{{ $Co->id }}">
                                    <div class="company-logo mb-3">
                                        <img src="{{ asset($Co->logo) }}" loading="lazy" class="img-fluid rounded-circle" alt="{{ $Co->emri }}">
                                    </div>
                                    <h5 class="text-primary fw-bold mt-2">
                                        <i class="ti ti-building me-2"></i>{{ $Co->emri }}
                                    </h5>
                                    <p class="text-muted mt-1 mb-3">
                                        <i class="ti ti-barcode me-2"></i>{{ $Co->nuis }}
                                    </p>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-arrow-right-circle me-2"></i> Vazhdo këtu
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-lg text-center hover-card">
                            <div class="card-header bg-danger text-white rounded-top">
                                <h5 class="mb-0">
                                    <i class="ti ti-alert-circle me-2"></i> Nuk ka kompani
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted">Aktualisht nuk keni regjistruar asnjë kompani.</p>
                                <a href="{{ route('view_kompanite') }}" class="btn btn-outline-danger w-100">
                                    <i class="ti ti-plus-circle"></i> Shto këtu
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            @endif
        </div>
    </div>

@endsection
@section('script')
    <!--customizer-->
    <div id="customizer"></div>

    <!--js-->
    <script src="{{ asset('assets/js/advance_table.js') }}"></script>
@endsection


