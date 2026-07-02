<div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-primary border-0 rounded-3 welcome-box mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="border-bottom position-relative top-5">
                                <h3 class="text-white fw-semibold mb-1">Good Morning, <span class="text-danger-div">{{\Illuminate\Support\Facades\Auth::user()->name}}!</span></h3>
                                <p class="text-light">Here's what's happening with your store today.</p>
                            </div>

                            <div class="d-flex align-items-center flex-wrap gap-4 gap-xxl-5">
                                <div class="d-flex align-items-center welcome-status-item">
                                    <div class="flex-shrink-0">
                                        <i class="material-symbols-outlined">shopping_bag</i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="text-white fw-semibold mb-0">86 New orders</h5>
                                        <p class="text-light">Awaiting processing</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center welcome-status-item">
                                    <div class="flex-shrink-0">
                                        <i class="material-symbols-outlined icon-bg">chat_error</i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="text-white fw-semibold mb-0">35 Products</h5>
                                        <p class="text-light">Out of stock</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="welcome-img text-center text-sm-end mt-4 mt-sm-0">
                                <img src="{{asset('assets/images/welcome.png')}}" alt="welcome">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="row justify-content-center">
                <div class="col-md-4 col-lg-12">
                    <div class="card bg-white border-0 rounded-3 mb-4 stats-box">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <div>
                                    <div class="d-flex">
                                        <span>Total Orders</span>
                                        <span class="count">-7.6%</span>
                                    </div>
                                    <h3 class="fs-20 mt-1 mb-0">$72,458</h3>
                                </div>
                                <span class="fs-12">Last 7 days</span>
                            </div>
                            <div style="max-width: 153px; margin: auto; margin-top: -27px;  margin-bottom: -18px;">
                                <div id="total_orders1"></div>
                            </div>
                            <ul class="ps-0 mb-0 list-unstyled stats-list">
                                <li class="d-flex justify-content-between align-items-center">
                                    <span class="title">Completed</span>
                                    <span>62%</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span class="title">Pending payment</span>
                                    <span>38%</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                        <h3 class="mb-0">Sales by Locations</h3>

                        <div class="dropdown action-opt">
                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="more-horizontal"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="clock"></i>
                                        Today
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="pie-chart"></i>
                                        Last 7 Days
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="rotate-cw"></i>
                                        Last Month
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="calendar"></i>
                                        Last 1 Year
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="bar-chart"></i>
                                        All Time
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="eye"></i>
                                        View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i data-feather="trash"></i>
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-center" style="margin: 30px 0;">
                        <div id="sales_by_locations_map"></div>
                    </div>
                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations mt-4">
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('assets/images/usa.svg')}}" class="wh-30 rounded-circle" alt="usa">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="fw-medium d-block mb-2">United States</span>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 85%">
                                        <span class="count fw-medium text-body">85%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('assets/images/germany.svg')}}" class="wh-30 rounded-circle" alt="germany">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="fw-medium d-block mb-2">Germany</span>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 75%">
                                        <span class="count fw-medium text-body">75%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('assets/images/united-kingdom.svg')}}" class="wh-30 rounded-circle" alt="united-kingdom">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="fw-medium d-block mb-2">United Kingdom</span>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 40%">
                                        <span class="count fw-medium text-body">40%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('assets/images/canada.svg')}}" class="wh-30 rounded-circle" alt="canada">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="fw-medium d-block mb-2">Canada</span>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 10%">
                                        <span class="count fw-medium text-body">10%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('assets/images/portugal.svg')}}" class="wh-30 rounded-circle" alt="portugal">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="fw-medium d-block mb-2">Portugal</span>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="05" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 05%">
                                        <span class="count fw-medium text-body">05%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{asset('assets/images/spain.svg')}}" class="wh-30 rounded-circle" alt="spain">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="fw-medium d-block mb-2">Spain</span>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 15%">
                                        <span class="count fw-medium text-body">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card bg-white border-0 rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                        <h3 class="mb-0">Top Selling Products</h3>
                        <select class="form-select month-select form-control" aria-label="Default select example">
                            <option selected>Today</option>
                            <option value="1">Weekly</option>
                            <option value="2">Monthly</option>
                            <option value="3">Yearly</option>
                        </select>
                    </div>

                    <div class="default-table-area top-selling-products">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="product-details.html" class="d-flex align-items-center">
                                            <img src="{{asset('assets/images/product-1.jpg')}}" class="wh-40 rounded-3" alt="product-1">
                                            <div class="ms-2 ps-1">
                                                <h6 class="fw-medium fs-14">Smart Band</h6>
                                                <span class="fs-12 text-body">20 Mar 2024</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>$35.00</td>
                                    <td>75</td>
                                    <td>750</td>
                                    <td>$2,625</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="product-details.html" class="d-flex align-items-center">
                                            <img src="{{asset('assets/images/product-2.jpg')}}" class="wh-40 rounded-3" alt="product-2">
                                            <div class="ms-2 ps-1">
                                                <h6 class="fw-medium fs-14">Headphone</h6>
                                                <span class="fs-12 text-body">12 Jan 2024</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>$49.00</td>
                                    <td>25</td>
                                    <td>825</td>
                                    <td>$1,225</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="product-details.html" class="d-flex align-items-center">
                                            <img src="{{asset('assets/images/product-3.jpg')}}" class="wh-40 rounded-3" alt="product-3">
                                            <div class="ms-2 ps-1">
                                                <h6 class="fw-medium fs-14">iPhone 15 Plus</h6>
                                                <span class="fs-12 text-body">08 Jan 2024</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>$99.00</td>
                                    <td>55</td>
                                    <td class="text-danger">Stock Out</td>
                                    <td>$5,445</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="product-details.html" class="d-flex align-items-center">
                                            <img src="{{asset('assets/images/product-4.jpg')}}" class="wh-40 rounded-3" alt="product-4">
                                            <div class="ms-2 ps-1">
                                                <h6 class="fw-medium fs-14">Bluetooth Speaker</h6>
                                                <span class="fs-12 text-body">04 Jan 2024</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>$59.00</td>
                                    <td>40</td>
                                    <td>535</td>
                                    <td>$2,360</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="product-details.html" class="d-flex align-items-center">
                                            <img src="{{asset('assets/images/product-5.jpg')}}" class="wh-40 rounded-3" alt="product-5">
                                            <div class="ms-2 ps-1">
                                                <h6 class="fw-medium fs-14">Airbuds 2nd Gen</h6>
                                                <span class="fs-12 text-body">01 Jan 2024</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>$79.00</td>
                                    <td>56</td>
                                    <td>460</td>
                                    <td>$4,424</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0 justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link icon" href="index.html" aria-label="Previous">
                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link active" href="index.html">1</a></li>
                                    <li class="page-item"><a class="page-link" href="index.html">2</a></li>
                                    <li class="page-item"><a class="page-link" href="index.html">3</a></li>
                                    <li class="page-item"><a class="page-link" href="index.html">4</a></li>
                                    <li class="page-item">
                                        <a class="page-link icon" href="index.html" aria-label="Next">
                                            <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
