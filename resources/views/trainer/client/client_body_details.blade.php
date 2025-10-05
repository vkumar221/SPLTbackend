<div class="title-head__box">
    <h3>{{$body_parts->body_part_name}}</h3>
    <div class="filter-box__area">
        <div class="form-group">
        <select class="form-control">
            <option>All Time</option>
        </select>
        </div>
        <div class="form-group">
        <div class="action-container">
            <a href="javascript:void(0);" class="btn-link" onclick="log_measurement({{$body_parts->body_part_id}})"><i class="ti ti-plus f-16"></i>Log Measurement</a>
        </div>
        </div>
    </div>
</div>
@if($measurements->count() > 0)
<div class="chart__area">
    <div id="bodyMeasurements_chart"></div>
</div>
@endif
@foreach($measurements as $measurement)
<div class="history__area">
    <h5>{{$measurement->client_measurement}}</h5>
    <span>{{date('M, d',strtotime($measurement->client_measurement_date))}}</span>
</div>
@endforeach
@if($measurements->count() > 0)
<script src="{{ asset(config('constants.admin_path').'js/plugins/apexcharts.min.js') }}"></script>
	<script>
    var options = {
      chart: {
        type: 'line',
        height: 400
      },
      series: [
        {
          name: '{{$body_parts->body_part_name}}',
          data: @json($y)
        }
      ],
      xaxis: {
        categories:@json($x)
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
    @endif
