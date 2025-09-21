@extends('vendor.layouts.app')
@section('title','SPLT | Profile')
@section('sub_title','Profile Management')
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
                            <li class="breadcrumb-item"><a href="{{route('vendor.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="edit_vendor" action="{{ route('vendor.update_password') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="form-group">
                            <label for="current_password">Old Password</label>
                            <input type="password" class="form-control" name="current_password" value="" id="current_password" autocomplete="off">
                            </div>
                            @if($errors->has('current_password'))
                            <p class="text-danger">{{ $errors->first('current_password') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" name="new_password" value="" id="new_password" autocomplete="off">
                            </div>
                            @if($errors->has('new_password'))
                            <p class="text-danger">{{ $errors->first('new_password') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" value="" id="confirm_password" autocomplete="off">
                            </div>
                            @if($errors->has('confirm_password'))
                            <p class="text-danger">{{ $errors->first('confirm_password') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-action__button">
                            <button type="submit" class="btn-link btn-dark" style="color:white" name="submit" value="Submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
