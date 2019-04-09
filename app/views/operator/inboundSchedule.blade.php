@extends('layouts.default')

@section('title'){{ 'Inbound Schedule' }}@stop

@section('custom-css')
	<style type="text/css">
		.point {
			cursor: pointer !important;
		}
	</style>
@stop

@section('content')

	<div class="row" style="max-width:100%;">
		<div class="column small-12">
			{{-- <a href="{{ URL::to('fs/inbound?d='.date('Y-m-d', strtotime($date))) }}">View full screen display</a> --}}
			<div class="column small-12 light-box margin-top-20">
				<span>Inbound Daily Schedule</span>
				@if( Auth::user()->is_admin )
					@if ($date == date('l F j, Y') || strtotime($date) > strtotime(date('l F j, Y')))
						<a href="#" class="right new-entry-btn" data-reveal-id="inbound_modal"><i class="fa fa-plus"></i> New Entry</a>
					@endif
				@endif
				<span id="date-text"> - {{ $date }} &nbsp;<a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>
			</div>
			<div class="column small-12" style="overflow-x: scroll;padding: 0 !important;">
				<table class="responsive tcf-table">
					<thead>
						<tr>
							<th>Vendor</th>
							<th>PO#</th>
							<th>Customer PO#</th>
							<th>Carrier</th>
							<th>Product</th>
							<th>KG</th>
							<th>SKIDS</th>
							{{-- <th>Container #</th>
							<th>Supplier</th>
							<th>Steamship Provider</th>
							<th>Arrival To Port</th>
							<th>Arrival To Destination</th>
							<th>Terminal Handling Fee Paid</th>
							<th>Pickup Location</th>
							<th>Pickup Appointment</th>
							<th>Return Location</th>
							<th>RV #</th>
							<th>Pickup #</th> --}}
							<th class="point" data-sort="int">ETA <i class="fa fa-sort"></i></th>
							<th>Delivery</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($inbounds as $inbound)
							<tr>
								<td class="fixed-width-outbound">{{ $inbound->inbound_vendor }}</td>
								<td class="fixed-width-outbound">{{ $inbound->inbound_po_number }}</td>
								<td class="fixed-width-outbound">{{ $inbound->inbound_customer_po }}</td>
								<td class="fixed-width-outbound">{{ $inbound->inbound_carrier }}</td>							
								<td class="fixed-width-outbound">{{ $inbound->inbound_product }}</td>
								<td>{{ $inbound->inbound_kg }}</td>
								<td>{{ $inbound->inbound_cases }}</td>
								{{-- <td>{{ $inbound->inbound_container_number }}</td>
								<td>{{ $inbound->inbound_supplier}}</td>
								<td>{{ $inbound->inbound_steamship_provider }}</td>
								<td>{{ date('d/m/Y', strtotime($inbound->inbound_arrival_to_port) ) }}</td>
								<td>{{ date('d/m/Y', strtotime($inbound->inbound_arrival_to_destination) )}}</td>
								<td>{{ $inbound->inbound_terminal_handling_fee_paid ? 'Yes' : 'No' }}</td>
								<td>{{ $inbound->inbound_pickup_location }}</td>
								<td>{{ date('d/m/Y h:i a', strtotime($inbound->inbound_pickup_appointment) ); }} </td>
								<td>{{ $inbound->inbound_return_location }}</td>
								<td>{{ $inbound->inbound_rv_number }}</td>
								<td>{{ $inbound->inbound_pickup_number }}</td>
								
								 --}}
								 <td>{{ $inbound->inbound_eta ? date('h:i a', $inbound->inbound_eta) : '' }}</td>
								 <td>{{ $inbound->inbound_delivery_option }}</td>
								 <td data-id="{{ $inbound->id }}">
									@if( Auth::user()->is_admin )
									<a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
									<a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	{{-- Modals --}}
	<div id="inbound_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Inbound Schedule</h2>
		<p class="lead">First Step</p>
			<form id="inbound-form">
				<div class="row">
					<div class="small-4 columns">
						<label for="right-label" class="inline">Date</label>
					</div>
					<div class="small-8 columns daily-date daily-date-edit">
						<span id="schedule"></span> &nbsp;<a href="#" title="Change Date" id="change-date-btn-edit"><i class="fa fa-calendar"></i></a>
						<input type="hidden" name="schedule" id="schedule_val">
					</div>
				</div>
				{{ Form::label('inbound_vendor', 'Vendor') }}
				{{ Form::text('inbound_vendor', '', ['placeholder' => 'Vendor', 'class' => 'repetitive']) }}

				{{ Form::label('inbound_po_number', 'PO#') }}
				{{ Form::text('inbound_po_number', '', ['placeholder' => 'PO#', 'class' => 'repetitive']) }}

				{{ Form::label('inbound_customer_po', 'Customer PO#') }}
				{{ Form::text('inbound_customer_po', '', ['placeholder' => 'Customer PO#', 'class' => 'repetitive']) }}

				{{ Form::label('inbound_carrier', 'Carrier') }}
				{{ Form::text('inbound_carrier', '', ['placeholder' => 'Carrier', 'class' => 'repetitive']) }}

				{{ Form::label('inbound_product', 'Product') }}
				{{ Form::text('inbound_product', '', ['placeholder' => 'Product', 'class' => 'repetitive']) }}

				{{ Form::label('inbound_cases', 'Kg') }}
				{{ Form::number('inbound_cases', '', ['placeholder' => 'Kg']) }}

				{{ Form::label('inbound_kg', 'Skids') }}
				{{ Form::number('inbound_kg', '', ['placeholder' => 'Skids']) }}

				{{ Form::label('inbound_eta', 'ETA') }}
				{{ Form::text('inbound_eta', '', ['placeholder' => 'ETA']) }}

				
	  			<fieldset class="large-12 cell">
	    			<legend>Delivery Option</legend>
	    			<input type="radio" name="inbound_delivery_option" value="pickup" id="pick_up" required><label for="pick_up">Pick Up</label>
	    			<input type="radio" name="inbound_delivery_option" value="delivery" id="delivery" checked><label for="delivery">Delivery</label>
	  			</fieldset>
									

				{{-- {{ Form::label('inbound_container_number', 'Container Number') }}
				{{ Form::text('inbound_container_number', '', ['placeholder' => 'Container Number']) }}

				{{ Form::label('inbound_supplier', 'Supplier') }}
				{{ Form::text('inbound_supplier', '', ['placeholder' => 'Supplier']) }}
	
				{{ Form::label('inbound_steamship_provider', 'Steamship Provider') }}
				{{ Form::text('inbound_steamship_provider', '', ['placeholder' => 'Steamship Provider']) }}

				{{ Form::label('inbound_arrival_to_port', 'Arrival to Port') }}
				{{ Form::text('inbound_arrival_to_port', '', ['placeholder' => 'Arrival to Port']) }}

				{{ Form::label('inbound_arrival_to_destination', 'Arrival to Destination') }}
				{{ Form::text('inbound_arrival_to_destination', '', ['placeholder' => 'Arrival to Destination']) }}

				{{ Form::label('', 'Terminal Handling Fee Paid') }}
				<span> Yes </span>
				{{ Form::radio('inbound_terminal_handling_fee_paid', 1, true) }}
				<span> No </span>
				{{ Form::radio('inbound_terminal_handling_fee_paid', 0) }}<br />

				{{ Form::label('inbound_pickup_location', 'Pickup Location') }}
				{{ Form::text('inbound_pickup_location', '', ['placeholder' => 'Pickup Location']) }}

				{{ Form::label('inbound_pickup_appointment', 'Pickup Appointment') }}
				{{ Form::text('inbound_pickup_appointment', '', ['placeholder' => 'Pickup Appointment']) }}

				{{ Form::label('inbound_return_location', 'Return Location') }}
				{{ Form::text('inbound_return_location', '', ['placeholder' => 'Return Location']) }}
			
				{{ Form::label('inbound_rv_number', 'RV #') }}
				{{ Form::number('inbound_rv_number', '', ['placeholder' => 'RV #']) }}
				
				{{ Form::label('inbound_pickup_number', 'Pickup #') }}
				{{ Form::number('inbound_pickup_number', '', ['placeholder' => 'Pickup #']) }} --}}
				<a href="#" id="create-btn" class="button expand" data-action="create"></a>
			</form>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

@stop

@section('custom-js')
{{ HTML::script('assets/plugins/stupidtable.js') }}
<script type="text/javascript">
	$(document).on('close.fndtn.reveal', '[data-reveal]', function () {
	  	$('#inbound-form').trigger('reset');
	});

	$(document).ready(function() {
		$('#change-date-btn-edit').datetimepicker({
			onGenerate:function(){
				
			    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "",
			format: 'Y-m-d',
			onSelectDate:function($date){
				  var day = $date.getDate();
				  var month = $date.getMonth() + 1;
				  var year = $date.getFullYear();	
				  if(day < 10){
					  day = "0" + day;
				  }
				  if(month < 10){
					  month = "0" + month;
				  }
				  $("#schedule_val").val(year + '-'+ month + '-' + day);
				  $(".daily-date-edit").find("span").html(year + '-'+ month + '-' + day);
			}
		});
		$('input[name="inbound_eta"]').datetimepicker({
			datepicker: false,
			format: 'h:i a'
		});
		
		$('input[name="inbound_arrival_to_port"], input[name="inbound_arrival_to_destination"]').datetimepicker({
			timepicker: false,
			format: 'Y-m-d'
		});

		$('input[name="inbound_pickup_appointment"]').datetimepicker({
			format: 'Y-m-d h:i a'
		});
		$('.new-entry-btn').click(function(){
			$("#schedule_val").val("");
			$(".daily-date-edit").find("span").html("");
			$('#create-btn').text('Create');
		});

		//create
		$('#create-btn').click(function(event) {
			event.preventDefault();
			form 	= $('#inbound-form'),

			action = $(this).attr('data-action');

			fields = {
				inbound_vendor: $('input[name="inbound_vendor"]').val(),
				inbound_po_number: $('input[name="inbound_po_number"]').val(),
				inbound_carrier: $('input[name="inbound_carrier"]').val(),
				inbound_product: $('input[name="inbound_product"]').val(),
				inbound_cases: $('input[name="inbound_cases"]').val(),
				inbound_kg: $('input[name="inbound_kg"]').val(),
				inbound_eta: $('input[name="inbound_eta"]').val(),
				user_id: '{{ Auth::user()->id }}',
				date: '{{ $date }}',
				schedule:$('#schedule_val').val(),
				inbound_customer_po:$('input[name="inbound_customer_po"]').val(),
				inbound_delivery_option:$('input[name="inbound_delivery_option"]').val(),
				// inbound_container_number: $('input[name="inbound_container_number"]').val(),
				// inbound_supplier: $('input[name="inbound_supplier"]').val(),
				// inbound_steamship_provider: $('input[name="inbound_steamship_provider"]').val(),
				// inbound_arrival_to_port: $('input[name="inbound_arrival_to_port"]').val(),
				// inbound_arrival_to_destination: $('input[name="inbound_arrival_to_destination"]').val(),
				// inbound_terminal_handling_fee_paid: $('input[name="inbound_terminal_handling_fee_paid"]:checked').val(),
				// inbound_pickup_location: $('input[name="inbound_pickup_location"]').val(),
				// inbound_pickup_appointment: $('input[name="inbound_pickup_appointment"]').val(),
				// inbound_return_location: $('input[name="inbound_return_location"]').val(),
				// inbound_rv_number: $('input[name="inbound_rv_number"]').val(),
				// inbound_pickup_number: $('input[name="inbound_pickup_number"]').val(),
			};

			

			if (fields.inbound_vendor != '' || fields.inbound_po_number != '' || fields.inbound_carrier != '' || fields.inbound_product != '' || fields.inbound_cases != '' || fields.inbound_kg != '' || fields.inbound_eta != '') {

				repetitive = getRepetitive();

				if (action == 'create') {
					// insert
					$.ajax({
						type: 'post',
						url: '{{ URL::to("inbound_schedule/insert") }}',
						data: {
							fields: fields,
							_token: '{{ csrf_token() }}',
							repetitive: repetitive
						},
						dataType: 'json',
						success: function(response) {
							
							$('#inbound_modal').foundation('reveal', 'close');
							new_row = $('<tr>' +
								'<td>'+response.inbound_vendor+'</td>' +
								'<td>'+response.inbound_po_number+'</td>' +
								'<td>'+response.inbound_carrier+'</td>' +
								'<td>'+fields.inbound_product+'</td>' +
								'<td>'+fields.inbound_kg+'</td>' +
								'<td>'+fields.inbound_cases+'</td>' +

								// '<td>'+fields.inbound_container_number+'</td>' +
								// '<td>'+fields.inbound_supplier+'</td>' +
								// '<td>'+fields.inbound_steamship_provider+'</td>' +
								// '<td>'+moment(fields.inbound_arrival_to_port).format('DD/MM/YYYY')+'</td>' +
								// '<td>'+moment(fields.inbound_arrival_to_destination).format('DD/MM/YYYY')+'</td>' +
								// '<td>'+ (fields.inbound_terminal_handling_fee_paid ? 'Yes' : 'No') +'</td>' +
								// '<td>'+fields.inbound_pickup_location+'</td>' +
								// '<td>'+moment(fields.inbound_pickup_appointment).format('DD/MM/YYYY hh:mm a') +'</td>' +
								// '<td>'+fields.inbound_return_location+'</td>' +
								// '<td>'+fields.inbound_rv_number+'</td>' +
								// '<td>'+fields.inbound_pickup_number+'</td>' +

								'<td>'+fields.inbound_eta+'</td>' +
								'<td data-id="'+response.id+'">' +
									'<a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
									'<a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
								'</td>' +
							'</tr>');
							$(new_row).hide().appendTo('.tcf-table').fadeIn(300);
							form.trigger('reset');
						}
					});	
				} else {
					id = $(this).attr('data-id');
					//update
					$.ajax({
						type: 'post',
						url: '{{ URL::to("inbound_schedule/update") }}',
						data: {
							id: id,
							fields: fields,
							_token: '{{ csrf_token() }}',
							repetitive: repetitive
						},
						dataType: 'json',
						success: function(response) {
							
							$('td[data-id="'+id+'"]').parent('tr').html('' +
								'<td>'+response.inbound_vendor+'</td>' +
								'<td>'+response.inbound_po_number+'</td>' +
								'<td>'+response.inbound_carrier+'</td>' +
								'<td>'+fields.inbound_product+'</td>' +
								'<td>'+fields.inbound_kg+'</td>' +
								'<td>'+fields.inbound_cases+'</td>' +

								// '<td>'+fields.inbound_container_number+'</td>' +
								// '<td>'+fields.inbound_supplier+'</td>' +
								// '<td>'+fields.inbound_steamship_provider+'</td>' +
								// '<td>'+moment(fields.inbound_arrival_to_port).format('DD/MM/YYYY')+'</td>' +
								// '<td>'+moment(fields.inbound_arrival_to_destination).format('DD/MM/YYYY')+'</td>' +
								// '<td>'+ (fields.inbound_terminal_handling_fee_paid ? 'Yes' : 'No') +'</td>' +
								// '<td>'+fields.inbound_pickup_location+'</td>' +
								// '<td>'+moment(fields.inbound_pickup_appointment).format('DD/MM/YYYY hh:mm a') +'</td>' +
								// '<td>'+fields.inbound_return_location+'</td>' +
								// '<td>'+fields.inbound_rv_number+'</td>' +
								// '<td>'+fields.inbound_pickup_number+'</td>' +

								'<td>'+fields.inbound_eta+'</td>' +
								'<td data-id="'+response.id+'">' +
									'<a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
									'<a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
								'</td>' +
							'');
							$('#inbound_modal').foundation('reveal', 'close');
						}
					});
				}

				}

		});

	//delete
	$('body').on('click', '.delete-btn', function(event) {
		event.preventDefault();
		tr = $(this).closest('tr');
		id = $(this).parent().data('id');
		if (confirm('Delete confirmation')) {
			$.ajax({
				type: 'post',
				url: '{{ URL::to("inbound_schedule/delete") }}',
				data: {
					_token: '{{ csrf_token() }}',
					id: id
				},
				success: function() {
					tr.fadeOut(300);
				}
			});
		}
	});

	//edit inbound / display inbound data by id
	$('body').on('click', '.edit-btn', function(event) {
		event.preventDefault();
		id = $(this).parent().data('id');
		$('#create-btn').attr('data-action', 'edit');
		$('#create-btn').text('Update');
		$('#create-btn').attr('data-id', id);
		$.ajax({
			type: 'post',
			url: '{{ URL::to("inbound_schedule/edit") }}',
			data: {
				id: id,
				_token: '{{ csrf_token() }}'
			},
			dataType: 'json',
			success: function(response) {
				
				//firat step
				var schedule = response.created_at;
				if(response.schedule){
					schedule = response.schedule;
				}
				
				$('input[name="inbound_vendor"]').val(response.inbound_vendor);
				$('input[name="inbound_po_number"]').val(response.inbound_po_number);
				$('input[name="inbound_carrier"]').val(response.inbound_carrier);
				$('input[name="edit_start_time"]').val(response.outbound_start_time);
				$('input[name="inbound_product"]').val(response.inbound_product);
				$('input[name="inbound_cases"]').val(response.inbound_cases);
				$('input[name="inbound_kg"]').val(response.inbound_kg);
				$('input[name="inbound_eta"]').val(response.inbound_eta);
				$('input[name="inbound_customer_po"]').val(response.inbound_customer_po);
				$('#update-btn').attr('data-id', response.id);
				$('#schedule').text(schedule);
				$('#schedule_val').val(schedule);

				if(response.inbound_delivery_option){
					if(response.inbound_delivery_option == 'pickup'){
						$("#pick_up").attr('checked', 'checked');
					}
					else if(response.inbound_delivery_option == 'delivery'){
						$("#delivery").attr('checked', 'checked');
					}
				}
				// $('input[name="inbound_container_number"]').val( response.inbound_container_number ) ;
				// $('input[name="inbound_supplier"]').val( response.inbound_supplier );
				// $('input[name="inbound_steamship_provider"]').val( response.inbound_steamship_provider );
				// $('input[name="inbound_arrival_to_port"]').val( response.inbound_arrival_to_port );
				// $('input[name="inbound_arrival_to_destination"]').val( response.inbound_arrival_to_destination );
				// $('input[name="inbound_terminal_handling_fee_paid"][value="'+response.inbound_terminal_handling_fee_paid+'"]').prop("checked", true);;
				// $('input[name="inbound_pickup_location"]').val( response.inbound_pickup_location );
				// $('input[name="inbound_pickup_appointment"]').val( response.inbound_pickup_appointment );
				// $('input[name="inbound_return_location"]').val( response.inbound_return_location );
				// $('input[name="inbound_rv_number"]').val( response.inbound_rv_number );
				// $('input[name="inbound_pickup_number"]').val( response.inbound_pickup_number );
			}
		});

		$('#inbound_modal').foundation('reveal', 'open');
	});

	//sort table
	$('.tcf-table').stupidtable();

	//change date
	$('#change-date-btn').datetimepicker({
		onGenerate:function(){
		    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
		},
		timepicker: false,
		value: "{{ Input::get('d') }}",
		format: 'Y-m-d',
		onSelectDate:function($date){
			window.location.href = '{{ URL::to("inbound_schedule") }}?d=' + $date.dateFormat('Y-m-d');
		}
	});

	}); //end document ready
</script>
{{ HTML::script('assets/plugins/datahistory.js') }}
@stop