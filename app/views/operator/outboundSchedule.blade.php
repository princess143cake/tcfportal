@extends('layouts.default')

@section('title'){{ 'Outbound Schedule' }}@stop

@section('custom-css')
	<style type="text/css">
		.point {
			cursor: pointer !important;
		}
		.outbound-box {
			border: 1px solid #9C9C9C;
			padding: 10px;
		}

		h5 {
			font-weight: 700;
		}
	</style>
@stop

@section('content')

	<div class="row" style="min-width: 100%;">
		<div class="column small-12">
			{{-- <a href="{{ URL::to('fs/outbound?d='.date('Y-m-d', strtotime($date))) }}">View full screen display</a> --}}
			<div class="column small-12 light-box margin-top-20">
				<span>Outbound Daily Schedule</span>
				@if ($date == date('l F j, Y') || strtotime($date) > strtotime(date('l F j, Y')))
					<a href="#" class="right" data-reveal-id="first_outbound_modal"><i class="fa fa-plus"></i> Create New Route</a>
				@endif
				<span id="date-text"> - {{ $date }} &nbsp;<a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>
			</div>


			@foreach ($outbounds as $row)
				<div class="large-12 column outbound-box margin-top-20">
					<div class="large-3 column">
						<h5>Route</h5>
						<span class="route-text">Carrier: {{ $row->outbound_carrier }}</span>						
						<span class="route-text">Driver: {{ $row->outbound_driver }}</span>						
						<span class="route-text">Truck: {{ $row->outbound_truck }}</span>						
						<span class="route-text">Start Time: {{ $row->outbound_start_time ? date('h:i a', $row->outbound_start_time) : '' }}</span>
						<span class="route-text">Region: {{ $row->outbound_region }}</span>
						<span>Options: </span><a title="Edit Route" class="route-text edit-route-btn" style="display: inline" data-reveal-id="edit_route_modal" data-id="{{ $row->id }}" href="#"><i class="fa fa-pencil"></i> </a>
						<a title="Delete Route" class="route-text delete-route-btn" style="display: inline; color: #FF6A6A" data-id="{{ $row->id }}" href="#"><i class="fa fa-times"></i> </a>
					</div>

					<div class="large-9 column">
						<h5>Stops <a href="#" data-id="{{ $row->id }}" style="font-weight: 400;font-size: 0.9rem;" class="right create-stop-btn" data-reveal-id="new_stop_modal">Create new stop</a></h5>
						@if ($row->secondphase->toArray())
							<table class="tcf-table">
								<thead>
									<tr>
										<th class="point" data-sort="int">Dock Time <i class="fa fa-sort"></i></th>	
										<th class="point" data-sort="string">Customer <i class="fa fa-sort"></i></th>	
										<th class="point" data-sort="string">Location <i class="fa fa-sort"></i></th>	
										<th class="point" data-sort="int">Order No. <i class="fa fa-sort"></i></th>	
										<th class="point" data-sort="int">Skids <i class="fa fa-sort"></i></th>	
										<th class="point" data-sort="string">Pick Status <i class="fa fa-sort"></i></th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($row->secondphase as $second)
										<tr>
											<td>{{ $second->outbound_dock_time ? date('h:i a', $second->outbound_dock_time) : '' }}</td>
											<td class="fixed-width-inbound">{{ $second->outbound_customer }}</td>
											<td class="fixed-width-inbound">{{ $second->outbound_location }}</td>
											<td>{{ $second->outbound_order_number }}</td>
											<td>{{ $second->outbound_skids }}</td>
											<td>{{ $second->outbound_pick_status }}</td>
											<td class="sort-number" data-id="{{ $second->id }}">
												<a class="edit-btn edit-stop-btn" data-id="{{ $second->id }}" href="#" title="Edit" data-reveal-id="edit_stop_modal"><i class="fa fa-pencil-square-o fa-lg"></i></a>
												<a class="delete-btn delete-stop-btn" data-id="{{ $second->id }}" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
												<a class="up" href="#" title="Move Up"><i class="fa fa-arrow-up fa-lg"></i> </a>
												<a class="down" href="#" title="Move Down"><i class="fa fa-arrow-down fa-lg"></i> </a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@else
							<span>No stops yet.</span>
						@endif
					</div>
				</div>
			@endforeach
		</div>
	</div>

	{{-- Modals --}}
	<div id="first_outbound_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Outbound Schedule</h2>
		<p class="lead">New Route</p>
			<form id="outbound1-form">
				{{ Form::label('outbound_carrier', 'Carrier') }}
				{{ Form::text('outbound_carrier', '', ['placeholder' => 'Carrier', 'class' => 'repetitive']) }}

				{{ Form::label('outbound_driver', 'Driver') }}
				{{ Form::text('outbound_driver', '', ['placeholder' => 'Driver', 'class' => 'repetitive']) }}

				{{ Form::label('outbound_truck', 'Truck') }}
				{{ Form::text('outbound_truck', '', ['placeholder' => 'Truck', 'class' => 'repetitive']) }}

				{{ Form::label('outbound_region', 'Region') }}
				{{ Form::text('outbound_region', '', ['placeholder' => 'Region', 'class' => 'repetitive']) }}

				{{ Form::label('outbound_start_time', 'Start Time') }}
				{{ Form::text('outbound_start_time', '', ['placeholder' => 'Start Time']) }}
				<a href="#" id="create1-btn" class="button expand">Create</a>			
			</form>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

	<div id="edit_outbound_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Outbound Schedule</h2>
		<p class="lead">Edit Route</p>
		<form id="update-outbound-form">
			{{ Form::label('edit_outbound_carrier', 'Carrier') }}
			{{ Form::text('edit_outbound_carrier', '', ['placeholder' => 'Carrier', 'class' => 'repetitive']) }}

			{{ Form::label('edit_outbound_driver', 'Driver') }}
			{{ Form::text('edit_outbound_driver', '', ['placeholder' => 'Driver', 'class' => 'repetitive']) }}

			{{ Form::label('edit_outbound_truck', 'Truck') }}
			{{ Form::text('edit_outbound_truck', '', ['placeholder' => 'Truck', 'class' => 'repetitive']) }}

			{{ Form::label('edit_outbound_region', 'Region') }}
			{{ Form::text('edit_outbound_region', '', ['placeholder' => 'Region', 'class' => 'repetitive']) }}

			{{ Form::label('edit_outbound_stops', 'Stops') }}
			{{ Form::text('edit_outbound_stops', '', ['placeholder' => 'Stops', 'class' => 'repetitive', 'disabled' => 'disabled']) }}

			{{ Form::label('edit_outbound_start_time', 'Start Time') }}
			{{ Form::text('edit_outbound_start_time', '', ['placeholder' => 'Start Time']) }}

			<a href="#" id="update-btn" class="button expand">Update</a>
		</form>
	</div>

	
	{{-- STOPS WITHIN THE ROUTE --}}
	<div id="new_stop_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Outbound Schedule</h2>
		<p class="lead">New STOP</p>
			<form id="outbound2-form">
				{{ Form::label('outbound_dock_time', 'Dock Time') }}
				{{ Form::text('outbound_dock_time', '', ['placeholder' => 'Dock Time']) }}

				{{ Form::label('outbound_customer', 'Customer') }}
				{{ Form::text('outbound_customer', '', ['placeholder' => 'Customer', 'class' => 'repetitive']) }}

				{{ Form::label('outbound_location', 'Location') }}
				{{ Form::text('outbound_location', '', ['placeholder' => 'Location', 'class' => 'repetitive']) }}

				{{ Form::label('outbound_order_number', 'Order Number') }}
				{{ Form::text('outbound_order_number', '', ['placeholder' => 'Order Number','class' => 'repetitive']) }}

				{{ Form::label('outbound_skids', 'Skids') }}
				{{ Form::text('outbound_skids', '', ['placeholder' => 'Skids', 'class' => 'repetitive']) }}

				<label for="outbound_pick_status">Pick Status</label>

        		<select id="outbound_pick_status" name="outbound_pick_status">
		          	<option value="Pending">Pending</option>
		          	<option value="Completed">Completed</option>
		        </select>

				<a href="#" id="create2-btn" class="button expand">Create</a>			
			</form>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

	<div id="edit_stop_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Outbound Schedule</h2>
		<p class="lead">New STOP</p>
			<form id="update-outbound2-form">
				{{ Form::label('edit_outbound_dock_time', 'Dock Time') }}
				{{ Form::text('edit_outbound_dock_time', '', ['placeholder' => 'Dock Time']) }}

				{{ Form::label('edit_outbound_customer', 'Customer') }}
				{{ Form::text('edit_outbound_customer', '', ['placeholder' => 'Customer', 'class' => 'repetitive']) }}

				{{ Form::label('edit_outbound_location', 'Location') }}
				{{ Form::text('edit_outbound_location', '', ['placeholder' => 'Location', 'class' => 'repetitive']) }}

				{{ Form::label('edit_outbound_order_number', 'Order Number') }}
				{{ Form::text('edit_outbound_order_number', '', ['placeholder' => 'Order Number','class' => 'repetitive']) }}

				{{ Form::label('edit_outbound_skids', 'Skids') }}
				{{ Form::text('edit_outbound_skids', '', ['placeholder' => 'Skids','class' => 'repetitive']) }}

				<label for="">Pick Status</label>

        		<select id="edit_outbound_pick_status" name="edit_outbound_pick_status">
		          	<option value="Pending">Pending</option>
		          	<option value="Completed">Completed</option>
		        </select>

				<a href="#" id="update2-btn" class="button expand">Update</a>			
			</form>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>
