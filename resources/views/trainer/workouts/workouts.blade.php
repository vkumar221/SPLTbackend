@extends('trainer.layouts.app')
@section('title','SPLT | Exercise')
@section('sub_title','Exercise Library')
@section('import_export')
<li class="pc-h-item">
</li>
<li class="pc-h-item">
</li>
@endsection
@section('custom_style')
<link rel="stylesheet" href="{{ asset(config('constants.admin_path').'css/trainer.css')}}" />
<style>
.active1
{
    background-color: #303f5026;
}
</style>
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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Exercise Library</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
         <div class="workout-header">
                <div class="action-container">
                    <a href="{{url('trainer/add_workout')}}" class="btn-link" style="width:212px"><i class="ti ti-plus f-16"></i> Create New Workout</a>
                </div>
            </div>


        <div class="exercise-library">
            <div class="exercise-sidebar">
                <div class="exercise-filter__box">
                    <div class="form-group">
                        <select class="form-control text-center" id="exercise_type" onchange="filter_workout()">
                        <option value="">All Exercises</option>
                        @foreach($exercise_types as $exercise_type)
                        <option value="{{$exercise_type->exercise_type_id}}">{{$exercise_type->exercise_type_name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control text-center" id="category" onchange="filter_workout()">
                            <option value="">All Category</option>
                            @foreach($workout_categories as $category)
                            <option value="{{$category->workout_category_id}}">{{$category->workout_category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between gap-13">
                        <div class="form-group w-100">
                        <select class="form-control text-center" id="equipment" onchange="filter_workout()">
                            <option value="">All Equipment</option>
                            @foreach($equipments as $equipment)
                            <option value="{{$equipment->equipment_id}}">{{$equipment->equipment_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group w-100">
                        <select class="form-control text-center" id="muscle_group" onchange="filter_workout()">
                            <option value="">All Muscles</option>
                            @foreach($muscle_groups as $muscle_group)
                            <option value="{{$muscle_group->muscle_group_id}}">{{$muscle_group->muscle_group_name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="all-exercise">
                    <h4>All Exercises</h4>
                    <input type="hidden" name="exercises" id="exercises" value="">
                    <div id="workout_list">
                        @foreach($workouts as $workout)
                        <div class="exercise-item__box @if($loop->iteration == 1) active1 @endif" id="workout_{{$workout->workout_id}}" onclick="view_plan({{$workout->workout_id}})">
                            <div class="exercise-img">
                            <img src="{{ asset(config('constants.admin_path').'uploads/workout/'.$workout->workout_image)}}" alt="{{$workout->workout_name}}">
                            </div>
                            <div class="exercise-title">
                            <h5>{{$workout->workout_name}}</h5>
                            <p>{{$workout->muscle_group_name}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="exercise-content" style="background-color: white;">
                <div class="exercise-head__title">
                <h2>{{$workout_detail->workout_name}}</h2>
                </div>
                <div class="exercise-about__box">
                    <div class="exercise__info">
                    <h5>About</h5>
                    <ul class="info-list">
                        <li>
                        <span>Equipment:</span>
                        <p>{{$workout_detail->equipment_name}}</p>
                        </li>
                        <li>
                        <span>Primary Muscle Group:</span>
                        <p>{{$workout_detail->muscle_group_name}}</p>
                        </li>
                        <li>
                        <span>Exercise Type:</span>
                        <p>{{$workout_detail->exercise_type_name}}</p>
                        </li>
                    </ul>
                    </div>
                    <div class="exercise__img">
                    <img src="{{ asset(config('constants.admin_path').'uploads/workout/'.$workout_detail->workout_image)}}" alt="Bicep Curl">
                    </div>
                </div>
                @if($workout_detail->workout_instruction != NULL)
                <div class="exercise-instructions__box">
                    <div class="exercise__info">
                    <h5>Exercise Instructions</h5>
                    @php
                    $instructions = json_decode($workout_detail->workout_instruction,true);
                    @endphp
                    <ul class="info-list">
                        @foreach($instructions as $instruction)
                        <li>
                        <span class="num">{{$loop->iteration}}</span>
                        <p>{{$instruction}}</p>
                        </li>
                        @endforeach
                    </ul>
                    </div>
                </div>
                @endif
                <div class="exercise-attachment__box">
                    <h5>Attachment</h5>
                    <div class="attachment__box">
                    <span><img src="{{ asset(config('constants.admin_path').'images/icons/attachment.svg')}}" alt="attachment"></span>
                    @if($workout_detail->workout_vimeo == NULL && $workout_detail->workout_youtube == NULL)
                    <p>There is no attachment.</p>
                    @elseif($workout_detail->workout_vimeo != NULL)
                    <p><a href="{{$workout_detail->workout_vimeo}}" target="_blank"> Click to open.</a></p>
                    @elseif($workout_detail->workout_youtube != NULL)
                    <p><a href="{{$workout_detail->workout_youtube}}" target="_blank"> Click to open.</a></p>
                    @else
                    <p><a href="{{$workout_detail->workout_vimeo}}"> Click to open.</a></p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
    function filter_workout()
    {
        var csrf = "{{ csrf_token() }}";
        var exercise = $('#exercises').val();
        var exercise_type = $('#exercise_type').val();
        var equipment = $('#equipment').val();
        var muscle_group = $('#muscle_group').val();

       $.ajax({
            url:"{{route('trainer.filter-workouts')}}",
            type:"post",
            data:'_token='+csrf+'&exercises='+exercise+'&exercise_type='+exercise_type+'&equipment='+equipment+'&muscle_group='+muscle_group,
            success:function(data){
                $('#workout_list').html(data);
            }
            });

    }
   function view_plan(id)
   {
    var csrf = "{{ csrf_token() }}";

    $.ajax({
            url:"{{route('trainer.view-exercise')}}",
            type:"post",
            data:'_token='+csrf+'&exercise='+id,
            success:function(data){
                $('.exercise-item__box').removeClass('active1');
                $('#workout_'+id).addClass('active1');
                $('.exercise-content').html(data);
            }
            });
   }


</script>
@endsection
