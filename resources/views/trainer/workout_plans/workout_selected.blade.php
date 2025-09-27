@foreach($excercises as $workout)
<div class="card col-md-4">
    <div class="exercise-item__box" id="workout_added_{{$workout->workout_id}}">
        <div class="exercise-img">
        <img src="{{ asset(config('constants.admin_path').'uploads/workout/'.$workout->workout_image)}}" alt="{{$workout->workout_name}}" width="100%">
        </div>
        <div class="exercise-title">
        <h5>{{$workout->workout_name}}</h5>
        <p>{{$workout->muscle_group_name}}</p>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removePlan({{$workout->workout_id}})">Remove</button>
    </div>
</div>
@endforeach
