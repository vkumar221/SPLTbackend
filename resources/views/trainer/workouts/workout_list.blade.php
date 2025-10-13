@if($excercises->count() > 0)
@foreach($excercises as $workout)
<div class="exercise-item__box" id="workout_{{$workout->workout_id}}" onclick="view_plan({{$workout->workout_id}})">
    <div class="exercise-img">
    <img src="{{ asset(config('constants.admin_path').'uploads/workout/'.$workout->workout_image)}}" alt="{{$workout->workout_name}}">
    </div>
    <div class="exercise-title">
    <h5>{{$workout->workout_name}}</h5>
    <p>{{$workout->muscle_group_name}}</p>
    </div>
</div>
@endforeach
@else
<p class="text-center">No Exercise Found</p>
@endif
