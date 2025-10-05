@extends('trainer.layouts.app')
@section('title','SPLT | Clients')
@section('sub_title','Clients Management')
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
        @include('trainer.client.view_client_header')
        <!-- clients tabs -->
        <div class="clients-tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @include('trainer.client.client_tabs')
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-12">
                        <div class="card-box">
                            <div class="card-header">
                                <h3 class="card-title">Workout Plan</h3>
                                <div class="card-icon">
                                <p>Edit Plan</p>
                                <a href=""><img src="{{ asset(config('constants.admin_path').'/images/icons/toggle.svg')}}" alt="toggle"></a>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-inner_txt">
                                    <div class="img-box">
                                    <img src="{{ asset(config('constants.admin_path').'/images/icons/notebook.svg')}}" alt="notebook">
                                    </div>
                                    <div>
                                    <p>Untitled workout</p>
                                    <span>3 exercises ∙ Start date Apr 8, 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- notes -->
                        <div class="card-box">
                            <div class="card-header">
                                <h3 class="card-title">Notes</h3>
                                <div class="card-icon">
                                <a href="#"><img src="{{ asset(config('constants.admin_path').'/images/icons/question.svg')}}" alt="question"></a>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-inner_txt">
                                    <div class="notes">
                                    <p>Add notes about this client, e.g. "Has a history of knee pain"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- achievements -->
                        <div class="card-box">
                            <div class="card-header">
                                <h3 class="card-title">Achievements</h3>
                                <div class="card-icon">
                                <a href="#"><img src="{{ asset(config('constants.admin_path').'/images/icons/chevron-right-w.svg')}}" alt="chevron-right"></a>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-value">
                                <span class="total-value">25</span>
                                <img src="{{ asset(config('constants.admin_path').'/images/icons/medal.svg')}}" alt="medal">
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-12">
                        <div class="card-box">
                            <div class="card-header">
                                <h3 class="card-title">Latest Activities</h3>
                            </div>
                            <div class="card-content">
                                <ul class="list-item">
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                    <li>Lorem Just completed a 60 minutes Push-Day Workout  he lifted 7800 kg over 23 sets</li>
                                <ul>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- Statistics Start -->
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header statistics">
                        <h3>Statistics</h3>
                        <select class="form-control">
                            <option value="">This Week</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="statistics-card">
                            <h3>Duration</h3>
                            <div class="value">0 min</div>
                            <div class="label">This week</div>
                            <div id="durationChart" class="chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="statistics-card">
                            <h3>Volume</h3>
                            <div class="value">0 kg</div>
                            <div class="label">This week</div>
                            <div id="volumeChart" class="chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="statistics-card">
                            <h3>Set</h3>
                            <div class="value">0 sets</div>
                            <div class="label">This week</div>
                            <div id="setChart" class="chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="statistics-card">
                            <div class="widget-calender" id="pc-datepicker-6"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @include('trainer.client.client_modals')
    </div>
</div>
@endsection
