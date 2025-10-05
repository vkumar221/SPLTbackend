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
                <div class="tab-pane active show" id="goals" role="tabpanel" aria-labelledby="goals-tab">
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
        @include('trainer.client.client_modals')
    </div>
</div>
@endsection
