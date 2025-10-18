@if($newsletters->count() > 0)
@foreach($newsletters as $newsletter)
    <div class="col-lg-6 col-md-6 col-12">
        <div class="newsletter-card">
        <div class="newsletter_img">
            <img src="{{ asset(config('constants.trainer_path').'uploads/newsletter/'.$newsletter->newsletter_image)}}" alt="newsletter-img">
        </div>
        <div class="newsletter-details">
            <div class="newsletter-title">
                <span>Newsletter :</span>
                <p>{{$newsletter->newsletter_title}}</p>
            </div>
            <div class="newsletter-title">
                <span>Date :</span>
                <p>{{$newsletter->newsletter_date}}</p>
            </div>
        </div>
        <div class="newsletter_actions">
                <a href="{{url('trainer/newsletter_delete/'.$newsletter->newsletter_id)}}"><span class="delete-icon"><img src="{{ asset(config('constants.admin_path').'images/icons/trash-blue.svg')}}" alt="delete"></span></a>
                {{-- <a href="#" class="send-again">Send Again</a> --}}
        </div>
        </div>
    </div>
    @endforeach
@else
<p class="text-center">No Newsletters Found</p>
@endif