@stop

@section('custom-js')
{{ HTML::script('assets/plugins/stupidtable.js') }}
<script type="text/javascript">
	$(document).on('close.fndtn.reveal', '[data-reveal]', function () {
	  	$('#outbound1-form').trigger('reset');
	});

	$(document).ready(function() {

		$('input[name="outbound_start_time"], input[name="edit_outbound_start_time"], input[name="edit_start_time"], input[name="outbound_dock_time"], input[name="edit_outbound_dock_time"]').datetimepicker({
			datepicker: false,
			format: 'h:i a'
		});

		//insert
		$('#create1-btn').click(function(event) {
			event.preventDefault();
			form 	= $('#outbound1-form'),
			carrier = $('input[name="outbound_carrier"]'),
			driver  = $('input[name="outbound_driver"]'),
			truck  = $('input[name="outbound_truck"]'),
			start_time  = $('input[name="outbound_start_time"]');
			region      = $('input[name="outbound_region"]');

			fields = {
				outbound_carrier: carrier.val(),
				outbound_driver: driver.val(),
				outbound_truck: truck.val(),
				outbound_start_time: start_time.val(),
				outbound_region: region.val(),
				user_id: '{{ Auth::user()->id }}',
				date: '{{ Input::has("d") ? Input::get("d") : null }}'
			};

			if (fields.outbound_carrier != '' || fields.outbound_driver != '' || fields.outbound_truck != '' || fields.outbound_start_time != '') {

				repetitive = getRepetitive();

				// submit form
				$.ajax({
					type: 'post',
					url: '{{ URL::to("outbound_schedule/insert") }}',
					data: {
						fields: fields,
						_token: '{{ csrf_token() }}',
						repetitive: repetitive
					},
					dataType: 'json',
					success: function(response) {
						window.location.reload();
					}
				});				

			}

		});
		
		//delete
		$('.delete-route-btn').click(function(event) {
			event.preventDefault();
			id = $(this).data('id');
			if (confirm('Delete confirmation')) {
				$.ajax({
					type: 'post',
					url: '{{ URL::to("outbound_schedule/delete") }}',
					data: {
						_token: '{{ csrf_token() }}',
						id: id
					},
					success: function() {
						window.location.reload();
					}
				});
			}
		});

		//edit outbound / create step 2 / display outbound data by id
		$('.edit-route-btn').click(function(event) {
			event.preventDefault();
			id = $(this).data('id');

			$.ajax({
				type: 'post',
				url: '{{ URL::to("outbound_schedule/edit") }}',
				data: {
					id: id,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function(response) {
					//firat step
					$('input[name="edit_outbound_carrier"]').val(response.outbound_carrier);
					$('input[name="edit_outbound_driver"]').val(response.outbound_driver);
					$('input[name="edit_outbound_truck"]').val(response.outbound_truck);
					$('input[name="edit_outbound_start_time"]').val(response.outbound_start_time);
					$('input[name="edit_outbound_region"]').val(response.outbound_region);
					$('#update-btn').attr('data-id', response.id);
				}
			});

			var count = $(this).closest(".outbound-box").find('.tcf-table > tbody').children('tr').length;

			if(count) {
				$("#edit_outbound_stops").val(count);
			}

			$('#edit_outbound_modal').foundation('reveal', 'open');
		});

		//update outbound
		$('#update-btn').click(function(event) {
			event.preventDefault();
			id = $(this).attr('data-id');
			fields = {
				outbound_carrier: $('input[name="edit_outbound_carrier"]').val(),
				outbound_driver: $('input[name="edit_outbound_driver"]').val(),
				outbound_truck: $('input[name="edit_outbound_truck"]').val(),
				outbound_start_time: $('input[name="edit_outbound_start_time"]').val(),
				outbound_region: $('input[name="edit_outbound_region"]').val()
			};

			repetitive = getRepetitive();

			$.ajax({
				type: 'post',
				url: '{{ URL::to("outbound_schedule/update") }}',
				data: {
					id: id,
					fields: fields,
					_token: '{{ csrf_token() }}',
					repetitive: repetitive						
				},
				dataType: 'json',
				success: function(response) {
					window.location.reload();
				}
			});

		});
		
		//stops
		$('.create-stop-btn').click(function(event) {
			event.preventDefault();
			var id = $(this).data('id');
			$('#create2-btn').data('id', id);
		});

		$('#create2-btn').click(function(event) {
			event.preventDefault();
			var outbound_id = $(this).data('id');

			fields = {
				outbound_id: outbound_id,
				outbound_dock_time: $('input[name="outbound_dock_time"]').val(),
				outbound_customer: $('input[name="outbound_customer"]').val(),
				outbound_location: $('input[name="outbound_location"]').val(),
				outbound_order_number: $('input[name="outbound_order_number"]').val(),
				outbound_pick_status: $('#outbound_pick_status').val(),
				outbound_skids: $('input[name="outbound_skids"]').val(),
				user_id: '{{ Auth::user()->id }}'
			};

			if (fields.outbound_dock_time != '' || fields.outbound_customer != '' || fields.outbound_location != '' || fields.outbound_order_number != '' || fields.outbound_pick_status != '') {

				repetitive = getRepetitive();

				// submit form
				$.ajax({
					type: 'post',
					url: '{{ URL::to("outbound_schedule/insert_stop") }}',
					data: {
						fields: fields,
						_token: '{{ csrf_token() }}',
						repetitive: repetitive
					},
					dataType: 'json',
					success: function(response) {
						window.location.reload();
					}
				});				

			}
		});


		$('.edit-stop-btn').click(function(event) {
			event.preventDefault();
			var id = $(this).data('id');

			$.ajax({
				type: 'post',
				url: '{{ URL::to("outbound_schedule/edit_stop") }}',
				data: {
					id: id,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function(response) {
					//second step
					$('input[name="edit_outbound_dock_time"]').val(response.outbound_dock_time);
					$('input[name="edit_outbound_customer"]').val(response.outbound_customer);
					$('input[name="edit_outbound_location"]').val(response.outbound_location);
					$('input[name="edit_outbound_order_number"]').val(response.outbound_order_number);
					$('input[name="edit_outbound_pick_status"]').val(response.outbound_pick_status);
					$('input[name="edit_outbound_skids"]').val(response.outbound_skids);
					$('#edit_outbound_pick_status').val(response.outbound_pick_status);

					$('#update2-btn').attr('data-id', response.id);
				}
			});
		});

		$('#update2-btn').click(function(event) {
			event.preventDefault();
			var id = $(this).attr('data-id');
			
			fields = {
				outbound_dock_time: $('input[name="edit_outbound_dock_time"]').val(),
				outbound_customer: $('input[name="edit_outbound_customer"]').val(),
				outbound_location: $('input[name="edit_outbound_location"]').val(),
				outbound_order_number: $('input[name="edit_outbound_order_number"]').val(),
				outbound_pick_status: $('#edit_outbound_pick_status').val(),
				outbound_skids: $('#edit_outbound_skids').val(),
			};

			repetitive = getRepetitive();

			$.ajax({
				type: 'post',
				url: '{{ URL::to("outbound_schedule/update_stop") }}',
				data: {
					id: id,
					fields: fields,
					_token: '{{ csrf_token() }}',
					repetitive: repetitive						
				},
				dataType: 'json',
				success: function(response) {
					window.location.reload();
				}
			});

		});

		//delete stop
		$('.delete-stop-btn').click(function(event) {
			event.preventDefault();
			id = $(this).data('id');
			if (confirm('Delete confirmation')) {
				$.ajax({
					type: 'post',
					url: '{{ URL::to("outbound_schedule/delete_stop") }}',
					data: {
						_token: '{{ csrf_token() }}',
						id: id
					},
					success: function() {
						window.location.reload();
					}
				});
			}
		});


		//sort table
		$('.tcf-table').stupidtable();

		//change date
		$('#change-date-btn').datetimepicker({
/*//disabled by job salas since they need to add outbound for weekends
			onGenerate:function(){
			    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
*/
			timepicker: false,
			value: "{{ Input::get('d') }}",
			format: 'Y-m-d',
			onSelectDate:function($date){
				window.location.href = '{{ URL::to("outbound_schedule") }}?d=' + $date.dateFormat('Y-m-d');
			}
		});


	    $(".up,.down").click(function(){
	        var row 	 = $(this).parents("tr:first");
	        var counter  = 1;
	        var array_data = [];
	        
	        if ($(this).is(".up")) {
	            row.insertBefore(row.prev());
	        } else {
	            row.insertAfter(row.next());
	        } 

	        $(".sort-number").each(function(key, value) {
	        	array_data.push([$(value).attr("data-id"), key+1]);
	        });

	        $.ajax({
	        	type : "POST",
	        	data : {
						_token : '{{ csrf_token() }}',
						data   : array_data
					},
				url  : '{{ URL::to("outbound_schedule/sortNumber") }}',
				success : function(data) {
					console.log(data); return false;
				}

	        });
	    });


	}); //end document
</script>
{{ HTML::script('assets/plugins/datahistory.js') }}
@stop
