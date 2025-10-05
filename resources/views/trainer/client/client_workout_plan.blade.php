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
                <div class="tab-pane active show" id="workoutPlans" role="tabpanel" aria-labelledby="workoutPlans-tab">
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
            </div>
        </div>
        @include('trainer.client.client_modals')
    </div>
</div>
@endsection
