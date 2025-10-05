@extends('trainer.layouts.app')
@section('title','SPLT | Workouts')
@section('sub_title','Workouts')
@section('import_export')
<li class="pc-h-item">
    <a href="#" class="pc-head-btn me-3">
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/export-icon.svg')}}" alt="export-icon.svg"></span>
        <span>Export</span>
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/chevron-down.svg')}}" alt="chevron-down.svg"></span>
    </a>
</li>
<li class="pc-h-item">
    <a href="#" class="pc-head-btn me-3">
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/import-icon.svg')}}" alt="import-icon.svg"></span>
        <span>Import</span>
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/chevron-down.svg')}}" alt="chevron-down.svg"></span>
    </a>
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
                            <li class="breadcrumb-item">/</li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Workout Plans</a></li>
                            <li class="breadcrumb-item">/</li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">My Library</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="workout-plans">
            <div class="workout-header">
                <div class="workout-tabs">
                    <ul class="tab-list">
                    <li class="tab-item">
                        <a href="{{route('trainer.workout-plans')}}" class="tab-link active">My Library</a>
                    </li>
                    <li class="tab-item">
                        <a href="{{route('trainer.workout-plan-split')}}" class="tab-link">Split Library</a>
                    </li>
                    </ul>
                </div>
                <div class="action-container">
                    <a href="{{route('trainer.add-workout-plan-page')}}" class="btn-link"><img src="{{ asset(config('constants.admin_path').'images/icons/files.svg')}}" alt="Workout Plans"> New Program</a>
                    <a href="{{route('trainer.add-workout-page')}}" class="btn-link" style="width:212px"><i class="ti ti-plus f-16"></i> Create New Workout</a>
                </div>
            </div>
            <div class="workout-plans__content-box">
                <div class="title-box">
                    <img src="{{ asset(config('constants.admin_path').'images/icons/files-b.svg')}}" alt="Workout Plans">
                    <h2>My Workout Plans</h2>
                    <span class="count">{{$my_workout_plans->count()}}</span>
                </div>
                <div class="workout-plans-grid">
                    @if($my_workout_plans->count() > 0)
                    @foreach($my_workout_plans as $plan)
                    <div class="workout-plans__item-box">
                        <div class="workout-plan-content">
                        <h3>{{$plan->workout_plan_name}}</h3>
                        <p>{{$plan->workout_category_name}}</p>
                        <p>@if(isset($excersises[$plan->workout_plan_id])){{count($excersises[$plan->workout_plan_id])}} Exersises @endif</p>
                        </div>
                        <div class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset(config('constants.admin_path').'images/icons/toggle.svg')}}" alt="toggle"></a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            {{-- <a href="#!" class="dropdown-item">Copy Program to Clients</a> --}}
                            @if($plan->workout_plan_added_role == 3 && $plan->workout_plan_added_by == Auth::guard('trainer')->user()->trainer_id)
                            <a href="{{url('trainer/edit_workout_plan/'.$plan->workout_plan_id )}}" class="dropdown-item text-dark">Edit Program</a>
                            @endif
                            {{-- <a href="#!" class="dropdown-item">Duplicate Program</a>
                            <a href="#!" class="dropdown-item">Move To Folder</a> --}}
                            <a href="{{url('trainer/delete_library/'.$plan->workout_plan_id )}}" class="dropdown-item">Delete Program</a>
                        </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="workout-plans__item-box">
                        <div class="workout-plan-content">
                            <p>No Plans</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
</div>
@endsection

