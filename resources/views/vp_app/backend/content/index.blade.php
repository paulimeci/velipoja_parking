@extends('my_app.backend.master')
@section('title', 'Ecommerce Dashboard')
@section('css')

    <!-- apexcharts css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">

    <!-- glight css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/glightbox/glightbox.min.css')}}">

    <!-- Data Table css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">

    <!-- vector map css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/vector-map/jquery-jvectormap.css')}}">

@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-xxl-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card eshop-cards">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-primary h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-map-pin-line"></i>
                          </span>
                                    <div class="dropdown">
                                        <a href="#" class="text-primary" role="button" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            Last Month<i class="ti ti-chevron-down ms-1"></i>
                                        </a>
                                        <ul class="dropdown-menu  dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Last Month</a></li>
                                            <li><a class="dropdown-item" href="#">Last Week</a></li>
                                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-shrink-0 align-self-end">
                                        <p class="f-s-16 mb-0">Visits</p>
                                        <h5>25,220k <span class="f-s-12 text-danger">-45%</span></h5>
                                    </div>
                                    <div class="visits-chart">
                                        <div id="visitsChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card eshop-cards">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-secondary h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-shopping-cart"></i>
                          </span>
                                    <div class="dropdown">
                                        <a href="#" class="text-secondary " role="button" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            Weekly<i class="ti ti-chevron-down ms-1"></i>
                                        </a>
                                        <ul class="dropdown-menu  dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                                            <li><a class="dropdown-item" href="#">Yearly</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center position-relative">
                                    <div class="flex-shrink-0 align-self-end">
                                        <p class="f-s-16 mb-0">Order</p>
                                        <h5>45,782k <span class="f-s-12 text-success">+65%</span></h5>
                                    </div>
                                    <div class="order-chart">
                                        <div id="orderChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card eshop-cards">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-success h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-pulse"></i>
                          </span>
                                    <div class="dropdown">
                                        <a href="#" class="text-success " role="button" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            Today<i class="ti ti-chevron-down ms-1"></i>
                                        </a>
                                        <ul class="dropdown-menu  dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Today</a></li>
                                            <li><a class="dropdown-item" href="#">Tomorrow</a></li>
                                            <li><a class="dropdown-item" href="#">Last Week</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-shrink-0 align-self-end">
                                        <p class="f-s-16 mb-0">Activity</p>
                                        <h5>45k</h5>
                                    </div>
                                    <div class="activity-chart">
                                        <div id="activityChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card eshop-cards">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-warning h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-fill  ph-coins"></i>
                          </span>
                                    <div class="dropdown">
                                        <a href="#" class="text-warning " role="button" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            February<i class="ti ti-chevron-down ms-1"></i>
                                        </a>
                                        <ul class="dropdown-menu  dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">January</a></li>
                                            <li><a class="dropdown-item" href="#">February</a></li>
                                            <li><a class="dropdown-item" href="#">March</a></li>
                                            <li><a class="dropdown-item" href="#">April</a></li>
                                            <li><a class="dropdown-item" href="#">...</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-shrink-0 align-self-end">
                                        <p class="f-s-16 mb-0">Sales</p>
                                        <h5>$63,987<span class="f-s-12 text-success">+68%</span></h5>
                                    </div>
                                    <div class="sales-chart">
                                        <div id="salesChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 col-xxl-4">
                <div class="card active-user-card">
                    <div class="card-body">
                        <div class="">
                            <h5 class="text-dark">Active Users</h5>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <div class="active-user-content">
                                <h2 class="text-primary mb-0">50k</h2>
                                <p class="text-secondary text-nowrap mb-0">Page Views per Minutes</p>
                                <div class="app-divider-v dashed py-3"></div>
                                <p class="f-w-500">Today Users</p>
                                <div>
                                    <ul class="avatar-group justify-content-start">
                                        <li class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-primary b-2-light"
                                            data-bs-toggle="tooltip" data-bs-title="Sabrina Torres">
                                            <img src="{{asset('assets/images/avtar/4.png')}}" loading="lazy" alt="" class="img-fluid">
                                        </li>
                                        <li class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-success b-2-light"
                                            data-bs-toggle="tooltip" data-bs-title="Eva Bailey">
                                            <img src="{{asset('assets/images/avtar/5.png')}}" loading="lazy" alt="" class="img-fluid">
                                        </li>
                                        <li class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-danger b-2-light"
                                            data-bs-toggle="tooltip" data-bs-title="Michael Hughes">
                                            <img src="{{asset('assets/images/avtar/6.png')}}" loading="lazy" alt="" class="img-fluid">
                                        </li>
                                        <li class="text-bg-secondary h-25 w-25 d-flex-center b-r-50" data-bs-toggle="tooltip"
                                            data-bs-title="10 More">
                                            10+
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card card-primary flex-grow-1 user-chart-card">
                                <div class="card-body">
                                    <div class="active-users-chart">
                                        <div id="userChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="active-users-content mt-3">
                            <div>
                                <h6 class="mb-0">4.78%</h6>
                                <p class="text-secondary mb-0">Monthly</p>
                            </div>
                            <div>
                                <h6 class="mb-0">82.90%</h6>
                                <p class="text-secondary mb-0">Weekly</p>
                            </div>
                            <div>
                                <h6 class="mb-0">80.0%</h6>
                                <p class="text-secondary mb-0">Yearly</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-2 d-none d-xxl-block">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="header-title-text mb-0">Product Sold </h6>
                            <span><i class="ph-bold  ph-trend-down text-danger"></i></span>
                        </div>
                        <div>
                            <div id="productSold"></div>
                            <div>
                                <a href="#" target="_blank" role="button" class="btn btn-success w-100">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xxl-4">
                <div class="card contries-details-card">
                    <div class="card-body">
                        <div>
                            <div class="w-100 h-250" id="userContries"></div>
                            <a href="#" role="button" class="btn btn-primary b-r-10">Details</a>
                        </div>
                        <div class="d-flex justify-content-between gap-3">
                            <ul class="contries-details-list">

                                <li>
                                    <div class="position-relative">
                            <span class="position-absolute">
                              <i class="flag-icon flag-icon-usa flag-icon-squared b-r-5 f-s-24"></i>
                            </span>
                                        <p class="f-w-500 mg-s-30 mb-0">US</p>
                                    </div>
                                    <div>
                                        <h6 class="text-success mb-0"><i class="ph-bold  ph-trend-down"></i>40%</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="position-relative">
                            <span class="position-absolute">
                              <i class="flag-icon flag-icon-fra flag-icon-squared b-r-5 f-s-24"></i>
                            </span>
                                        <p class="f-w-500 mg-s-30 mb-0">France</p>
                                    </div>
                                    <div>
                                        <h6 class="text-success mb-0"><i class="ph-bold  ph-trend-up"></i>60%</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="position-relative">
                            <span class="position-absolute">
                              <i class="flag-icon flag-icon-ita flag-icon-squared b-r-5 f-s-24"></i>
                            </span>
                                        <p class="f-w-500 mg-s-30 mb-0">Italy</p>
                                    </div>
                                    <div>
                                        <h6 class="text-danger mb-0"><i class="ph-bold  ph-trend-down"></i>57%</h6>
                                    </div>
                                </li>
                            </ul>

                            <div class="app-divider-h dotted h-auto m-0"></div>

                            <ul class="contries-details-list">
                                <li>
                                    <div class="position-relative">
                            <span class="position-absolute">
                              <i class="flag-icon flag-icon-aus flag-icon-squared b-r-5 f-s-24"></i>
                            </span>
                                        <p class="f-w-500 mg-s-30 mb-0">Australia</p>
                                    </div>
                                    <div>
                                        <h6 class="text-success mb-0"><i class="ph-bold  ph-trend-up"></i>24%</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="position-relative">
                            <span class="position-absolute">
                              <i class="flag-icon flag-icon-deu flag-icon-squared b-r-5 f-s-24"></i>
                            </span>
                                        <p class="f-w-500 mg-s-30 mb-0">Germany</p>
                                    </div>
                                    <div>
                                        <h6 class="text-success mb-0"><i class="ph-bold  ph-trend-up"></i>86%</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="position-relative">
                            <span class="position-absolute">
                              <i class="flag-icon flag-icon-eng flag-icon-squared b-r-5 f-s-24"></i>
                            </span>
                                        <p class="f-w-500 mg-s-30 mb-0">England</p>
                                    </div>
                                    <div>
                                        <h6 class="text-danger mb-0"><i class="ph-bold  ph-trend-down"></i>12%</h6>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xxl-4">
                <div class="card equal-card top-product-card">
                    <div class="card-header card-header-title">
                        <div class="d-flex">
                            <div>
                                <h5>Top Products</h5>
                                <p class="text-secondary mb-0">Latest Report</p>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive app-scroll">
                            <table class="table align-middle top-products-table mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Voucher</th>
                                    <th scope="col">Sold</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class=" position-absolute">
                                                <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/wristwatch.png')}}" loading="lazy" alt=""
                                                     class=" w-35">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">I Smartwatch</h6>
                                                <p class="mb-0">50 product</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@RA0911</td>
                                    <td>60%</td>
                                    <td>$340.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="position-absolute">
                                                <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/shoes.png')}}" loading="lazy" alt=""
                                                     class=" w-35">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Shoes</h6>
                                                <p class="mb-0">200 product</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@RA6547</td>
                                    <td>50%</td>
                                    <td>$450.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class=" position-absolute">
                                                <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/earphone.png')}}" loading="lazy" alt=""
                                                     class=" w-35">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Airpods Pro</h6>
                                                <p class="mb-0">20 product</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@RA5672</td>
                                    <td>87%</td>
                                    <td>$500.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class=" position-absolute">
                                                <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/backpack.png')}}" alt=""
                                                     class=" w-35">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Bag</h6>
                                                <p class="mb-0">180 product</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@RA0546</td>
                                    <td>68%</td>
                                    <td>$480.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class=" position-absolute">
                                                <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/plant.png')}}" alt=""
                                                     class=" w-35">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Tree Pot</h6>
                                                <p class="mb-0">80 product</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@RA340</td>
                                    <td>52%</td>
                                    <td>$579.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 col-xxl-4 order-1-lg">
                <div class="card equal-card order-timeline-card">
                    <div class="card-header">
                        <h5>Order History</h5>
                    </div>
                    <div class="card-body app-scroll">
                        <ul class="app-timeline-box order-timeline">
                            <li class="timeline-section">
                                <div class="timeline-icon">
                          <span class="bg-primary h-35 w-35 d-flex-center b-r-50">
                            <i class="ph-duotone  ph-basket f-s-18"></i>
                          </span>
                                </div>
                                <div class="timeline-content ">
                                    <div class="order-timeline-box">
                                        <div class="position-relative">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary f-w-600 mb-0">Order</h6>
                                                <p class="f-s-12 mb-0 text-danger ">Nov 16</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 order-timeline-content">
                                            <p class="mb-0">Purchase 2 Items <span>$489.00</span></p>
                                            <p class="mb-0">Order Id <span>📦#R98056745</span></p>
                                            <p>Ships to <span>Devied Smith</span></p>
                                            <div class="">
                                                <a href="#" class="link-danger text-d-underline">More Details<i class="ph ph-arrow-right ps-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-section">
                                <div class="timeline-icon">
                          <span class="bg-warning h-35 w-35 d-flex-center b-r-50">
                            <i class="ph-duotone  ph-gear f-s-18"></i>
                          </span>
                                </div>
                                <div class="timeline-content ">
                                    <div class="order-timeline-box">
                                        <div class="position-relative">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-warning f-w-600 mb-0">Processing</h6>
                                                <p class="f-s-12 mb-0 text-danger ">Est. Nov 18</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 order-timeline-content">
                                            <p class="mb-0">Order Processing at Its Finest 📝</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-section">
                                <div class="timeline-icon">
                          <span class="bg-success h-35 w-35 d-flex-center b-r-50">
                            <i class="ph-duotone  ph-truck f-s-18"></i>
                          </span>
                                </div>
                                <div class="timeline-content">
                                    <div class="order-timeline-box">
                                        <div class="position-relative">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-success f-w-600 mb-0">Shipped</h6>
                                                <p class="f-s-12 mb-0 text-danger">Est. Nov 18</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 order-timeline-content">
                                            <p class="mb-0">Your order has set sail 🚚</p>
                                        </div>
                                    </div>

                                </div>
                            </li>
                            <li class="timeline-section">
                                <div class="timeline-icon">
                          <span class="bg-secondary h-35 w-35 d-flex-center b-r-50">
                            <i class="ph-duotone  ph-seal-check f-s-18"></i>
                          </span>
                                </div>
                                <div class="timeline-content">
                                    <div class="order-timeline-box">
                                        <div class="position-relative">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="f-w-600 mb-0">Delivered</h6>
                                                <p class="f-s-12 mb-0 text-secondary">Est. Nov 20</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 order-timeline-content">
                                            <p class="mb-0">📦 Your Order delivered</p>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-xxl-5">
                <div class="card">

                    <div class="card-body">
                        <div class="">
                            <h5 class="header-title-text">Revenue Reports</h5>
                            <p class="f-s-16 text-secondary mb-0">Latest 2H Update</p>
                        </div>
                        <div class="d-flex gap-3 align-items-center justify-content-end">
                            <div>
                                <h5 class="mb-0 text-primary f-w-600">$45,890.00</h5>
                                <p class="f-s-16 text-secondary mb-0">Profit</p>
                            </div>
                            <div>
                                <h5 class="mb-0 text-success f-w-600">$3,890.00</h5>
                                <p class="f-s-16 text-secondary mb-0">Expense</p>
                            </div>
                        </div>
                        <div class="revenue-overview-chart">
                            <div id="overviewChart"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-6 col-lg-4 col-xxl-4 order-3-lg">
                <div class="card customers-review-box">
                    <div class="card-body">
                        <div class="card-header-title">
                            <h5 class="header-title-text">Customers Review</h5>
                        </div>
                        <div>
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <div class="rating ">
                                    <input type="radio" id="star11" name="ratings2" value="11" checked="" disabled="">
                                    <label class="star" for="star11"><span
                                            class="ti ti-star-filled f-s-16 text-warning"></span></label>
                                    <input type="radio" id="star15" name="ratings2" value="15" checked="" disabled="">
                                    <label class="star" for="star15"><span
                                            class="ti ti-star-filled f-s-16 text-warning"></span></label>
                                    <input type="radio" id="star12" name="ratings2" value="12" disabled="">
                                    <label class="star" for="star12"><span
                                            class="ti ti-star-half-filled text-warning f-s-16"></span></label>
                                    <input type="radio" id="star13" name="ratings2" value="13" disabled="">
                                    <label class="star" for="star13"><span class="ti ti-star f-s-16"></span></label>
                                    <input type="radio" id="star14" name="ratings2" value="14" disabled="">
                                    <label class="star" for="star14"><span class="ti ti-star f-s-16"></span></label>
                                </div>
                                <div>
                                    <p class="f-s-16 mb-0 text-warning">(<span class="f-w-600">4.50k</span> Review )</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0">5 </h5>
                                    <i class="ti ti-star-filled text-warning f-s-9"></i>
                                    <div class="progress w-100 ms-2 me-2" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar bg-primary progress-bar-striped" style="width: 74%"></div>
                                    </div>
                                    <h6>(4,567)</h6>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <h5 class="mb-0">4 </h5>
                                    <i class="ti ti-star-filled text-warning f-s-9"></i>
                                    <div class="progress w-100 ms-2 me-2" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar bg-secondary progress-bar-striped" style="width: 65%"> </div>
                                    </div>
                                    <h6>(2,765)</h6>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <h5 class="mb-0">3 </h5>
                                    <i class="ti ti-star-filled text-warning f-s-9"></i>
                                    <div class="progress w-100 ms-2 me-2" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar bg-success progress-bar-striped" style="width: 40%"></div>
                                    </div>
                                    <h6>(1,682)</h6>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <h5 class="mb-0">2 </h5>
                                    <i class="ti ti-star-filled text-warning f-s-9"></i>
                                    <div class="progress w-100 ms-2 me-2" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: 25%"> </div>
                                    </div>
                                    <h6>(2,380)</h6>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <h5 class="mb-0">5 </h5>
                                    <i class="ti ti-star-filled text-warning f-s-9"></i>
                                    <div class="progress w-100 ms-2 me-2" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar bg-danger progress-bar-striped" style="width: 10%"></div>
                                    </div>
                                    <h6>(1,9211)</h6>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <p class="text-dark f-w-500">✨Discover what our customers have to say!</p>
                                <a href="#" class="text-primary text-d-underline">see all Customers Review</a>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-facebook icon-btn b-r-22 me-1"><i
                                            class="ti ti-brand-facebook text-white"></i></button>
                                    <button type="button" class="btn btn-twitter icon-btn b-r-22 me-1"><i
                                            class="ti ti-brand-twitter text-white"></i></button>
                                    <button type="button" class="btn btn-pinterest icon-btn b-r-22 me-1"><i
                                            class="ti ti-brand-pinterest text-white"></i></button>
                                    <button type="button" class="btn btn-linkedin icon-btn b-r-22"><i
                                            class="ti ti-brand-linkedin text-white"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-5 col-xxl-3 mb-3 mb-sm-0">
                <div class="offer-slider ">
                    <div class="card offer-slider-box offeer-warning-card equal-card">
                        <div class="card-body">
                            <div>
                                <h3 class="mb-0">Get 10% off</h3>
                                <p class="my-2"> Visa card EMI Transactions, <br> up to $800 on orders of $1500 </p>
                            </div>
                            <div class="my-2">
                                <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/vector-1.png')}}" class="img-fluid" alt="">
                            </div>
                            <div class="mt-4">
                                <a href="#" target="_blank" role="button" class="btn btn-warning b-r-10 text-white"><i
                                        class="ph-bold  ph-arrow-circle-up-right me-1 "></i>Check Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="card offer-slider-box offeer-success-card equal-card">
                        <div class="card-body">
                            <div>
                                <h3 class="mb-0">Get extra 20% off</h3>
                                <p class="my-2">Additional INR 250 Discount <br> on OneCard Credit Card 9 month </p>
                            </div>
                            <div class="my-2">
                                <img src="{{('assets/images/dashboard/ecommerce-dashboard/vector-2.png')}}" class="img-fluid" alt="">
                            </div>
                            <div class="mt-4">
                                <a href="#" target="_blank" role="button" class="btn btn-success b-r-10"><i
                                        class="ph-bold  ph-arrow-circle-up-right me-1"></i>Check Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-xxl-6">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title-text">Payment</h5>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <form class="app-form" id="payment-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Balance</label>
                                                        <input type="text" class="form-control " id="card-balance" placeholder="$1,900.00"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">Card Number</label>
                                                        <input type="text" class="form-control credit-form-control"
                                                               placeholder="xxxx xxxx xxxx xxxx" id="card-number" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Expiration</label>
                                                        <input type="text" class="form-control expirationform-control" placeholder="MM/YY"
                                                               id="expiration" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <div class="card payment-details-card">
                                            <div class="card-body ">
                                                <div class="payment-details-content">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{asset('assets/images/icons/master-icon.png')}}" alt="">
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mt-3">
                                                            <p class="text-light f-w-500 mb-0">Current Balance</p>
                                                            <h4 class="text-white f-w-600" id="display-balance">$8,625.00</h4>
                                                        </div>
                                                    </div>


                                                    <div class="d-flex align-items-center justify-content-between mt-5">
                                                        <div>
                                                            <!-- <p class="text-dark f-w-500 f-s-13 mb-0">Card Holder Name</p> -->
                                                            <h6 class="text-light f-w-500 mb-0" id="display-card-number">**** **** **** 7894
                                                            </h6>
                                                        </div>
                                                        <div>
                                                            <!-- <p class="text-dark f-w-500 f-s-13 mb-0">Expiry data</p> -->
                                                            <p class="badge text-bg-secondary f-w-500 mb-0" id="display-expiration">07/24</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card customer-comment-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div
                                        class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-secondary position-absolute">
                                        <img src="{{asset('assets/images/avtar/16.png')}}" alt="" class="img-fluid">
                                    </div>
                                    <span class="fs-6 f-w-500 text-dark ms-5"> Sophia</span>
                                    <div>
                                        <i class="ph ph-star fs-5 star-icon text-warning"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted mb-0">
                                        "This Top is not only stylish but also incredibly warm. Perfect for those chilly days. <a
                                            class="text-primary text-d-underline" href="#">Read More</a>
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{asset('assets/images/ecommerce/01.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                            <img src="{{asset('assets/images/ecommerce/01.jpg')}}" class="w-45 b-r-5" alt="product-img">
                                        </a>
                                        <a href="{{asset('assets/images/ecommerce/02.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                            <img src="{{asset('assets/images/ecommerce/02.jpg')}}" class="w-45 b-r-5" alt="product-img">
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card customer-comment-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-dark position-absolute">
                                        <img src="{{asset('assets/images/avtar/14.png')}}" alt="" class="img-fluid">
                                    </div>
                                    <span class="fs-6 f-w-500 text-dark ms-5"> Isabella</span>
                                    <div>
                                        <i class="ph ph-star star-icon text-warning fs-5"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted mb-0">
                                        Trendy crop top paired with strappy sandals and a matching crossbody bag
                                        <a class="text-primary text-d-underline" href="#">Read More</a>
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{asset('assets/images/ecommerce/16.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                            <img src="{{asset('assets/images/ecommerce/16.jpg')}}" class="w-45 b-r-5" alt="product-img">
                                        </a>
                                        <a href="{{asset('assets/images/ecommerce/15.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                            <img src="{{asset('assets/images/ecommerce/15.jpg')}}" class="w-45 b-r-5" alt="product-img">
                                        </a>
                                        <a href="{{asset('assets/images/ecommerce/11.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                            <img src="{{asset('assets/images/ecommerce/11.jpg')}}" class="w-45 b-r-5" alt="product-img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-xxl-6 order-2-lg">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="card-header-title">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5>Recent Orders</h5>
                                    <p class="text-secondary mb-0">Last 1H Report</p>
                                </div>

                                <div>
                                    <i class="ph-bold  ph-faders-horizontal f-s-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="recent-order-table">
                            <ul class="nav nav-tabs app-tabs-primary pb-0 mb-3" id="Basic" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tshirt-tab" data-bs-toggle="tab"
                                            data-bs-target="#tshirt-tab-pane" type="button" role="tab" aria-controls="tshirt-tab-pane"
                                            aria-selected="true">
                                        <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/tshirt.png')}}" alt="" class="w-35">
                                        <span> T-shirt</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="watch-tab" data-bs-toggle="tab" data-bs-target="#watch-tab-pane"
                                            type="button" role="tab" aria-controls="watch-tab-pane" aria-selected="false" tabindex="-1">
                                        <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/wristwatch.png')}}" alt=""
                                             class="w-35">
                                        <span>Watch</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="bag-tab" data-bs-toggle="tab" data-bs-target="#bag-tab-pane"
                                            type="button" role="tab" aria-controls="bag-tab-pane" aria-selected="false" tabindex="-1">
                                        <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/backpack.png')}}" alt="" class="w-35">
                                        <span>Bags</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="shoes-tab" data-bs-toggle="tab" data-bs-target="#shoes-tab-pane"
                                            type="button" role="tab" aria-controls="shoes-tab-pane" aria-selected="false" tabindex="-1">
                                        <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/shoes.png')}}" alt="" class="w-35">
                                        <span>Shoes</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sunglasse-tab" data-bs-toggle="tab"
                                            data-bs-target="#sunglasse-tab-pane" type="button" role="tab"
                                            aria-controls="sunglasse-tab-pane" aria-selected="false" tabindex="-1">
                                        <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/women-hat.png')}}" alt="" class="w-35">
                                        <span>sunglasses</span>
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tshirt-tab-pane" role="tabpanel"
                                     aria-labelledby="tshirt-tab" tabindex="0">
                                    <div class="table-responsive app-scroll app-datatable-default">
                                        <table id="recentOrders" class="display recent-order-datatable">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>#67189</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden bg-light-light p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/06.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="f-s-16 mb-0">Men's T-shirt</h6>
                                                            <p class="f-s-14 text-secondary mb-0">50 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*450</td>
                                                <td><span class="badge text-light-success">DELIVERED</span></td>
                                                <td>Jul 06, 2024</td>
                                            </tr>
                                            <tr>
                                                <td>#62783</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden bg-light-light p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/07.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="f-s-16 mb-0">Loose-Fit T-shirt</h6>
                                                            <p class="f-s-14 text-secondary mb-0">25 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>2*120</td>
                                                <td><span class="badge text-light-danger">CANCELLED</span></td>
                                                <td>Mar 27, 2025</td>
                                            </tr>
                                            <tr>
                                                <td>#98356</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden bg-light-light p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/08.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="f-s-16 mb-0">Men Slim Fit T-shirt</h6>
                                                            <p class="f-s-14 text-secondary mb-0">80 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>3*654</td>
                                                <td><span class="badge text-light-primary">PICKUPS</span></td>
                                                <td>May 22, 2024</td>
                                            </tr>
                                            <tr>
                                                <td>#56743</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden bg-light-light p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/09.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="f-s-16 mb-0">Men Oversize Fit T-shirts</h6>
                                                            <p class="f-s-14 text-secondary mb-0">25 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*800</td>
                                                <td><span class="badge text-light-success">DELIVERED</span></td>
                                                <td>Dec 12, 2024</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="watch-tab-pane" role="tabpanel" aria-labelledby="watch-tab"
                                     tabindex="0">
                                    <div class="table-responsive app-scroll app-datatable-default">
                                        <table id="recentOrders1" class="display ">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>#45963</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden  p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/12.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Timex</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">10 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*800</td>
                                                <td><span class="badge text-light-dark">RETURNS</span></td>
                                                <td>Jul 28, 2024</td>
                                            </tr>
                                            <tr>
                                                <td>#85671</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden  p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/10.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">French Connection</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">26 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>2*657</td>
                                                <td><span class="badge text-light-success">DELIVERED</span></td>
                                                <td>Feb 19, 2025</td>
                                            </tr>
                                            <tr>
                                                <td>#89436</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden  p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/11.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Sonata</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">08 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>2*950</td>
                                                <td><span class="badge text-light-danger">CANCELLED</span></td>
                                                <td>Sep 24, 2024</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bag-tab-pane" role="tabpanel" aria-labelledby="bag-tab"
                                     tabindex="0">
                                    <div class="table-responsive app-scroll app-datatable-default">
                                        <table id="recentOrders2" class="display ">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>#56741</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div class="h-40 w-40 d-flex-center b-r-15 overflow-hidden p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/13.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Black Skybags</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">50 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>4*800</td>
                                                <td><span class="badge text-light-primary">PICKUPS</span></td>
                                                <td>Feb 04, 2025</td>
                                            </tr>
                                            <tr>
                                                <td>#68439</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div class="h-40 w-40 d-flex-center b-r-15 overflow-hidden p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/14.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Purce</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">15 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*900</td>
                                                <td><span class="badge text-light-success">DELIVERED</span></td>
                                                <td>Dec 17, 2024</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="shoes-tab-pane" role="tabpanel" aria-labelledby="shoes-tab"
                                     tabindex="0">
                                    <div class="table-responsive app-scroll app-datatable-default">
                                        <table id="recentOrders3" class="display ">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>#56984</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden  p-1 position-absolute">
                                                            <img src="{{asset('assets/images/dashboard/ecommerce-dashboard/15.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Men Sneakers</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">35 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*860</td>
                                                <td><span class="badge text-light-primary">PICKUPS</span></td>
                                                <td>Feb 13, 2025</td>
                                            </tr>
                                            <tr>
                                                <td>#84967</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden  p-1 position-absolute">
                                                            <img src="{{asset('../assets/images/dashboard/ecommerce-dashboard/16.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Girls Sneakers</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">20 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>2*967</td>
                                                <td><span class="badge text-light-danger">DELIVERED</span></td>
                                                <td>Aug 12, 2024</td>
                                            </tr>
                                            <tr>
                                                <td>#97651</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden  p-1 position-absolute">
                                                            <img src="{{asset('../assets/images/dashboard/ecommerce-dashboard/17.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Men Sneakers</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">24 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*298</td>
                                                <td><span class="badge text-light-dark">RETURNS</span></td>
                                                <td>Apr 16, 2024</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sunglasse-tab-pane" role="tabpanel"
                                     aria-labelledby="sunglasse-tab" tabindex="0">
                                    <div class="table-responsive app-scroll app-datatable-default">
                                        <table id="recentOrders4" class="display ">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order</th>
                                                <th>Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>#86743</td>
                                                <td>
                                                    <div class="position-relative">
                                                        <div
                                                            class="h-40 w-40 d-flex-center b-r-15 overflow-hidden bg-light-secondary p-1 position-absolute">
                                                            <img src="{{asset('../assets/images/dashboard/ecommerce-dashboard/18.png')}}" alt=""
                                                                 class="img-fluid">
                                                        </div>
                                                        <div class="ms-5">
                                                            <h6 class="mb-0 f-s-16">Round Sunglasses</h6>
                                                            <p class="mb-0 f-s-14 text-secondary">10 product</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>1*400</td>
                                                <td><span class="badge text-light-primary">PICKUPS</span></td>
                                                <td>Sep 10, 2024</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->

    <div class="modal" tabindex="-1" id="welcomeCard" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content welcome-card">

                <div class="modal-body p-0">
                    <div class="text-center position-relative welcome-card-content z-1 p-3">
                        <div class="text-end">
                            <i class="ti ti-x fs-5 text-dark f-w-600" data-bs-dismiss="modal"></i>
                        </div>
                        <h2 class="f-w-600"><span>Welcome !</span>👋 </h2>
                        <h6 class="f-s-15 text-dark f-w-500 mx-5"> Start Multipurpose, clean modern responsive bootstrap 5 admin template </h6>

                        <div>
                            <img src="{{asset('assets/images/modals/welcome-1.png')}}" alt="img" class=" img-fluid">
                        </div>
                        <div class="mt-3 mb-4">
                            <button type="button" class="btn btn-primary text-white btn-lg" data-bs-dismiss="modal">Let's
                                Started <i class="ti ti-chevrons-right"></i> </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <!-- slick-file -->
    <script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

    <!-- vector map plugin js -->
    <script src="{{asset('assets/vendor/vector-map/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/vector-map/jquery-jvectormap-world-mill.js')}}"></script>

    <!--cleave js  -->
    <script src="{{asset('assets/vendor/cleavejs/cleave.min.js')}}"></script>

    <!-- Glight js -->
    <script src="{{asset('assets/vendor/glightbox/glightbox.min.js')}}"></script>

    <!-- data table-->
    <script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

    <!-- apexcharts js-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Ecommerce js-->
    <script src="{{asset('assets/js/ecommerce_dashboard.js')}}"></script>

@endsection
