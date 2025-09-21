@extends('admin.layouts.app')
@section('title',request()->settings->setting_name.' | Change Password')
@section('contents')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-4">
                        <h4 class="page-title">Profile</h4>
                    </div>
                    <div class="col-sm-8 text-sm-end">
                        <div class="head-icons">
                            <a href="{{ route('admin.change_password') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card settings-tab">
                <div class="card-body pb-0">
                    <div class="settings-menu">
                        <ul class="nav">
                            <li>
                                <a href="{{ route('admin.profile') }}">
                                    <i class="ti ti-settings-cog"></i> Profile Details
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.change_password') }}" class="active">
                                    <i class="ti ti-key"></i> Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="settings-header">
                                <h4>Change Password</h4>
                            </div>
                            <div class="settings-form">
                                <form id="change_password_form" action="{{ route('admin.update_password') }}" method="post">
                                    @csrf
                                    <div class="profile-details">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-wrap">
                                                    <label class="col-form-label">Current Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="current_password" id="current_password" class="form-control" value="{{ old('current_password') }}" autocomplete="off">
                                                    @if($errors->has('current_password'))
                                                    <div>{{ $errors->first('current_password') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-wrap">
                                                    <label class="col-form-label">New Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="new_password" id="new_password" class="form-control" value="{{ old('new_password') }}" autocomplete="off">
                                                    @if($errors->has('new_password'))
                                                    <div>{{ $errors->first('new_password') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-wrap">
                                                    <label class="col-form-label">Confirm Password  <span class="text-danger">*</span></label>
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="{{ old('confirm_password') }}" autocomplete="off">
                                                    @if($errors->has('confirm_password'))
                                                    <div>{{ $errors->first('confirm_password') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-button">
                                        <button type="submit" name="submit" class="btn btn-primary" value="submit">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection