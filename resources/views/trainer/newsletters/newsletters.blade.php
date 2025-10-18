@extends('trainer.layouts.app')
@section('title','SPLT | Newsletter')
@section('sub_title','Newsletter List')
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
<div class="pc-container trainer-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Newsletter List</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="table-right-box__info">
                        <div class="filter-box">
                            <select class="form-control" name="category" id="category" onchange="select_product();filter_newsletter();">
                            <option value="">Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->category_id}}" @if(old('newsletter_category') == $category->category_id) selected @endif>{{$category->category_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="filter-box">
                            <select class="form-control" name="product" id="product" onchange="filter_newsletter();">
                            <option value="">Product</option>
                            </select>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="action-container mt-2 mb-3">
                <a href="{{url('trainer/add_newsletter')}}" class="btn-newsletter"><i class="ti ti-plus f-16"></i> Write New Newsletter</a>
            </div>

            <div class="card bg-white border-0">
                <div class="card-body p-0">
                    <div class="row" id="newsletter_list">
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
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
    function filter_newsletter()
    {
        var csrf = "{{ csrf_token() }}";
        var category = $('#category').val();
        var product = $('#product').val();

       $.ajax({
            url:"{{route('trainer.filter-newsletters')}}",
            type:"post",
            data:'_token='+csrf+'&category='+category+'&product='+product,
            success:function(data){
                $('#newsletter_list').html(data);
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
   function select_product()
{
    var category = $('#category').val();
    var csrf = "{{ csrf_token() }}";

    if(category != "")
    {
        $.ajax({
            url:"{{route('trainer.select-product')}}",
            type:"post",
            data:'_token='+csrf+'&category='+category,
            success:function(data){
                $('#product').html(data);
            }
            });
    }
}


</script>
@endsection
