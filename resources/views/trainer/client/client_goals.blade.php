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
                            @foreach($goals as $goal)
                            <div class="achievement-line">
                                <h4 class="head-title">{{$goal->user_goal_name}}</h4>
                                <div class="achievement-inner__box">
                                    <div class="point">
                                        <h5>Current</h5>
                                        <div class="dot"></div>
                                        <div class="value">{{$goal->user_goal_weight}}<br><span>KG</span></div>
                                    </div>
                                    <div class="point">
                                        <h5>Duration</h5>
                                        <div class="dot"></div>
                                        <div class="value">{{$goal->user_goal_duration}}<br><span>Days</span></div>
                                    </div>
                                    <div class="point">
                                        <h5>Target</h5>
                                        <div class="dot target">
                                        <span class="checkmark">✔</span>
                                        </div>
                                        <div class="value">{{$goal->user_goal_weight_target}}<br><span>KG</span></div>
                                    </div>
                                </div>
                                <div class="progress-bar__box">
                                    <span class="title">Progress</span>
                                    <div class="progress-bar">
                                        <div class="progress-bar__inner" style="width:0%">0%</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
                            <span>{{$goals->count()}}</span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="goalModal" tabindex="-1" aria-labelledby="goalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="goalModalLabel">Create a goal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="client_goals" action="{{url('trainer/add_client_goal/'.$user->id)}}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-12">
                        <div class="form-group">
                        <label for="user_goal_name">Goal Name</label>
                        <input type="text" class="form-control" name="user_goal_name" id="user_goal_name" value="{{old('user_goal_name')}}" autocomplete="off">
                        </div>
                        @if($errors->has('user_goal_name'))
                        <p class="text-danger">{{ $errors->first('user_goal_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="user_goal_type">Goal Type</label>
                        <select class="form-control" name="user_goal_type" id="user_goal_type">
                            <option>Select</option>
                            @foreach($goal_types as $goal_type)
                            <option value="{{$goal_type->goal_type_id}}">{{$goal_type->goal_type_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @if($errors->has('user_goal_type'))
                        <p class="text-danger">{{ $errors->first('user_goal_type') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="user_goal_duration">Goal Duration</label>
                         <select class="form-control" name="user_goal_duration" id="user_goal_duration">
                            <option>Select</option>
                            @for($i=1;$i<=30;$i++)
                            <option value="{{$i}}">{{$i}} Days</option>
                            @endfor
                        </select>
                        </div>
                        @if($errors->has('user_goal_duration'))
                        <p class="text-danger">{{ $errors->first('user_goal_duration') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="weight">Weight</label>
                        <select class="form-control" name="user_goal_weight" id="user_goal_weight">
                            <option>Select</option>
                            @for($i=20;$i<=150;$i++)
                            <option value="{{$i}}">{{$i}} KG</option>
                            @endfor
                        </select>
                        @if($errors->has('user_goal_weight'))
                        <p class="text-danger">{{ $errors->first('user_goal_weight') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="target">Target</label>
                        <select class="form-control" name="user_goal_weight_target" id="user_goal_weight_target">
                            <option>Select</option>
                            @for($i=20;$i<=150;$i++)
                            <option value="{{$i}}">{{$i}} KG</option>
                            @endfor
                        </select>
                        @if($errors->has('user_goal_weight_target'))
                        <p class="text-danger">{{ $errors->first('user_goal_weight_target') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="body_fats">Body fats</label>
                        <input type="text" class="form-control" name="user_goal_fat" id="user_goal_fat" value="{{old('user_goal_fat')}}" autocomplete="off">
                        @if($errors->has('user_goal_fat'))
                        <p class="text-danger">{{ $errors->first('user_goal_fat') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control" name="user_goal_fat_target" id="user_goal_fat_target" value="{{old('user_goal_fat_target')}}" autocomplete="off">
                        @if($errors->has('user_goal_fat_target'))
                        <p class="text-danger">{{ $errors->first('user_goal_fat_target') }}</p>
                        @endif
                    </div>
                    </div>
                </div>
                <div class="row" id="new_muscle">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="muscle">Muscle</label>
                        <select class="form-control" name="user_goal_muscle[1]" id="user_goal_muscle_1">
                            <option>Select</option>
                            @foreach($muscle_groups as $muscle_group)
                            <option id="{{$muscle_group->muscle_group_id}}">{{$muscle_group->muscle_group_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user_goal_muscle'))
                        <p class="text-danger">{{ $errors->first('user_goal_muscle') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="target">Current</label>
                        <input type="text" class="form-control" name="user_goal_muscle_current[1]" id="user_goal_muscle_current_1" value="" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control" name="user_goal_muscle_target[1]" id="user_goal_fat_target_1" value="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="action-container text-end mb-4">
                        <a href="javascript:void(0)" class="btn-link" onclick="add_workout();"><i class="ti ti-plus f-16"></i>Add new muscle</a>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-submit" name="submit" value="submit">Submit</button>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
var i = 2;
function add_workout()
{
    
    $('#new_muscle').append('<div class="col-lg-4 col-md-4 col-12"><div class="form-group"><label for="muscle">Muscle</label><select class="form-control" name="user_goal_muscle['+i+']" id="user_goal_muscle_'+i+'"><option>Select</option>@foreach($muscle_groups as $muscle_group)<option id="{{$muscle_group->muscle_group_id}}">{{$muscle_group->muscle_group_name}}</option>@endforeach</select></div></div><div class="col-lg-4 col-md-4 col-12"><div class="form-group"><label for="target">Current</label><input type="text" class="form-control" name="user_goal_muscle_current['+i+']" id="user_goal_muscle_current_'+i+'" value="" autocomplete="off"></div></div><div class="col-lg-4 col-md-4 col-12"><div class="form-group"><label for="target">Target</label><input type="text" class="form-control" name="user_goal_muscle_target['+i+']" id="user_goal_fat_target_'+i+'" value="" autocomplete="off"></div></div>')

}
</script>
@endsection