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
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('trainer.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{route('trainer.clients')}}">Clients</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Overview</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="clients-info__box">
                    <div class="clients_img">
                    <img src="{{ asset(config('constants.admin_path').'/images/user-placeholder.png')}}" alt="user">
                    </div>
                    <div class="clients_content">
                    <h2>{{$client->client_name}}</h2>
                    <span>{{$client->client_email}}</span>
                    <p>Hasn't worked out yet</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="action-container">
                    <a href="" class="btn-link"><img src="{{ asset(config('constants.admin_path').'/images/icons/log.svg')}}" alt="log">Log Workout</a>
                    <a href="" class="btn-link"><img src="{{ asset(config('constants.admin_path').'/images/icons/send-msg.svg')}}" alt="send-msg">Send Message</a>
                    <a href="javascript:void(0)" class="btn-toggle"><img src="{{ asset(config('constants.admin_path').'/images/icons/toggle.svg')}}" alt="toggle"></a>
                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu-custom">
                    <div class="arrow-up"></div>
                    <ul>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#clientMeasurementModal"><img src="{{ asset(config('constants.admin_path').'/images/icons/mes-icon.svg')}}" alt=""> Log Measurement</a></li>
                        <li><a href="#"><img src="{{ asset(config('constants.admin_path').'/images/icons/remove-icon.svg')}}" alt=""> Remove Client</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- clients tabs -->
        <div class="clients-tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-selected="true">Overview</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="workoutPlans-tab" data-bs-toggle="tab" href="#workoutPlans" role="tab" aria-selected="false" tabindex="-1">Workout Plans</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="exerciseStatistics-tab" data-bs-toggle="tab" href="#exerciseStatistics" role="tab" aria-selected="false" tabindex="-1">Exercise Statistics</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="advancedStatistics-tab" data-bs-toggle="tab" href="#advancedStatistics" role="tab" aria-selected="false" tabindex="-1">Advanced Statistics</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="bodyMeasurements-tab" data-bs-toggle="tab" href="#bodyMeasurements" role="tab" aria-selected="false" tabindex="-1">Body Measurements</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="progressPictures-tab" data-bs-toggle="tab" href="#progressPictures" role="tab" aria-selected="false" tabindex="-1">Progress Pictures</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="settings-tab" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false" tabindex="-1">Settings</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="goals-tab" data-bs-toggle="tab" href="#goals" role="tab" aria-selected="false" tabindex="-1">Goals</a>
                </li>
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
                <div class="tab-pane" id="workoutPlans" role="tabpanel" aria-labelledby="workoutPlans-tab">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                        <div class="card-box">
                            <div class="card-header">
                                <h3 class="card-title">Workout History</h3>
                            </div>
                            <div class="card-content">
                                <div class="card-inner_txt">
                                    <div class="img-box">
                                    <img src="{{ asset(config('constants.admin_path').'/images/icons/notebook.svg')}}" alt="notebook">
                                    </div>
                                    <div>
                                    <p>Untitled Program</p>
                                    <span>1 routines ∙ Start date Apr 8, 2025</span>
                                    </div>
                                </div>
                                <div class="card-inner_txt">
                                    <div class="img-box">
                                    <img src="{{ asset(config('constants.admin_path').'/images/icons/notebook.svg')}}" alt="notebook">
                                    </div>
                                    <div>
                                    <p>Untitled Program</p>
                                    <span>1 routines ∙ Start date Apr 8, 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                        <div class="card-box">
                            <div class="card-header">
                                <h3 class="card-title">Active Program</h3>
                            </div>
                            <div class="card-content p-0">
                                <div class="card-inner_txt justify-content-between py-4 px-3 border-bsm mb-0">
                                    <div class="txt-box w-100">
                                    <img src="{{ asset(config('constants.admin_path').'/images/icons/notebook.svg')}}" alt="notebook">
                                    <p>Untitled Program</p>
                                    <span>1 routines ∙ Start date Apr 8, 2025</span>
                                    </div>
                                    <a href="javascript:void(0)"><img src="{{ asset(config('constants.admin_path').'/images/icons/toggle.svg')}}" alt="toggle"></a>
                                </div>
                                <div class="routine-box py-4 px-3 border-bsm">
                                    <p>Routine 1</p>
                                    <p>Routine 1</p>
                                </div>
                                <div class="edit-box py-4 px-3 text-end">
                                    <a href="javascript:void(0)" class="edit-btn">Edit Program</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="exerciseStatistics" role="tabpanel" aria-labelledby="exerciseStatistics-tab">
                Exercise Statistics
                </div>
                <div class="tab-pane" id="advancedStatistics" role="tabpanel" aria-labelledby="advancedStatistics-tab">
                    <div class="main-container">
                        <div class="sidebar">
                            <ul class="menu-list">
                                <li class="menu-item">
                                <a href="#" class="menu-link active">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/group.svg')}}" alt="Muscle Group"></span>
                                    <span class="menu-txt">Set Count Per Muscle Group</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/duration.svg')}}" alt="duration"></span>
                                    <span class="menu-txt">Duration</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/volume.svg')}}" alt="volume"></span>
                                    <span class="menu-txt">Volume</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/sets.svg')}}" alt="sets"></span>
                                    <span class="menu-txt">Sets</span>
                                </a>
                                </li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <div class="title-head__box">
                                <h3>Set Count Per Muscle Group</h3>
                                <div class="filter-box__area">
                                    <div class="form-group">
                                    <select class="form-control">
                                        <option>Week</option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                    <select class="form-control">
                                        <option>Last 3 months</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="chart__area">
                                <div id="chart"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                    <tr>
                                        <th scope="col">Muscle group</th>
                                        <th scope="col" class="text-end">Sets: January 12 - April 9</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="checked-row">
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_1" checked>
                                            <label for="check_1" class="form-check-label">Shoulders</label>
                                        </div>
                                        </td>
                                        <td class="text-end">2</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_2">
                                            <label for="check_2" class="form-check-label">Abdominals</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_3">
                                            <label for="check_3" class="form-check-label">Abductors</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_4">
                                            <label for="check_4" class="form-check-label">Adductors</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr class="checked-row">
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_5" checked>
                                            <label for="check_5" class="form-check-label">Biceps</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_6">
                                            <label for="check_6" class="form-check-label">Lower Back</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_7">
                                            <label for="check_7" class="form-check-label">Upper Back</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_8">
                                            <label for="check_8" class="form-check-label">Cardio</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr class="checked-row">
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_9" checked>
                                            <label for="check_9" class="form-check-label">Chest</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_10">
                                            <label for="check_10" class="form-check-label">Calves</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_11">
                                            <label for="check_11" class="form-check-label">Forearms</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_12">
                                            <label for="check_12" class="form-check-label">Glutes</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_13">
                                            <label for="check_13" class="form-check-label">Hamstrings</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_14">
                                            <label for="check_14" class="form-check-label">Lats</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="bodyMeasurements" role="tabpanel" aria-labelledby="bodyMeasurements-tab">
                    <div class="main-container">
                        <div class="sidebar">
                            <ul class="menu-list">
                                <li class="menu-item">
                                <a href="#" class="menu-link active">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Abdomen"></span>
                                    <span class="menu-txt">Abdomen</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/body.svg')}}" alt="Body Fat"></span>
                                    <span class="menu-txt">Body Fat</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/body.svg')}}" alt="Body Weight"></span>
                                    <span class="menu-txt">Body Weight</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Chest"></span>
                                    <span class="menu-txt">Chest</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Hips"></span>
                                    <span class="menu-txt">Hips</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Left Bicep"></span>
                                    <span class="menu-txt">Left Bicep</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Left Calf"></span>
                                    <span class="menu-txt">Left Calf</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Left Foreamr"></span>
                                    <span class="menu-txt">Left Foreamr</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Left Thight"></span>
                                    <span class="menu-txt">Left Thight</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Neck"></span>
                                    <span class="menu-txt">Neck</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Right Bicep"></span>
                                    <span class="menu-txt">Right Bicep</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Right Calf"></span>
                                    <span class="menu-txt">Right Calf</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Chest"></span>
                                    <span class="menu-txt">Chest</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Right Foreamr"></span>
                                    <span class="menu-txt">Right Foreamr</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Right Thigh"></span>
                                    <span class="menu-txt">Right Thigh</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Shoulder"></span>
                                    <span class="menu-txt">Shoulder</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="Waist"></span>
                                    <span class="menu-txt">Waist</span>
                                </a>
                                </li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <div class="title-head__box">
                                <h3>Abdomen</h3>
                                <div class="filter-box__area">
                                    <div class="form-group">
                                    <select class="form-control">
                                        <option>All Time</option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                    <div class="action-container">
                                        <a href="#" class="btn-link"><i class="ti ti-plus f-16"></i>Log Measurement</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart__area">
                                <div id="bodyMeasurements_chart"></div>
                            </div>
                            <div class="history__area">
                                <h5>43 cm</h5>
                                <span>Apr , 09</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="progressPictures" role="tabpanel" aria-labelledby="progressPictures-tab">
                    <div class="timelapse-area">
                        <div class="gallery-title-head">
                            <h3>Timelapse</h3>
                            <div class="action-container">
                            <a href="#" class="btn-link bg-white txt-primary">Create Timelapse</a>
                            <a href="#" class="btn-link bg-white txt-primary">Comparison</a>
                            <a href="#" class="btn-link"><i class="ti ti-plus f-16"></i>Log Measurement</a>
                            </div>
                        </div>
                        <div class="gallery-grid">
                            <div class="gallery-item">
                            <img src="{{ asset(config('constants.admin_path').'/images/gallery.png')}}" alt="gallery">
                            </div>
                            <div class="gallery-item">
                            <img src="{{ asset(config('constants.admin_path').'/images/gallery.png')}}" alt="gallery">
                            </div>
                            <div class="gallery-item">
                            <img src="{{ asset(config('constants.admin_path').'/images/gallery.png')}}" alt="gallery">
                            </div>
                            <div class="gallery-item">
                            <img src="{{ asset(config('constants.admin_path').'/images/gallery.png')}}" alt="gallery">
                            </div>
                            <div class="gallery-item">
                            <img src="{{ asset(config('constants.admin_path').'/images/gallery.png')}}" alt="gallery">
                            </div>
                        </div>
                    </div>
                    <div class="gallery-area">
                        <div class="gallery-title-head">
                            <h3>Gallery</h3>
                        </div>
                        <div class="gallery-grid">
                            <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ asset(config('constants.admin_path').'/images/placeholder.svg')}}" alt="placeholder">
                            </div>
                            <div class="gallery-content">
                                <span class="date-txt">09 Apr , 2025</span>
                                <span class="weight-value">60.0 kg</span>
                            </div>
                            </div>
                            <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ asset(config('constants.admin_path').'/images/placeholder.svg')}}" alt="placeholder">
                            </div>
                            <div class="gallery-content">
                                <span class="date-txt">09 Apr , 2025</span>
                                <span class="weight-value">60.0 kg</span>
                            </div>
                            </div>
                            <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ asset(config('constants.admin_path').'/images/placeholder.svg')}}" alt="placeholder">
                            </div>
                            <div class="gallery-content">
                                <span class="date-txt">09 Apr , 2025</span>
                                <span class="weight-value">60.0 kg</span>
                            </div>
                            </div>
                            <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ asset(config('constants.admin_path').'/images/placeholder.svg')}}" alt="placeholder">
                            </div>
                            <div class="gallery-content">
                                <span class="date-txt">09 Apr , 2025</span>
                                <span class="weight-value">60.0 kg</span>
                            </div>
                            </div>
                            <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ asset(config('constants.admin_path').'/images/placeholder.svg')}}" alt="placeholder">
                            </div>
                            <div class="gallery-content">
                                <span class="date-txt">09 Apr , 2025</span>
                                <span class="weight-value">60.0 kg</span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                Settings
                </div>
                <div class="tab-pane" id="goals" role="tabpanel" aria-labelledby="goals-tab">
                    <div class="row goals-tabs">
                    <div class="title-head__box">
                        <div class="filter-box__area">
                            <div class="form-group">
                            <select class="form-control">
                                <option>All Time</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <div class="action-container">
                                <a href="javascript:void(0)" class="btn-link" data-bs-toggle="modal" data-bs-target="#goalModal"><i class="ti ti-plus f-16"></i>Create goal</a>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="your-achievements">
                            <div class="achievement-line">
                            <h4 class="head-title">Walking Every day</h4>
                            <div class="achievement-inner__box">
                                <div class="point">
                                    <h5>Current</h5>
                                    <div class="dot"></div>
                                    <div class="value">3000<br><span>Step</span></div>
                                </div>
                                <div class="point">
                                    <h5>Duration</h5>
                                    <div class="dot"></div>
                                    <div class="value">30<br><span>Days</span></div>
                                </div>
                                <div class="point">
                                    <h5>Target</h5>
                                    <div class="dot target">
                                    <span class="checkmark">✔</span>
                                    </div>
                                    <div class="value">10000<br><span>Step</span></div>
                                </div>
                            </div>
                            <div class="progress-bar__box">
                                <span class="title">Progress</span>
                                <div class="progress-bar">
                                    <div class="progress-bar__inner">78%</div>
                                </div>
                            </div>
                            </div>
                            <div class="achievement-line">
                            <h4 class="head-title">Walking Every day</h4>
                            <div class="achievement-inner__box">
                                <div class="point">
                                    <h5>Current</h5>
                                    <div class="dot"></div>
                                    <div class="value">3000<br><span>Step</span></div>
                                </div>
                                <div class="point">
                                    <h5>Duration</h5>
                                    <div class="dot"></div>
                                    <div class="value">30<br><span>Days</span></div>
                                </div>
                                <div class="point">
                                    <h5>Target</h5>
                                    <div class="dot target">
                                    <span class="checkmark">✔</span>
                                    </div>
                                    <div class="value">10000<br><span>Step</span></div>
                                </div>
                            </div>
                            <div class="progress-bar__box">
                                <span class="title">Progress</span>
                                <div class="progress-bar">
                                    <div class="progress-bar__inner">78%</div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="widget-card__item">
                            <div class="widget-title">
                            <a href="">
                                <h3>Total Goals</h3>
                                <img src="{{ asset(config('constants.admin_path').'/images/icons/chevron-right-w.svg')}}" alt="chevron-right">
                            </a>
                            </div>
                            <div class="widget-value">
                            <span>13</span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade client-measurement-modal" id="clientMeasurementModal" tabindex="-1" aria-labelledby="clientMeasurementModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="clientMeasurementModalLabel">Log Client Measurement</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<form>
				  <div class="row d-flex align-items-center mb-25">
				    <div class="col-lg-3">
					   <div class="form-label mb-0">
					     <label>date</label>
					   </div>
					</div>
                    <div class="col-lg-9">
					   <div class="form-input">
					     <input type="date" class="form-control date-inp" name="" id="">
					   </div>
					</div>
                  </div>
				  <div class="row">
				    <div class="col-lg-12">
					   <div class="form-group">
					     <label>Progress Picture</label>
						 <input type="file" class="form-control" name="" id="">
					   </div>
					</div>
                  </div>
				  <div class="row d-flex align-items-center border-sm mb-25">
				    <div class="col-lg-3">
					   <div class="form-label mb-0">
					     <label>Body Weight ( kg )</label>
					   </div>
					</div>
                    <div class="col-lg-9">
					   <div class="form-input">
					     <input type="text" class="form-control text-inp" name="" id="">
					   </div>
					</div>
                  </div>
                  <div class="row d-flex align-items-center border-sm mb-25">
				    <div class="col-lg-3">
					   <div class="form-label mb-0">
					     <label>Body Fat ( % )</label>
					   </div>
					</div>
                    <div class="col-lg-9">
					   <div class="form-input">
					     <input type="text" class="form-control text-inp" name="" id="">
					   </div>
					</div>
                  </div>
				  <div class="text-center">
				    <button type="submit" class="btn btn-submit btn-primary">Submit</button>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
		<!-- Goals Modal -->
		<div class="modal fade" id="goalModal" tabindex="-1" aria-labelledby="goalModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="goalModalLabel">Create a goal</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<form>
				  <div class="row">
				    <div class="col-lg-6 col-md-6 col-12">
					  <div class="form-group">
						<label for="weight">Weight</label>
						<select class="form-control" name="weight" id="weight">
						   <option>Select</option>
						</select>
					  </div>
					</div>
                    <div class="col-lg-6 col-md-6 col-12">
					  <div class="form-group">
						<label for="target">Target</label>
						<select class="form-control" name="target" id="target">
						   <option>Select</option>
						</select>
					  </div>
					</div>
                    <div class="col-lg-6 col-md-6 col-12">
					  <div class="form-group">
						<label for="body_fats">Body fats</label>
						<select class="form-control" name="body_fats" id="body_fats">
						   <option>Select</option>
						</select>
					  </div>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
					  <div class="form-group">
						<label for="target">Target</label>
						<select class="form-control" name="target" id="target">
						   <option>Select</option>
						</select>
					  </div>
					</div>
                    <div class="col-lg-6 col-md-6 col-12">
					  <div class="form-group">
						<label for="muscle">Muscle</label>
						<select class="form-control" name="muscle" id="muscle">
						   <option>Select</option>
						</select>
					  </div>
					</div>
                    <div class="col-lg-6 col-md-6 col-12">
					  <div class="form-group">
						<label for="target">Target</label>
						<select class="form-control" name="target" id="target">
						   <option>Select</option>
						</select>
					  </div>
					</div>
                    <div class="action-container text-end mb-4">
					  <a href="javascript:void(0)" class="btn-link"><i class="ti ti-plus f-16"></i>Add new muscle</a>
				    </div>
				    <div class="text-center">
					  <button type="submit" class="btn btn-submit">Submit</button>
				    </div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
        <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Settings</h5>
                <button type="button" class="btn btn-icon btn-link-danger ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="pct-body customizer-body">
                <div class="offcanvas-body py-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="pc-dark">
                                <h6 class="mb-1">Theme Mode</h6>
                                <p class="text-muted text-sm">Choose light or dark mode or Auto</p>
                                <div class="row theme-color theme-layout">
                                    <div class="col-4">
                                        <div class="d-grid">
                                            <button class="preset-btn btn active" data-value="true" onclick="layout_change('light');" data-bs-toggle="tooltip" title="Light">
                                                <svg class="pc-icon text-warning"><use xlink:href="#custom-sun-1"></use></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-grid">
                                            <button class="preset-btn btn" data-value="false" onclick="layout_change('dark');" data-bs-toggle="tooltip" title="Dark">
                                                <svg class="pc-icon"><use xlink:href="#custom-moon"></use></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-grid">
                                            <button
                                                class="preset-btn btn"
                                                data-value="default"
                                                onclick="layout_change_default();"
                                                data-bs-toggle="tooltip"
                                                title="Automatically sets the theme based on user's operating system's color scheme."
                                            >
                                                <span class="pc-lay-icon d-flex align-items-center justify-content-center"><i class="ph-duotone ph-cpu"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h6 class="mb-1">Theme Contrast</h6>
                            <p class="text-muted text-sm">Choose theme contrast</p>
                            <div class="row theme-contrast">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="true" onclick="layout_theme_contrast_change('true');" data-bs-toggle="tooltip" title="True">
                                            <svg class="pc-icon"><use xlink:href="#custom-mask"></use></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn active" data-value="false" onclick="layout_theme_contrast_change('false');" data-bs-toggle="tooltip" title="False">
                                            <svg class="pc-icon"><use xlink:href="#custom-mask-1-outline"></use></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h6 class="mb-1">Custom Theme</h6>
                            <p class="text-muted text-sm">Choose your primary theme color</p>
                            <div class="theme-color preset-color">
                                <a href="#!" data-bs-toggle="tooltip" title="Blue" class="active" data-value="preset-1"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Indigo" data-value="preset-2"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Purple" data-value="preset-3"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Pink" data-value="preset-4"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Red" data-value="preset-5"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Orange" data-value="preset-6"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Yellow" data-value="preset-7"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Green" data-value="preset-8"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Teal" data-value="preset-9"><i class="ti ti-checks"></i></a>
                                <a href="#!" data-bs-toggle="tooltip" title="Cyan" data-value="preset-10"><i class="ti ti-checks"></i></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h6 class="mb-1">Theme layout</h6>
                            <p class="text-muted text-sm">Choose your layout</p>
                            <div class="theme-main-layout d-flex align-center gap-1 w-100">
                                <a href="#!" data-bs-toggle="tooltip" title="Vertical" class="active" data-value="vertical"><img src="https://ableproadmin.com/assets/images/customizer/caption-on.svg" alt="img" class="img-fluid" /> </a>
                                <a href="#!" data-bs-toggle="tooltip" title="Horizontal" data-value="horizontal"><img src="https://ableproadmin.com/assets/images/customizer/horizontal.svg" alt="img" class="img-fluid" /> </a>
                                <a href="#!" data-bs-toggle="tooltip" title="Color Header" data-value="color-header"><img src="https://ableproadmin.com/assets/images/customizer/color-header.svg" alt="img" class="img-fluid" /> </a>
                                <a href="#!" data-bs-toggle="tooltip" title="Compact" data-value="compact"><img src="https://ableproadmin.com/assets/images/customizer/compact.svg" alt="img" class="img-fluid" /> </a>
                                <a href="#!" data-bs-toggle="tooltip" title="Tab" data-value="tab"><img src="https://ableproadmin.com/assets/images/customizer/tab.svg" alt="img" class="img-fluid" /></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h6 class="mb-1">Sidebar Caption</h6>
                            <p class="text-muted text-sm">Sidebar Caption Hide/Show</p>
                            <div class="row theme-color theme-nav-caption">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn-img btn active" data-value="true" onclick="layout_caption_change('true');" data-bs-toggle="tooltip" title="Caption Show">
                                            <img src="https://ableproadmin.com/assets/images/customizer/caption-on.svg" alt="img" class="img-fluid" />
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn-img btn" data-value="false" onclick="layout_caption_change('false');" data-bs-toggle="tooltip" title="Caption Hide">
                                            <img src="https://ableproadmin.com/assets/images/customizer/caption-off.svg" alt="img" class="img-fluid" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="pc-rtl">
                                <h6 class="mb-1">Theme Layout</h6>
                                <p class="text-muted text-sm">LTR/RTL</p>
                                <div class="row theme-color theme-direction">
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button class="preset-btn btn-img btn active" data-value="false" onclick="layout_rtl_change('false');" data-bs-toggle="tooltip" title="LTR">
                                                <img src="https://ableproadmin.com/assets/images/customizer/ltr.svg" alt="img" class="img-fluid" />
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button class="preset-btn btn-img btn" data-value="true" onclick="layout_rtl_change('true');" data-bs-toggle="tooltip" title="RTL">
                                                <img src="https://ableproadmin.com/assets/images/customizer/rtl.svg" alt="img" class="img-fluid" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item pc-box-width">
                            <div class="pc-container-width">
                                <h6 class="mb-1">Layout Width</h6>
                                <p class="text-muted text-sm">Choose Full or Container Layout</p>
                                <div class="row theme-color theme-container">
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button class="preset-btn btn-img btn active" data-value="false" onclick="change_box_container('false')" data-bs-toggle="tooltip" title="Full Width">
                                                <img src="https://ableproadmin.com/assets/images/customizer/full.svg" alt="img" class="img-fluid" />
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button class="preset-btn btn-img btn" data-value="true" onclick="change_box_container('true')" data-bs-toggle="tooltip" title="Fixed Width">
                                                <img src="https://ableproadmin.com/assets/images/customizer/fixed.svg" alt="img" class="img-fluid" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-grid"><button class="btn btn-light-danger" id="layoutreset">Reset Layout</button></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>

  client_image.onchange = evt => {
  const [file] = client_image.files
  if (file) {
    client_image_src.src = URL.createObjectURL(file)
  }
 }

</script>
@endsection
