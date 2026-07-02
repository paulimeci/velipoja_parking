@extends('my_app.backend.master')

@section('main-content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card equal-card">
                    <div class="card-header">
                        <h5>Default Modal</h5>
                        <p class="mb-0 text-secondary">if you want to keep the default modal then you can keep it using <span class="text-danger">modal-dialog</span></p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Default Modal
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1"
                 aria-hidden="true">
                <div class="modal-dialog app_modal_sm">
                    <div class="modal-content">
                        <div class="modal-header bg-primary-800">
                            <h1 class="modal-title fs-5 text-white" id="exampleModal2">Small Modal</h1>
                            <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="d-flex gap-2">
                                <img src="{{asset('../assets/images/modals/06.jpg')}}" alt=""
                                     class="rounded-pill object-fit-cover h-90 w-90 b-r-10">
                                <div class="text-start d-flex flex-column gap-2">
                                    <h5>Content marketing</h5>
                                    <p class="m-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </div>
                            </div>

                            <!-- <h5 class="mb-0 mt-3">Good Morning!</h5> -->
                            <!-- <p>Hi, Aaron Gish ! Congratulations.</p> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-light-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card currency-card">
                    <div class="card-body">
                        <h1>Shto Kategori</h1>

                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="id_kompania">ID Kompania</label>
                                <input type="number" name="id_kompania" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="img_logo">Logo</label>
                                <input type="file" name="img_logo" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="active">Aktiv</label>
                                <input type="checkbox" name="active" value="1" checked>
                            </div>



                            <button type="submit" class="btn btn-success">Ruaj</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card currency-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="position-relative">
                                <div
                                    class="h-40 w-40 d-flex-center b-r-8 overflow-hidden bg-light-secondary p-1 currency-icon">
                                    <i class="ph-fill  ph-diamonds-four"></i>
                                </div>
                                <div class="ms-5">
                                    <h6 class="header-title-text mb-0">Litecoin</h6>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-secondary">45.900LTC</h5>
                            </div>
                        </div>
                        <div class="currency-chart-box">
                            <div>
                                <div id="LiteCoin" class="currency-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')


    <!-- data table-->
    <script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

    <!-- apexcharts js-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Crypto js-->
    <script src="{{asset('assets/js/crypto_dashboard.js')}}"></script>
    <script src="{{asset('assets/js/crypto_dashboard_chart.js')}}"></script>

@endsection
