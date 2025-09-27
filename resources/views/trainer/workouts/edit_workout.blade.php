@extends('trainer.layouts.app')
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
                            <li class="breadcrumb-item"><a href="{{route('trainer.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Workout</a></li>
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
                <form id="add_workout" action="{{ route('trainer.edit-workout',['id'=>$workout->workout_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                     <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="workout_image">Workout Image</label><br>
                            <img id="workout_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'uploads/workout/'.$workout->workout_image)}}" alt="placeholder" width="68" height="68">
                            <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="workout_image" id="workout_image" class="custom-file-input">
                            </div>
                        </div>
                        @if($errors->has('workout_image'))
                            <p class="text-danger">{{ $errors->first('workout_image') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_name">Exercise Name</label>
                        <input type="text" class="form-control" name="workout_name" id="workout_name" value="{{$workout->workout_name}}" autocomplete="off">
                        @if($errors->has('workout_name'))
                        <p class="text-danger">{{ $errors->first('workout_name') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_type">Exercise Type</label>
                        <select class="form-control" name="workout_type" id="workout_type">
                            <option value="">Select...</option>
                            @foreach($exercise_types as $exercise_type)
                            <option value="{{$exercise_type->exercise_type_id}}" @if($workout->workout_type == $exercise_type->exercise_type_id) selected @endif>{{$exercise_type->exercise_type_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('workout_type'))
                        <p class="text-danger">{{ $errors->first('workout_type') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_equipment">Equipment</label>
                        <select class="form-control" name="workout_equipment" id="workout_equipment">
                            <option value="">Select...</option>
                            @foreach($equipments as $equipment)
                            <option value="{{$equipment->equipment_id}}" @if($workout->workout_equipment == $equipment->equipment_id) selected @endif>{{$equipment->equipment_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('workout_equipment'))
                        <p class="text-danger">{{ $errors->first('workout_equipment') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_muscle_group">Primary Muscle Group</label>
                        <select class="form-control" name="workout_muscle_group" id="workout_muscle_group">
                            <option value="">Select...</option>
                            @foreach($muscle_groups as $muscle_group)
                            <option value="{{$muscle_group->muscle_group_id}}" @if($workout->workout_muscle_group == $muscle_group->muscle_group_id) selected @endif>{{$muscle_group->muscle_group_name}}</option>
                            @endforeach
                        </select>
                         @if($errors->has('workout_muscle_group'))
                        <p class="text-danger">{{ $errors->first('workout_muscle_group') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_other_muscle">Other Muscles (optional)</label>
                        <select class="form-control" name="workout_other_muscle" id="workout_other_muscle">
                            <option value="">Select...</option>
                            @foreach($muscle_groups as $muscle_group)
                            <option value="{{$muscle_group->muscle_group_id}}" @if($workout->workout_other_muscle == $muscle_group->muscle_group_id) selected @endif>{{$muscle_group->muscle_group_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('workout_other_muscle'))
                        <p class="text-danger">{{ $errors->first('workout_other_muscle') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_category">Category</label>
                        <select class="form-control" name="workout_category" id="workout_category">
                            <option value="">Select...</option>
                            @foreach($workout_categories as $category)
                            <option value="{{$category->workout_category_id}}" @if($workout->workout_category == $category->workout_category_id) selected @endif>{{$category->workout_category_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('workout_category'))
                        <p class="text-danger">{{ $errors->first('workout_category') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_instruction">Exercise Instructions</label>
                        <textarea cols="5" rows="5" class="form-control" name="workout_instruction" id="workout_instruction" placeholder="Type some exercise instructions here... e.g. keep your back straight">{{$workout->workout_instruction}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                            <div class="upload-container">
                                <div class="youtube-input workout-inp">
                                    <input type="text" placeholder="Paste a Vimeo video link" name="workout_vimeo" id="workout_vimeo" value="{{$workout->workout_vimeo}}" autocomplete="off">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M9.58979 14.3034L8.41128 15.4819C6.7841 17.1091 4.14591 17.1091 2.51873 15.4819C0.891542 13.8547 0.891543 11.2165 2.51873 9.58931L3.69724 8.4108M14.3039 9.58931L15.4824 8.4108C17.1096 6.78362 17.1096 4.14543 15.4824 2.51824C13.8552 0.891056 11.217 0.891056 9.58979 2.51824L8.41128 3.69676M6.08387 11.9167L11.9172 6.08337" stroke="#9DA4AE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>

                                <div class="divider-or">or</div>

                                <div class="youtube-input workout-inp">
                                    <input type="text" placeholder="Paste a YouTube video link" name="workout_youtube" id="workout_youtube" value="{{$workout->workout_youtube}}" autocomplete="off">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M9.58979 14.3034L8.41128 15.4819C6.7841 17.1091 4.14591 17.1091 2.51873 15.4819C0.891542 13.8547 0.891543 11.2165 2.51873 9.58931L3.69724 8.4108M14.3039 9.58931L15.4824 8.4108C17.1096 6.78362 17.1096 4.14543 15.4824 2.51824C13.8552 0.891056 11.217 0.891056 9.58979 2.51824L8.41128 3.69676M6.08387 11.9167L11.9172 6.08337" stroke="#9DA4AE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </div>
                            </div>
                        </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('trainer.workouts')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
   workout_image.onchange = evt => {
  const [file] = workout_image.files
  if (file) {
    workout_image_src.src = URL.createObjectURL(file)
  }
 }
</script>
@endsection
