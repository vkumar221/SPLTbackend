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
                <div class="tab-pane active show" id="progressPictures" role="tabpanel" aria-labelledby="progressPictures-tab">
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
            </div>
        </div>
        @include('trainer.client.client_modals')
    </div>
</div>
@endsection
