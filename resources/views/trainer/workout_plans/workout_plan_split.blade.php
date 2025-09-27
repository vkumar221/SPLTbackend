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
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Split Library</a></li>
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
                        <a href="{{route('trainer.workout-plans')}}" class="tab-link">My Library</a>
                    </li>
                    <li class="tab-item">
                        <a href="{{route('trainer.workout-plan-split')}}" class="tab-link active">Split Library</a>
                    </li>
                    </ul>
                </div>
            </div>
            <div class="main-container">
                <div class="sidebar">
                    <h2>Categories</h2>
                    <ul class="menu-list">
                        <li class="menu-item">
                        <a href="#" class="menu-link active">
                            <span class="menu-txt font-size-16">All Programs</span>
                        </a>
                        </li>
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-txt font-size-16">Beginner</span>
                        </a>
                        </li>
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-txt font-size-16">Intermediate</span>
                        </a>
                        </li>
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-txt font-size-16">Advanced</span>
                        </a>
                        </li>
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-txt font-size-16">Muscle Growth</span>
                        </a>
                        </li>
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-txt font-size-16">Strength</span>
                        </a>
                        </li>
                        <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-txt font-size-16">Home Training</span>
                        </a>
                        </li>
                    </ul>
                </div>
                <div class="content-area">
                    <div class="my-library__grid">
                        @foreach($workout_plans as $workout)
                        <div class="my-library__item-box">
                            <div class="title-header">
                            <h3>{{$workout->workout_plan_name }}</h3>
                            <a href="#" class="download-btn"><img src="{{ asset(config('constants.admin_path').'images/icons/download-white.svg')}}" alt="download">Add to My Library</a>
                            </div>
                            <p>{{$workout->workout_plan_note}}
                            </p>
                            {{-- <ul class="my-library__list">
                            <li>Workout 1 - Push</li>
                            <li>Workout 2 - Pull</li>
                            <li>Workout 3 - Legs</li>
                            </ul> --}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

