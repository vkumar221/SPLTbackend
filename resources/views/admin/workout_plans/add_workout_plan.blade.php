@extends('admin.layouts.app')
@section('title','SPLT | Workouts')
@section('sub_title','Workouts')
@section('import_export')
<li class="pc-h-item">
</li>
<li class="pc-h-item">
</li>
@endsection
@section('custom_style')
<link rel="stylesheet" href="{{ asset(config('constants.admin_path').'css/trainer.css')}}" />
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Workout Plan</a></li>
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
                <form id="add_workout" action="{{ route('admin.add-workout-plan') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
				      <div class="col-lg-12 col-md-12 col-12">
					     <div class="form__Area">
						    <div class="row">
							   <div class="col-lg-12">
							      <div class="form-group mb-4">
								     <label class="mb-2">Workout Program Title</label>
									 <input type="text" class="form-control" name="workout_plan_name" id="workout_plan_name" value="{{old('workout_plan_name')}}" autocomplete="off">
                                     @if($errors->has('workout_plan_name'))
                                    <p class="text-danger">{{ $errors->first('workout_plan_name') }}</p>
                                    @endif
								  </div>
							   </div>
							   <div class="col-lg-6">
							      <div class="form-group mb-4">
								     <label class="mb-2">Program Duration</label>
									 <input type="text" class="form-control" name="workout_plan_duration" id="workout_plan_duration" value="{{old('workout_plan_duration')}}" autocomplete="off">
                                     @if($errors->has('workout_plan_duration'))
                                    <p class="text-danger">{{ $errors->first('workout_plan_duration') }}</p>
                                    @endif
								  </div>
							   </div>
                               <div class="col-lg-6">
							      <div class="form-group mb-4">
								     <label class="mb-2">Main Goal</label>
									 <input type="text" class="form-control" name="workout_plan_goal" id="workout_plan_goal	" value="{{old('workout_plan_goal')}}" autocomplete="off">
                                     @if($errors->has('workout_plan_goal'))
                                    <p class="text-danger">{{ $errors->first('workout_plan_goal') }}</p>
                                    @endif
								  </div>
							   </div>
                               <div class="col-lg-6">
							      <div class="form-group mb-4">
								     <label class="mb-2">Days / Weeks</label>
									 <input type="text" class="form-control" name="workout_plan_days" id="workout_plan_days" value="{{old('workout_plan_days')}}" autocomplete="off">
                                     @if($errors->has('workout_plan_days'))
                                    <p class="text-danger">{{ $errors->first('workout_plan_days') }}</p>
                                    @endif
								  </div>
							   </div>
                               <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                    <label for="workout_category">Category</label>
                                    <select class="form-control" name="workout_plan_category" id="workout_plan_category">
                                        <option value="">Select Category</option>
                                        @foreach($workout_categories as $category)
                                        <option value="{{$category->workout_category_id}}" @if(old('workout_plan_category') == $category->workout_category_id) selected @endif>{{$category->workout_category_name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('workout_plan_category'))
                                    <p class="text-danger">{{ $errors->first('workout_plan_category') }}</p>
                                    @endif
                                    </div>
                                </div>
							   <div class="col-lg-12">
							      <div class="form-group mb-4">
								     <label class="mb-2">Program Note</label>
									 <textarea rows="3" class="form-control" name="workout_plan_note" id="workout_plan_note">{{old('workout_plan_note')}}</textarea>
								  </div>
							   </div>
							</div>
						 </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="summary-panel">
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
                                            <div class="exercise-item__box" id="workout_{{$workout->workout_id}}">
                                                <div class="exercise-img">
                                                <img src="{{ asset(config('constants.admin_path').'uploads/workout/'.$workout->workout_image)}}" alt="{{$workout->workout_name}}">
                                                </div>
                                                <div class="exercise-title">
                                                <h5>{{$workout->workout_name}}</h5>
                                                <p>{{$workout->muscle_group_name}}</p>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addToPlan({{$workout->workout_id}})">Add</button>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
					        <div class="row">
							   <div class="col-lg-8">
							      <label class="mb-2">Selected Workouts</label>
                                     <div id="workout_list_selected" class="row">
                                     </div>
							   </div>
							</div>
                      </div>
                      <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.workout-plans')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
            url:"{{route('admin.filter-workout')}}",
            type:"post",
            data:'_token='+csrf+'&exercises='+exercise+'&exercise_type='+exercise_type+'&equipment='+equipment+'&muscle_group='+muscle_group,
            success:function(data){
                $('#workout_list').html(data);
            }
            });

    }
   function addToPlan(id)
   {
    var csrf = "{{ csrf_token() }}";
    var exercise = $('#exercises').val();

    if(exercise == '')
    {
        exercise = id+',';
    }
    else
    {
        exercise = exercise+id+',';
    }

    $('#exercises').val(exercise);

    if(exercise != "")
    {
        $.ajax({
            url:"{{route('admin.add-to-plan')}}",
            type:"post",
            data:'_token='+csrf+'&exercises='+exercise,
            success:function(data){
                $('#workout_'+id).hide();
                $('#workout_list_selected').html(data);
            }
            });
    }
   }

   function removePlan(id)
   {
    let originalText = $('#exercises').val();
    let updatedText = originalText.replace(id+',','');
    $('#exercises').val(updatedText);

    $('#workout_'+id).show();
    $('#workout_added_'+id).remove();
   }

</script>
@endsection
