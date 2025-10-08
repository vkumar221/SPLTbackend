<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('trainer.dashboard-page')}}">Home</a></li>
                    <li class="breadcrumb-item text-white">/</li>
                    <li class="breadcrumb-item"><a href="{{route('trainer.clients')}}">Clients</a></li>
                    <li class="breadcrumb-item text-white">/</li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Overview</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-lg-6 col-md-6 col-12">
        <div class="clients-info__box">
            <div class="clients_img">
            @if($user->image == NULL)
            <img src="{{ asset(config('constants.admin_path').'images/user-placeholder.png')}}" alt="user">
            @else
            <img src="{{ asset(config('constants.user_path').'uploads/profile/'.$user->image)}}" alt="user" width="100">
            @endif
            </div>
            <div class="clients_content">
            <h2>{{$user->fname.' '.$user->lname}}</h2>
            <span>{{$user->user_email}}</span>
            <p>Hasn't worked out yet</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="action-container">
            <a href="" class="btn-link"><img src="{{ asset(config('constants.admin_path').'/images/icons/log.svg')}}" alt="log">Log Workout</a>
            <a href="" class="btn-link"><img src="{{ asset(config('constants.admin_path').'/images/icons/send-msg.svg')}}" alt="send-msg">Send Message</a>
            <a href="javascript:void(0)" class="btn-toggle"><img src="{{ asset(config('constants.admin_path').'/images/icons/toggle.svg')}}" alt="toggle"></a>
            <!-- Dropdown Menu -->
            <div class="dropdown-menu-custom">
            <div class="arrow-up"></div>
            <ul>
                <li><a href="#" data-bs-toggle="modal" data-bs-target="#clientMeasurementModal"><img src="{{ asset(config('constants.admin_path').'/images/icons/mes-icon.svg')}}" alt=""> Log Measurement</a></li>
                <li><a href="#"><img src="{{ asset(config('constants.admin_path').'/images/icons/remove-icon.svg')}}" alt=""> Remove Client</a></li>
            </ul>
            </div>
        </div>
    </div>
</div>
