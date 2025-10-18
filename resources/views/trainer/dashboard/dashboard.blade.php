@extends('trainer.layouts.app')
@section('title','SPLT | Dashboard')
@section('sub_title','Shop Overview')
@section('import_export')
<li class="pc-h-item">
</li>
<li class="pc-h-item">
</li>
@endsection
@section('contents')
<div class="pc-container trainer-container">
    <div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- welcome msg -->
    <div class="welcome-msg__box">
        <h3>Hello, {{Auth::user()->fname}} 👋</h3>
        <p>Get an overview of your clients' progress.</p>
    </div>
    <!-- [ Main Content ] start -->
    <!-- widget card start -->
    <div class="widget-card__grid">
        <div class="widget-card__item">
            <div class="widget-title">
            <a href="">
                <h3>Total Clients</h3>
                <img src="{{ asset(config('constants.admin_path').'images/icons/chevron-right-w.svg')}}" alt="chevron-right">
            </a>
            </div>
            <div class="widget-value">
            <span>13</span>
            </div>
        </div>
        <div class="widget-card__item">
            <div class="widget-title">
            <a href="">
                <h3>Active clients last 7 days</h3>
                <img src="{{ asset(config('constants.admin_path').'images/icons/chevron-right-w.svg')}}" alt="chevron-right">
            </a>
            </div>
            <div class="widget-value">
            <span>9</span>
            </div>
        </div>
        <div class="widget-card__item">
            <div class="widget-title">
            <a href="">
                <h3>Inactive clients last 7 days</h3>
                <img src="{{ asset(config('constants.admin_path').'images/icons/chevron-right-w.svg')}}" alt="chevron-right">
            </a>
            </div>
            <div class="widget-value">
            <span>4</span>
            </div>
        </div>
        <div class="widget-card__item">
            <div class="widget-title">
            <a href="achievements.html">
                <h3>Achievements</h3>
                <img src="{{ asset(config('constants.admin_path').'images/icons/chevron-right-w.svg')}}" alt="chevron-right">
            </a>
            </div>
            <div class="widget-value">
            <span>25</span>
            <img src="{{ asset(config('constants.admin_path').'images/icons/medal.svg')}}" alt="medal">
            </div>
        </div>
        <div class="widget-card__item">
            <div class="widget-title">
            <a href="goals.html">
                <h3>Total Goals</h3>
                <img src="{{ asset(config('constants.admin_path').'images/icons/chevron-right-w.svg')}}" alt="chevron-right">
            </a>
            </div>
            <div class="widget-value">
            <span>3</span>
            </div>
        </div>
    </div>
    <!-- widget card end -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="latest-activities__box">
                <div class="title__head">
                <h2>Latest Activities</h2>
                </div>
                <div class="content__box">
                <div class="activities">
                    <div class="img-box">
                    <img src="{{ asset(config('constants.admin_path').'images/activities-1.jpg')}}" alt="activities-1">
                    </div>
                    <p><span>Lorem</span> Just completed a 60 minutes <span>Push-Day</span> Workout  he lifted 7800 kg over 23 sets</p>
                </div>
                <div class="activities">
                    <div class="img-box">
                    <img src="{{ asset(config('constants.admin_path').'images/activities-2.jpg')}}" alt="activities-2">
                    </div>
                    <p><span>Lorem</span> Just completed a 60 minutes <span>Push-Day</span> Workout  he lifted 7800 kg over 23 sets</p>
                </div>
                <div class="activities">
                    <div class="img-box">
                    <img src="{{ asset(config('constants.admin_path').'images/activities-3.jpg')}}" alt="activities-3">
                    </div>
                    <p><span>Lorem</span> Just completed a 60 minutes <span>Push-Day</span> Workout  he lifted 7800 kg over 23 sets</p>
                </div>
                <div class="activities">
                    <div class="img-box">
                    <img src="{{ asset(config('constants.admin_path').'images/activities-4.jpg')}}" alt="activities-5">
                    </div>
                    <p><span>Lorem</span> Just completed a 60 minutes <span>Push-Day</span> Workout  he lifted 7800 kg over 23 sets</p>
                </div>
                <div class="activities">
                    <div class="img-box">
                    <img src="{{ asset(config('constants.admin_path').'images/activities-5.jpg')}}" alt="activities-5">
                    </div>
                    <p><span>Lorem</span> Just completed a 60 minutes <span>Push-Day</span> Workout  he lifted 7800 kg over 23 sets</p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <div class="weekly-active-clients">
                <div class="title__head">
                <h2>Weekly Active Clients</h2>
                </div>
                <div class="content__box">
                <div id="chart"></div>
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
