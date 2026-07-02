@extends('my_app.backend.master')

@section('main-content')

    <div class="container-fluid">
        <div class="row">
            {{--<div class="col-sm-6 col-lg-3">
                <div class="card currency-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="position-relative">
                                <div class="h-40 w-40 d-flex-center b-r-8 overflow-hidden bg-light-warning  p-1 currency-icon">
                                    <i class="ph-bold  ph-currency-btc f-s-20"></i>
                                </div>
                                <div class="ms-5">
                                    <h6 class="header-title-text mb-0">Bitcoin</h6>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-warning">45.900BTC</h5>
                            </div>
                        </div>
                        <div class="currency-chart-box">
                            <div >
                                <div id="bitCoin" class="currency-chart"></div>
                            </div>
                        </div>
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
            <div class="col-sm-6 col-lg-3">
                <div class="card currency-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="position-relative">
                                <div class="h-40 w-40 d-flex-center b-r-8 overflow-hidden bg-light-primary p-1 currency-icon">
                                    <i class="ph-bold  ph-currency-eth f-s-20"></i>
                                </div>
                                <div class="ms-5">
                                    <h6 class="header-title-text mb-0">Ethereum</h6>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-primary">78.900ETC</h5>
                            </div>
                        </div>
                        <div class="currency-chart-box">
                            <div>
                                <div id="ethereumCoin" class="currency-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card currency-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="position-relative">
                                <div class="h-40 w-40 d-flex-center b-r-8 overflow-hidden bg-light-success p-1 currency-icon">
                                    <i class="ph-fill  ph-diamonds-four f-s-20"></i>
                                </div>
                                <div class="ms-5">
                                    <h6 class="header-title-text mb-0">Binance</h6>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-success">45.900BNB</h5>
                            </div>
                        </div>
                        <div class="currency-chart-box">
                            <div>
                                <div id="binanceCoin" class="currency-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="transaction-list-header">
                            <h5 class="header-title-text txt-ellipsis-1"> {{ __('messages.welcome') }}</h5>
                        </div>


                        <ul class="transaction-list mt-3">
                            <li class="transaction-list-item">
                                <div class="h-40 w-40 d-flex-center b-r-10 overflow-hidden text-bg-secondary transaction-list-avatar">
                                    <img src="{{asset('assets/images/avtar/1.png')}}" loading="lazy" alt="" class="img-fluid">
                                </div>
                                <div class="transaction-list-content">
                                    <h6 class="mb-0">Bitcoin</h6>
                                    <p class="mb-0 text-secondary">Buy</p>
                                </div>
                                <div>
                                    <p class="mb-0 f-s-15 f-w-500 text-success">+$24,00</p>
                                    <p class="mb-0 f-s-12 text-secondary">12:35 PM</p>
                                </div>
                            </li>
                            <li class="transaction-list-item">
                                <div class="h-40 w-40 d-flex-center b-r-10 overflow-hidden text-bg-light transaction-list-avatar">
                                    <img src="{{asset('assets/images/avtar/2.png')}}" loading="lazy" alt="" class="img-fluid">
                                </div>
                                <div class="transaction-list-content">
                                    <h6 class="mb-0">Ethereum</h6>
                                    <p class="mb-0 text-secondary">Sell</p>
                                </div>
                                <div>
                                    <p class="mb-0 f-s-15 f-w-500 text-danger">-$78,00</p>
                                    <p class="mb-0 f-s-12 text-secondary">12:35 PM</p>
                                </div>
                            </li>
                            <li class="transaction-list-item">
                                <div class="h-40 w-40 d-flex-center b-r-10 overflow-hidden text-bg-dark transaction-list-avatar">
                                    <img src="{{asset('assets/images/avtar/3.png')}}" loading="lazy" alt="" class="img-fluid">
                                </div>
                                <div class="transaction-list-content">
                                    <h6 class="mb-0">Binance</h6>
                                    <p class="mb-0 text-secondary">Buy</p>
                                </div>
                                <div>
                                    <p class="mb-0 f-s-15 f-w-500 text-success">+$89,00</p>
                                    <p class="mb-0 f-s-12 text-secondary">12:35 PM</p>
                                </div>
                            </li>
                            <li class="transaction-list-item">
                                <div class="h-40 w-40 d-flex-center b-r-10 overflow-hidden text-bg-secondary transaction-list-avatar">
                                    <img src="{{asset('../assets/images/avtar/4.png')}}" loading="lazy" alt="" class="img-fluid">
                                </div>
                                <div class="transaction-list-content">
                                    <h6 class="mb-0">Lite coin</h6>
                                    <p class="mb-0 text-secondary">Sell</p>
                                </div>
                                <div>
                                    <p class="mb-0 f-s-15 f-w-500 text-danger">-$18,00</p>
                                    <p class="mb-0 f-s-12 text-secondary">12:35 PM</p>
                                </div>
                            </li>
                            <li class="transaction-list-item">
                                <div class="h-40 w-40 d-flex-center b-r-10 overflow-hidden text-bg-secondary transaction-list-avatar">
                                    <img src="{{asset('assets/images/avtar/6.png')}}" loading="lazy" alt="" class="img-fluid">
                                </div>
                                <div class="transaction-list-content">
                                    <h6 class="mb-0">Ethereum</h6>
                                    <p class="mb-0 text-secondary">Buy</p>
                                </div>
                                <div>
                                    <p class="mb-0 f-s-15 f-w-500 text-success">+$87,00</p>
                                    <p class="mb-0 f-s-12 text-secondary">8:05 PM</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 order--1-md">
                <div class="card card-dark currency-data-card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>Profit</h6>
                                <h2>$45,897</h2>
                                <p class="text-light">45.9% Year over year</p>
                            </div>
                            <div class="col-sm-6 text-end text-sm-start">
                                <h6>Shares</h6>
                                <h4>$7,829.03</h4>
                                <p class="text-light txt-ellipsis-1 mb-0">14.07% Year over year</p>
                                <div>
                                    <div id="sharesChart"></div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-1">
                                <div class="currency-coin-box bg-primary">
                                    <div class="h-45 w-45 d-flex-center b-r-15 overflow-hidden  p-1 mb-3">
                                        <img src="{{asset('assets/images/dashboard/analytics/binance.png')}}" loading="lazy" alt="" class="img-fluid">
                                    </div>
                                    <p class="text-light txt-ellipsis-1 mb-0">Bitcoin</p>
                                    <h6 class="mb-0">$72,890</h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-1">
                                <div class="currency-coin-box bg-danger">
                                    <div class="h-45 w-45 d-flex-center b-r-15 overflow-hidden p-1 mb-3">
                                        <img src="{{asset('assets/images/dashboard/analytics/ethereum.png')}}" loading="lazy" alt="" class="img-fluid">
                                    </div>
                                    <p class="text-light txt-ellipsis-1 mb-0">Ethereum</p>
                                    <h6 class="mb-0">$34,786</h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-1">
                                <div class="currency-coin-box bg-secondary">
                                    <div class="h-45 w-45 d-flex-center b-r-15 overflow-hidden  p-1 mb-3">
                                        <img src="{{asset('assets/images/dashboard/analytics/dogecoin.png')}}" loading="lazy" alt="" class="img-fluid">
                                    </div>
                                    <p class="text-light txt-ellipsis-1 mb-0">Dash</p>
                                    <h6 class="mb-0">$34,786</h6>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-1">
                                <div class="currency-coin-box bg-success">
                                    <div class="h-45 w-45 d-flex-center b-r-15 overflow-hidden   p-1 mb-3">
                                        <img src="{{asset('assets/images/dashboard/analytics/turkish-lira.png')}}" loading="lazy" alt="" class="img-fluid">
                                    </div>
                                    <p class="text-light txt-ellipsis-1 mb-0">Edo</p>
                                    <h6 class="mb-0">$34,786</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="wallet-card-header d-flex align-items-center justify-content-between">
                            <h5 class="header-title-text d-none d-xxl-block txt-ellipsis">Your Wallet</h5>
                            <div class="wallet-tabs">
                                <ul class="nav nav-tabs app-tabs-primary" id="wallet" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy-tab-pane"
                                                type="button" role="tab" aria-controls="buy-tab-pane" aria-selected="false"
                                                tabindex="-1">Buy</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sell-tab" data-bs-toggle="tab" data-bs-target="#sell-tab-pane"
                                                type="button" role="tab" aria-controls="sell-tab-pane" aria-selected="false"
                                                tabindex="-1">Sell</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="exchange-tab" data-bs-toggle="tab"
                                                data-bs-target="#exchange-tab-pane" type="button" role="tab"
                                                aria-controls="exchange-tab-pane" aria-selected="true">Exchange</button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4 ">
                            <div class="tab-content" id="walletContent">
                                <div class="tab-pane fade" id="buy-tab-pane" role="tabpanel" aria-labelledby="buy-tab"
                                     tabindex="0">
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div
                                                class="h-35 w-35 d-flex-center b-r-10 overflow-hidden bg-warning position-absolute mt-1">
                                                <i class="ph-bold  ph-currency-btc"></i>
                                            </div>
                                            <div class="mg-s-45">
                                                <h6 class="text-warning mb-0">BITCOIN</h6>
                                                <p class="mb-0">Bitcoin Price</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="btn-group dropdown-icon-none">
                                                <i class="ph-fill  ph-caret-circle-down f-s-20 p-2 text-secondary" role="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"></i>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div>
                                                <p class="text-dark mb-0">Bitcoin Price</p>
                                                <h6 class="mb-0 text-secondary">$24,87.900</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select">
                                                <option selected="">USD</option>
                                                <option value="1">BTC</option>
                                                <option value="2">LTC</option>
                                                <option value="3">ETC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div>
                                                <p class="text-dark mb-0">Amount</p>
                                                <h6 class="mb-0 text-secondary">$24,87.900</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select">
                                                <option selected="">BTC</option>
                                                <option value="2">LTC</option>
                                                <option value="3">ETC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-end mt-4">
                                        <a href="#" target="_blank" role="button" class="btn btn-success b-r-10">Buy Coin</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sell-tab-pane" role="tabpanel" aria-labelledby="sell-tab"
                                     tabindex="0">
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div
                                                class="h-35 w-35 d-flex-center b-r-10 overflow-hidden bg-warning position-absolute mt-1">
                                                <i class="ph-bold  ph-currency-btc"></i>
                                            </div>
                                            <div class="mg-s-45">
                                                <h6 class="text-warning mb-0">BITCOIN</h6>
                                                <p class="mb-0">Bitcoin Price</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="btn-group dropdown-icon-none">
                                                <i class="ph-fill  ph-caret-circle-down f-s-20 p-2 text-secondary" role="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"></i>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div>
                                                <p class="text-dark mb-0">Bitcoin Price</p>
                                                <h6 class="mb-0 text-secondary">$24,87.900</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select">
                                                <option selected="">USD</option>
                                                <option value="1">BTC</option>
                                                <option value="2">LTC</option>
                                                <option value="3">ETC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div>
                                                <p class="text-dark mb-0">Amount</p>
                                                <h6 class="mb-0 text-secondary">$24,87.900</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select">
                                                <option selected="">BTC</option>
                                                <option value="2">LTC</option>
                                                <option value="3">ETC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-end mt-4">
                                        <a href="#" target="_blank" role="button" class="btn btn-danger b-r-10">Sell Coin</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade active show" id="exchange-tab-pane" role="tabpanel"
                                     aria-labelledby="exchange-tab" tabindex="0">
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div
                                                class="h-35 w-35 d-flex-center b-r-10 overflow-hidden bg-warning position-absolute mt-1">
                                                <i class="ph-bold  ph-currency-btc"></i>
                                            </div>
                                            <div class="mg-s-45">
                                                <h6 class="text-warning mb-0">BITCOIN</h6>
                                                <p class="mb-0">Bitcoin Price</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="btn-group dropdown-icon-none">
                                                <i class="ph-fill  ph-caret-circle-down f-s-20 p-2 text-secondary" role="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"></i>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-badge-right"></i> Menu item</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div>
                                                <p class="text-dark mb-0">Bitcoin Price</p>
                                                <h6 class="mb-0 text-secondary">$24,87.900</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select">
                                                <option selected="">USD</option>
                                                <option value="1">BTC</option>
                                                <option value="2">LTC</option>
                                                <option value="3">ETC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="wallet-card">
                                        <div class="position-relative">
                                            <div>
                                                <p class="text-dark mb-0">Amount</p>
                                                <h6 class="mb-0 text-secondary">$24,87.900</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select">
                                                <option selected="">BTC</option>
                                                <option value="2">LTC</option>
                                                <option value="3">ETC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-end mt-4">
                                        <a href="#" target="_blank" role="button" class="btn btn-primary b-r-10">Connect Wallet</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-5">
                <div class="card currency-growth-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="header-title-text">$78,906.099</h4>
                                <p class="mb-0 text-secondary">Total <span class="text-danger">-45%</span> Growth</p>
                            </div>
                            <div>
                                <div class="growth-tabs">
                                    <ul class="nav nav-tabs app-tabs-primary" id="growth" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="day-growth-tab" data-bs-toggle="tab" data-bs-target="#day-growth-tab-pane" role="tab" aria-selected="false" tabindex="-1">1D</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="week-growth-tab" data-bs-toggle="tab" data-bs-target="#week-growth-tab-pane" role="tab" aria-selected="false">1W</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="month-growth-tab" data-bs-toggle="tab" data-bs-target="#month-growth-tab-pane" role="tab" aria-selected="true">1M</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="year-growth-tab" data-bs-toggle="tab" data-bs-target="#year-growth-tab-pane" role="tab" aria-selected="false">1Y</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="total-growth">
                            <div id="totalGrowth"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-7 col-lg-4">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive app-scroll">
                            <table class="table currency-market-table align-middle table-bottom-border mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">MarketCap</th>
                                    <th scope="col">America</th>
                                    <th scope="col">Progress</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-warning position-absolute">
                                                <img src="{{asset('assets/images/dashboard/analytics/bitcoin.png')}}" loading="lazy" alt="" class="img-fluid">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Bitcoin</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$25,89.00</td>
                                    <td>
                                        <div class="coin-progress">
                                            <div class="coinProgress"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-success position-absolute">
                                                <img src="{{asset('assets/images/dashboard/analytics/turkish-lira.png')}}" loading="lazy" alt="" class="img-fluid">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Edo</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$21,80.00</td>
                                    <td>
                                        <div class="coin-progress">
                                            <div class="coinProgress"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-secondary position-absolute">
                                                <img src="{{asset('assets/images/dashboard/analytics/ethereum.png')}}" loading="lazy" alt="" class="img-fluid">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Ethereum</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$18,97.00</td>
                                    <td>
                                        <div class="coin-progress">
                                            <div class="coinProgress"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-primary position-absolute">
                                                <img src="{{asset('assets/images/dashboard/analytics/binance.png')}}" loading="lazy" alt="" class="img-fluid">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Binance</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$29,80.00</td>
                                    <td>
                                        <div class="coin-progress">
                                            <div class="coinProgress"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-warning position-absolute">
                                                <img src="{{asset('assets/images/dashboard/analytics/dogecoin.png')}}" loading="lazy" alt="" class="img-fluid">
                                            </div>
                                            <div class="ms-5">
                                                <h6 class="mb-0">Dash</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$12,64.00</td>
                                    <td>
                                        <div class="coin-progress">
                                            <div class="coinProgress"></div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-5 col-lg-3">
                <div class="card card-added">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{asset('assets/images/dashboard/analytics/bg.png')}}"  loading="lazy" class="img-fluid" alt="">
                            <div>
                                <h5 class="text-primary mt-3">Your Card Added Successfully</h5>
                                <p class="text-secondary f-s-15 mt-2 mb-0">Congratulations! Your card has been Successfully added.</p>
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" target="_blank" role="button" class="btn btn-primary">Added Card</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
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
