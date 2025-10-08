<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'overview') active @endif" href="{{url('trainer/view_client/'.$user->id)}}">Overview</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'workout_plan') active @endif" href="{{url('trainer/client_workout_plan/'.$user->id)}}">Workout Plans</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'exercise_statics') active @endif" href="{{url('trainer/client_exercise_statics/'.$user->id)}}">Exercise Statistics</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'advanced_statics') active @endif" href="{{url('trainer/client_advanced_statics/'.$user->id)}}">Advanced Statistics</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'body_measurement') active @endif" href="{{url('trainer/client_body_measurement/'.$user->id)}}">Body Measurements</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'progress_picture') active @endif" href="{{url('trainer/client_progress_picture/'.$user->id)}}">Progress Pictures</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'client_settings') active @endif" href="{{url('trainer/client_settings/'.$user->id)}}">Settings</a>
</li>
<li class="nav-item" role="presentation">
    <a class="nav-link @if(isset($sub_set) && $sub_set == 'client_goals') active @endif" href="{{url('trainer/client_goals/'.$user->id)}}">Goals</a>
</li>
