@extends('admin.layouts.app')
@section('title','SPLT | Dashboard')
@section('sub_title','Shop Overview')
@section('import_export')
<li class="pc-h-item">
</li>
<li class="pc-h-item">
</li>
@endsection
@section('contents')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Overview</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="date-range-dropdown">
                        <span>28 Jan, 2021 - 28 Dec, 2021</span>
                        <span class="arrow">&#9662;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row mb-3">
            <div class="col-lg-4 col-md-6">
            <div class="card radius-5">
                <div class="action-btn">
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                </div>
                <div class="card-body pt-0 pb-35">
                <div class="row align-items-center">
                    <div class="col-8">
                    <p class="card_title">Sales</p>
                    <h3 class="card_price">$20.4K</h3>
                    </div>
                    <div class="col-4 text-end">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/card-icon.svg')}}" width="60" height="60" alt="card-icon.svg">
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="card radius-5">
                <div class="action-btn">
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                </div>
                <div class="card-body pt-0 pb-35">
                <div class="row align-items-center">
                    <div class="col-8">
                    <p class="card_title">Revenue</p>
                    <h3 class="card_price">$8.2K</h3>
                    </div>
                    <div class="col-4 text-end">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/card-icon.svg')}}" width="60" height="60" alt="card-icon.svg">
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="card radius-5">
                <div class="action-btn">
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                </div>
                <div class="card-body pt-0 pb-35">
                <div class="row align-items-center">
                    <div class="col-8">
                    <p class="card_title">Escrow</p>
                    <h3 class="card_price">$18.2K</h3>
                    </div>
                    <div class="col-4 text-end">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/card-icon.svg')}}" width="60" height="60" alt="card-icon.svg">
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="card radius-5">
                <div class="action-btn">
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                </div>
                <div class="card-body pt-0 pb-35">
                <div class="row align-items-center">
                    <div class="col-8">
                    <p class="card_title">Orders</p>
                    <h3 class="card_price">219</h3>
                    </div>
                    <div class="col-4 text-end">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/cart.svg')}}" width="60" height="60" alt="cart.svg">
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="card radius-5">
                <div class="action-btn">
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                </div>
                <div class="card-body pt-0 pb-35">
                <div class="row align-items-center">
                    <div class="col-8">
                    <p class="card_title">Products</p>
                    <h3 class="card_price">50</h3>
                    </div>
                    <div class="col-4 text-end">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/products.svg')}}" width="60" height="60" alt="products.svg">
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="card radius-5">
                <div class="action-btn">
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                </div>
                <div class="card-body pt-0 pb-35">
                <div class="row align-items-center">
                    <div class="col-8">
                    <p class="card_title">Admin Earnings</p>
                    <h3 class="card_price">$5K</h3>
                    </div>
                    <div class="col-4 text-end">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/dollor.svg')}}" width="60" height="60" alt="dollor.svg">
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- chart row -->
        <div class="row mb-3">
            <div class="col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body">
                <div class="header">
                    <div class="card-title">
                    <h2>Total Revenue</h2>
                    <div class="summary">
                        <h1>$50.4K</h1>
                        <p><span class="arrow-up">↑</span> 5% than last month</p>
                    </div>
                    </div>
                    <div class="filters">
                    <div class="filter-box">
                        <button class="tab-btn active">Month</button>
                        <button class="tab-btn">Week</button>
                        <button class="tab-btn">Day</button>
                    </div>
                    <div class="revenue-type-box">
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="group4" value="" id="flexCheckDefault" data-gtm-form-interact-field-id="2" checked="checked"> <label class="form-check-label" for="flexCheckDefault">Profit</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="group4" value="" id="flexCheckChecked" data-gtm-form-interact-field-id="3">
                        <label class="form-check-label" for="flexCheckChecked">Loss</label>
                        </div>
                    </div>
                    <div class="action-btn">
                        <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                        <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                    </div>
                    </div>
                </div>
                <div id="overview-chart-1"></div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-4">
            <div class="card sold-items">
                <div class="card-body">
                <div class="card-header">
                    <h2>Most Sold Items</h2>
                    <div class="action-btn">
                    <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                    <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mb-2">Jeans<span class="float-end">70%</span></p>
                    <div class="progress progress-primary" style="height: 8px">
                    <div class="progress-bar" style="width: 70%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mb-2">Shirts<span class="float-end">40%</span></p>
                    <div class="progress progress-primary" style="height: 8px">
                    <div class="progress-bar" style="width: 40%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mb-2">Belts<span class="float-end">60%</span></p>
                    <div class="progress progress-primary" style="height: 8px">
                    <div class="progress-bar" style="width: 40%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mb-2">Caps<span class="float-end">80%</span></p>
                    <div class="progress progress-primary" style="height: 8px">
                    <div class="progress-bar" style="width: 80%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mb-2">Others<span class="float-end">20%</span></p>
                    <div class="progress progress-primary" style="height: 8px">
                    <div class="progress-bar" style="width: 20%"></div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Latest Orders row -->
        <div class="row mb-3">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="card-header">
                        <h2>Latest Orders</h2>
                        <div class="action-btn">
                        <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                        <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table latest-orders-table">
                        <thead>
                            <tr>
                            <th>Products</th>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer name</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>Iphone 13 Pro</td>
                            <td>#11232</td>
                            <td>Jun 29,2022</td>
                            <td>Afaq Karim</td>
                            <td><span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i></span>Delivered</td>
                            <td>$400.00</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button id="btnGroupDrop3" type="button" class="btn m-0 btn-secondary dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{ asset(config('constants.admin_path').'images/icons/ellipsis-h.svg')}}" alt="ellipsis-h.svg"> --}}
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3" style="">
                                    <a class="dropdown-item" href="#!">Edit</a>
                                    <a class="dropdown-item" href="#!">Delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <td>Mackbook Pro</td>
                            <td>#11232</td>
                            <td>Jun 29,2022</td>
                            <td>Afaq Karim</td>
                            <td><span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i></span>Pending</td>
                            <td>$400.00</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button id="btnGroupDrop3" type="button" class="btn m-0 btn-secondary dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{ asset(config('constants.admin_path').'images/icons/ellipsis-h.svg')}}" alt="ellipsis-h.svg"> --}}
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </button>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3" style="">
                                    <a class="dropdown-item" href="#!">Edit</a>
                                    <a class="dropdown-item" href="#!">Delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <td>Apple Watch</td>
                            <td>#11232</td>
                            <td>Jun 29,2022</td>
                            <td>Afaq Karim</td>
                            <td><span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i></span>Canceled</td>
                            <td>$400.00</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button id="btnGroupDrop3" type="button" class="btn m-0 btn-secondary dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{ asset(config('constants.admin_path').'images/icons/ellipsis-h.svg')}}" alt="ellipsis-h.svg"> --}}
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3" style="">
                                    <a class="dropdown-item" href="#!">Edit</a>
                                    <a class="dropdown-item" href="#!">Delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <td>Microsoft Book</td>
                            <td>#11232</td>
                            <td>Jun 29,2022</td>
                            <td>Afaq Karim</td>
                            <td><span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i></span>Delivered</td>
                            <td>$400.00</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button id="btnGroupDrop3" type="button" class="btn m-0 btn-secondary dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{ asset(config('constants.admin_path').'images/icons/ellipsis-h.svg')}}" alt="ellipsis-h.svg"> --}}
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3" style="">
                                    <a class="dropdown-item" href="#!">Edit</a>
                                    <a class="dropdown-item" href="#!">Delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <td>Apple Pen</td>
                            <td>#11232</td>
                            <td>Jun 29,2022</td>
                            <td>Afaq Karim</td>
                            <td><span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i></span>Delivered</td>
                            <td>$400.00</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button id="btnGroupDrop3" type="button" class="btn m-0 btn-secondary dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{ asset(config('constants.admin_path').'images/icons/ellipsis-h.svg')}}" alt="ellipsis-h.svg"> --}}
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3" style="">
                                    <a class="dropdown-item" href="#!">Edit</a>
                                    <a class="dropdown-item" href="#!">Delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <td>Airpods</td>
                            <td>#11232</td>
                            <td>Jun 29,2022</td>
                            <td>Afaq Karim</td>
                            <td><span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i></span>Delivered</td>
                            <td>$400.00</td>
                            <td>
                                <div class="btn-group" role="group">
                                <button id="btnGroupDrop3" type="button" class="btn m-0 btn-secondary dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{ asset(config('constants.admin_path').'images/icons/ellipsis-h.svg')}}" alt="ellipsis-h.svg"> --}}
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3" style="">
                                    <a class="dropdown-item" href="#!">Edit</a>
                                    <a class="dropdown-item" href="#!">Delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Sellers row -->
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                <div class="card-body">
                    <div class="card-header">
                    <h2>Top Sellers</h2>
                    <div class="action-btn">
                    <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                    <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                    </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped top-sellers-table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Seller name</th>
                                <th>Store name</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1255</td>
                                <td>Super Market</td>
                                <td>Metro Merchants Mart</td>
                                <td>21516202.17999995</td>
                            </tr>
                            <tr>
                                <td>1256</td>
                                <td>Skyline Seller hub</td>
                                <td>Skyline Seller hub</td>
                                <td>1250</td>
                            </tr>
                            <tr>
                                <td>1287</td>
                                <td>gujarat technological university</td>
                                <td>UrbanTrade Emporium</td>
                                <td>87</td>
                            </tr>
                            <tr>
                                <td>1288</td>
                                <td>South Indian</td>
                                <td>Nexus Marketplace</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>4296</td>
                                <td>-</td>
                                <td>test</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                <div class="card-body">
                    <div class="card-header">
                    <h2>Top Categories</h2>
                    <div class="action-btn">
                    <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/delete.svg')}}" alt="delete.svg"></a>
                    <a href="#"><img src="{{ asset(config('constants.admin_path').'images/icons/icon2.svg')}}" alt="icon2.svg"></a>
                    </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped top-sellers-table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Clicks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>61</td>
                                <td>Smartphone</td>
                                <td>95675</td>
                            </tr>
                            <tr>
                                <td>49</td>
                                <td>Computer & Laptops</td>
                                <td>22817</td>
                            </tr>
                            <tr>
                                <td>119</td>
                                <td>Digital product</td>
                                <td>17640</td>
                            </tr>
                            <tr>
                                <td>69</td>
                                <td>Decor</td>
                                <td>17336</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- <script src="{{ asset(config('constants.admin_path').'js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/new-orders-graph.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/new-users-graph.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/visitors-graph.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/overview-chart.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/income-graph.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/languages-graph.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/overview-product-graph.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/total-earning-graph-1.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'js/widgets/total-earning-graph-2.js') }}"></script> --}}
@endsection
