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
                 <div class="tab-pane active show" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <form id="client_update" action="{{url('trainer/client_update/'.$user->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" name="fname" value="{{$user->fname}}" id="fname" autocomplete="off">
                                </div>
                                @if($errors->has('fname'))
                                <p class="text-danger">{{ $errors->first('fname') }}</p>
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" name="lname" value="{{$user->lname}}" id="lname" autocomplete="off">
                                </div>
                                @if($errors->has('lname'))
                                <p class="text-danger">{{ $errors->first('lname') }}</p>
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{$user->phone}}" id="phone" autocomplete="off">
                                </div>
                                @if($errors->has('phone'))
                                <p class="text-danger">{{ $errors->first('phone') }}</p>
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" value="{{$user->email}}" id="email" autocomplete="off">
                                </div>
                                @if($errors->has('email'))
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-4">
                            <h4>Measurements</h4>
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="form-group">
                                <label for="trainer_name">Weight</label>
                                <input type="text" class="form-control" name="weight" value="{{$user->weight}}" id="weight" autocomplete="off">
                                </div>
                                @if($errors->has('weight'))
                                <p class="text-danger">{{ $errors->first('weight') }}</p>
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="form-group">
                                <label for="height">Height</label>
                                <input type="text" class="form-control" name="height" value="{{$user->height}}" id="height" autocomplete="off">
                                </div>
                                @if($errors->has('height'))
                                <p class="text-danger">{{ $errors->first('height') }}</p>
                                @endif
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 mt-4">
                                <div class="form-action__button">
                                <button type="submit" class="btn-link btn-dark" style="color:white" name="submit" value="Submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('trainer.client.client_modals')
    </div>
</div>
@endsection
