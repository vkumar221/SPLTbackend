@extends('trainer.layouts.app')
@section('title','SPLT | Clients')
@section('sub_title','Clients Management')
@section('import_export')
<li class="pc-h-item">

</li>
<li class="pc-h-item">

</li>
@endsection
@section('contents')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        @include('trainer.client.view_client_header')
        <!-- clients tabs -->
        <div class="clients-tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @include('trainer.client.client_tabs')
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="bodyMeasurements" role="tabpanel" aria-labelledby="bodyMeasurements-tab">
                    <div class="main-container">
                        <div class="sidebar">
                            <ul class="menu-list">
                                @foreach($body_parts as $body_part)
                                <li class="menu-item">
                                <a id="body_part_{{$body_part->body_part_id}}" onclick="change_part({{$body_part->body_part_id}});" class="menu-link @if($loop->iteration == 1) active @endif">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/z-icon.svg')}}" alt="{{$body_part->body_part_name}}"></span>
                                    <span class="menu-txt">{{$body_part->body_part_name}}</span>
                                </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="content-area" id="body_part_content">
                            <div class="title-head__box">
                                <h3>Abdomen</h3>
                                <div class="filter-box__area">
                                    <div class="form-group">
                                    {{-- <select class="form-control">
                                        <option>All Time</option>
                                    </select> --}}
                                    </div>
                                    <div class="form-group">
                                    <div class="action-container">
                                        <a href="javascript:void(0);" class="btn-link" onclick="log_measurement(1)"><i class="ti ti-plus f-16"></i>Log Measurement</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart__area">
                                <div id="bodyMeasurements_chart"></div>
                            </div>
                             @foreach($measurements as $measurement)
                            <div class="history__area">
                                <h5>{{$measurement->client_measurement}}</h5>
                                <span>{{date('M, d',strtotime($measurement->client_measurement_date))}}</span>
                            </div>
                             @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('trainer.client.client_modals')
    </div>
</div>
@endsection
@section('custom_script')
<script src="{{ asset(config('constants.admin_path').'js/plugins/apexcharts.min.js') }}"></script>
	<script>
    var options = {
      chart: {
        type: 'line',
        height: 400
      },
    series: [
        {
          name: 'Abdomen',
          data: @json($y),
        }
      ],
      xaxis: {
        categories:  @json($x)
      },
      colors: ['#008FFB'], // Blue, Yellow, Purple
      stroke: {
        width: 2
      },
      markers: {
        size: 0
      },
      legend: {
        position: 'bottom'
      }
    };

    var chart = new ApexCharts(document.querySelector("#bodyMeasurements_chart"), options);
    chart.render();
    </script>

    <script>
    $('.btn-toggle').on('click', function () {
        $('.dropdown-menu-custom').fadeToggle(150);
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.btn-toggle, .dropdown-menu-custom').length) {
        $('.dropdown-menu-custom').fadeOut(150);
        }
    });
    </script>
    <script>
        function change_part(id)
        {
            $('.menu-link').removeClass('active');
            $('#body_part_'+id).addClass('active');
            var client = "{{$client->client_id}}";

            var csrf = "{{ csrf_token() }}";
            $.ajax({
                url:"{{route('trainer.get-client-measurement')}}",
                type:"post",
                data:'_token='+csrf+'&body_part='+id+'&client='+client,
                success:function(data)
                {
                    $('#body_part_content').html(data);
                }

                });
        }
        function log_measurement(id)
        {
            $('#client_measurement_part').val(id);
            $('#logModal').modal('show');
        }
    </script>
@endsection

