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
    <p><a href="{{$workout_detail->workout_vimeo}}"> Click to open.</a></p>
    @elseif($workout_detail->workout_youtube != NULL)
    <p><a href="{{$workout_detail->workout_youtube}}"> Click to open.</a></p>
    @else
    <p><a href="{{$workout_detail->workout_vimeo}}"> Click to open.</a></p>
    @endif
    </div>						 
</div>