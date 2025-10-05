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
                <div class="tab-pane active show" id="advancedStatistics" role="tabpanel" aria-labelledby="advancedStatistics-tab">
                    <div class="main-container">
                        <div class="sidebar">
                            <ul class="menu-list">
                                <li class="menu-item">
                                <a href="#" class="menu-link active">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/group.svg')}}" alt="Muscle Group"></span>
                                    <span class="menu-txt">Set Count Per Muscle Group</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/duration.svg')}}" alt="duration"></span>
                                    <span class="menu-txt">Duration</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/volume.svg')}}" alt="volume"></span>
                                    <span class="menu-txt">Volume</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <span class="menu-icon"><img src="{{ asset(config('constants.admin_path').'/images/icons/sets.svg')}}" alt="sets"></span>
                                    <span class="menu-txt">Sets</span>
                                </a>
                                </li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <div class="title-head__box">
                                <h3>Set Count Per Muscle Group</h3>
                                <div class="filter-box__area">
                                    <div class="form-group">
                                    <select class="form-control">
                                        <option>Week</option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                    <select class="form-control">
                                        <option>Last 3 months</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="chart__area">
                                <div id="chart"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                    <tr>
                                        <th scope="col">Muscle group</th>
                                        <th scope="col" class="text-end">Sets: January 12 - April 9</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="checked-row">
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_1" checked>
                                            <label for="check_1" class="form-check-label">Shoulders</label>
                                        </div>
                                        </td>
                                        <td class="text-end">2</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_2">
                                            <label for="check_2" class="form-check-label">Abdominals</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_3">
                                            <label for="check_3" class="form-check-label">Abductors</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_4">
                                            <label for="check_4" class="form-check-label">Adductors</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr class="checked-row">
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_5" checked>
                                            <label for="check_5" class="form-check-label">Biceps</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_6">
                                            <label for="check_6" class="form-check-label">Lower Back</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_7">
                                            <label for="check_7" class="form-check-label">Upper Back</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_8">
                                            <label for="check_8" class="form-check-label">Cardio</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr class="checked-row">
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_9" checked>
                                            <label for="check_9" class="form-check-label">Chest</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_10">
                                            <label for="check_10" class="form-check-label">Calves</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_11">
                                            <label for="check_11" class="form-check-label">Forearms</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_12">
                                            <label for="check_12" class="form-check-label">Glutes</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_13">
                                            <label for="check_13" class="form-check-label">Hamstrings</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_14">
                                            <label for="check_14" class="form-check-label">Lats</label>
                                        </div>
                                        </td>
                                        <td class="text-end">0</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
		// Shared chart options
		const sharedOptions = {
		  chart: {
			type: 'line',
			height: 120,
			sparkline: {
			  enabled: true
			}
		  },
		  stroke: {
			width: 2,
			curve: 'smooth'
		  },
		  tooltip: {
			enabled: false
		  },
		  colors: ['#4F46E5'], // purple theme
		};

		// Duration Chart
		const durationChart = new ApexCharts(document.querySelector("#durationChart"), {
		  ...sharedOptions,
		  series: [{
			name: 'Duration',
			data: [0, 0, 0, 0, 0]
		  }]
		});
		durationChart.render();

		// Volume Chart
		const volumeChart = new ApexCharts(document.querySelector("#volumeChart"), {
		  ...sharedOptions,
		  series: [{
			name: 'Volume',
			data: [0, 0, 0, 0, 0]
		  }]
		});
		volumeChart.render();

		// Set Chart
		const setChart = new ApexCharts(document.querySelector("#setChart"), {
		  ...sharedOptions,
		  series: [{
			name: 'Set',
			data: [0, 0, 0, 0, 0]
		  }]
		});
		setChart.render();
	  </script>

	  <script>
    var options = {
      chart: {
        type: 'line',
        height: 400
      },
      series: [
        {
          name: 'Shoulders',
          data: [
            0.2, 0.3, 0.6, 0.8, 0.5, 0.9, 0.7, 1.6, 0.6, 0.9, 1.1, 0.3,
            0.2, 0.5, 0.8, 1.1, 0.2, 0.6, 0.7, 1.4, 1.1, 1.0, 0.8, 1.0
          ]
        },
        {
          name: 'Biceps',
          data: Array(24).fill(0)
        },
        {
          name: 'Chest',
          data: Array(24).fill(0)
        }
      ],
      xaxis: {
        categories: [
          'Jan 12', 'Jan 15', 'Jan 19', 'Jan 22', 'Jan 26', 'Jan 30',
          'Feb 2', 'Feb 5', 'Feb 9', 'Feb 12', 'Feb 16', 'Feb 19',
          'Feb 23', 'Feb 26', 'Mar 2', 'Mar 5', 'Mar 9', 'Mar 12',
          'Mar 16', 'Mar 19', 'Mar 23', 'Mar 26', 'Mar 30', 'Apr 2'
        ]
      },
      colors: ['#008FFB', '#FEB019', '#775DD0'], // Blue, Yellow, Purple
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

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
    </script>

	<script>
    var options = {
      chart: {
        type: 'line',
        height: 400
      },
      series: [
        {
          name: 'Shoulders',
          data: [
            0.2, 0.3, 0.6, 0.8, 0.5, 0.9, 0.7, 1.6, 0.6, 0.9, 1.1, 0.3,
            0.2, 0.5, 0.8, 1.1, 0.2, 0.6, 0.7, 1.4, 1.1, 1.0, 0.8, 1.0
          ]
        },
        {
          name: 'Biceps',
          data: Array(24).fill(0)
        },
        {
          name: 'Chest',
          data: Array(24).fill(0)
        }
      ],
      xaxis: {
        categories: [
          'Jan 12', 'Jan 15', 'Jan 19', 'Jan 22', 'Jan 26', 'Jan 30',
          'Feb 2', 'Feb 5', 'Feb 9', 'Feb 12', 'Feb 16', 'Feb 19',
          'Feb 23', 'Feb 26', 'Mar 2', 'Mar 5', 'Mar 9', 'Mar 12',
          'Mar 16', 'Mar 19', 'Mar 23', 'Mar 26', 'Mar 30', 'Apr 2'
        ]
      },
      colors: ['#008FFB', '#FEB019', '#775DD0'], // Blue, Yellow, Purple
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
@endsection

