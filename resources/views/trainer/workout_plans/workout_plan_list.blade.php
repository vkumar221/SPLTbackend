@if($workout_plans->count() > 0)
@foreach($workout_plans as $workout)
<div class="my-library__item-box">
    <div class="title-header">
    <h3>{{$workout->workout_plan_name }}</h3>
    <a href="#" class="download-btn"><img src="{{ asset(config('constants.admin_path').'images/icons/download-white.svg')}}" alt="download">Add to My Library</a>
    </div>
    <p>{{$workout->workout_plan_note}}
    </p>
    {{-- <ul class="my-library__list">
    <li>Workout 1 - Push</li>
    <li>Workout 2 - Pull</li>
    <li>Workout 3 - Legs</li>
    </ul> --}}
</div>
@endforeach
@else
<p class="text-center">No Plans Found</p>
@endif
