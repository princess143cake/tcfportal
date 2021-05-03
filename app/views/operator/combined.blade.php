@extends('layouts.default')

@section('title'){{ 'History' }}@stop

@section('custom-css')


<style type="text/css">
	.data-field {
		color: #9D9CA0;
		font-size: 0.764rem;
		margin-left: 5px;
		margin-right: 12px;
		margin-top: -10px;
	}

	.data-value {
		color: #505050;
		font-size: 0.790rem;
	}

	#clear-data-history-btn {
		margin-right: 15px;
	}
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js" integrity="sha512-Vp2UimVVK8kNOjXqqj/B0Fyo96SDPj9OCSm1vmYSrLYF3mwIOBXh/yRZDVKo8NemQn1GUjjK0vFJuCSCkYai/A==" crossorigin="anonymous"></script>



@stop

@section('content')


<div class="row" style="min-width: 100%;">
	<div class="column small-12">
		{{-- <a href="{{ URL::to('fs/outbound?d='.date('Y-m-d', strtotime($date))) }}">View full screen display</a> --}}
		<div class="column small-12 light-box margin-top-20">
			<span>Outbound Daily Schedule</span>
			@if( Auth::user()->is_admin )
			@if ($date == date('l F j, Y') || strtotime($date) > strtotime(date('l F j, Y')))
			<a href="#" class="right" data-reveal-id="first_outbound_modal"><i class="fa fa-plus"></i> Create New Route</a>
			@endif
			@endif
			<span id="date-text"> - {{ $date }} &nbsp;<a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>
		</div>


		@foreach ($outbounds as $row)
		<div class="large-12 column outbound-box margin-top-20">
			<div class="large-3 column">
				<h5>Route <a target="_blank" href="{{ url('outbound_schedule/print/'.$row->id) }}" title="Print Route"><i class="print-btn fa fa-print"></i></a></h5>
				<span class="route-text">Carrier: {{ $row->outbound_carrier }}</span>
				<span class="route-text">Driver: {{ $row->outbound_driver }}</span>
				<span class="route-text">Start Time: {{ $row->outbound_start_time ? date('h:i a', $row->outbound_start_time) : '' }}</span>
				<span class="route-text">Truck: {{ $row->outbound_truck }}</span>
				<span class="route-text">Trailer Number: {{ $row->outbound_trailer_number }}</span>

				<span class="route-text">Region: {{ $row->outbound_region }}</span>
				@if( Auth::user()->is_admin )
				<span>Options: </span><a title="Edit Route" class="route-text edit-route-btn" style="display: inline" data-reveal-id="edit_route_modal" data-id="{{ $row->id }}" href="#"><i class="fa fa-pencil"></i> </a>
				<a title="Delete Route" class="route-text delete-route-btn" style="display: inline; color: #FF6A6A" data-id="{{ $row->id }}" href="#"><i class="fa fa-times"></i> </a>
				@endif
			</div>

			<div class="large-9 column">
				<h5>Stops <a href="#" data-id="{{ $row->id }}" style="font-weight: 400;font-size: 0.9rem;" class="right create-stop-btn" data-reveal-id="new_stop_modal">Create new stop</a></h5>
				@if ($row->secondphase->toArray())
				<table class="tcf-table">
					<thead>
						<tr>
							<th class="point" data-sort="string">Customer <i class="fa fa-sort"></i></th>
							<th class="point" data-sort="string">Location<i class="fa fa-sort"></i></th>
							<th class="point" data-sort="string">Customer Po <i class="fa fa-sort"></i></th>
							<th class="point" data-sort="int">Order No. <i class="fa fa-sort"></i></th>
							<th class="point" data-sort="int">Dock Time <i class="fa fa-sort"></i></th>
							<th class="point" data-sort="int">Skids <i class="fa fa-sort"></i></th>
							<!-- <th class="point" data-sort="string">Location <i class="fa fa-sort"></i></th>		 -->
							<th class="point" data-sort="string">Pick Status <i class="fa fa-sort"></i></th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($row->secondphase as $second)
						<tr>
							<td class="fixed-width-inbound">{{ $second->outbound_customer }}</td>
							<td class="fixed-width-inbound">{{ $second->outbound_location }}</td>
							<td class="fixed-width-inbound">{{ $second->outbound_customer_po }}</td>
							<td>{{ $second->outbound_order_number }}</td>
							<td>{{ $second->outbound_dock_time ? date('h:i a', $second->outbound_dock_time) : '' }}</td>
							<td>{{ $second->outbound_skids }}</td>
							<!-- <td class="fixed-width-inbound">{{ $second->outbound_location }}</td> -->
							<td>{{ $second->outbound_pick_status }}</td>
							<td class="sort-number" data-id="{{ $second->id }}">
								@if( Auth::user()->is_admin )
								<a class="edit-btn edit-stop-btn" data-id="{{ $second->id }}" href="#" title="Edit" data-reveal-id="edit_stop_modal"><i class="fa fa-pencil-square-o fa-lg"></i></a>
								<a class="delete-btn delete-stop-btn" data-id="{{ $second->id }}" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
								<a class="up" href="#" title="Move Up"><i class="fa fa-arrow-up fa-lg"></i> </a>
								<a class="down" href="#" title="Move Down"><i class="fa fa-arrow-down fa-lg"></i> </a>
								@endif
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

		{{ Form::label('outbound_trailer_number', 'Trailer Number') }}
		{{ Form::text('outbound_trailer_number', '', ['placeholder' => 'Trailer Number', 'class' => 'repetitive']) }}

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
		<div class="row">
			<div class="small-2 columns">
				<label for="right-label" class="inline">Date</label>
			</div>
			<div class="small-10 columns daily-date daily-date-edit">
				<span id="schedule"></span> &nbsp;<a href="#!" title="Change Date" id="change-date-btn-edit"><i class="fa fa-calendar"></i></a>
				<input type="hidden" name="schedule" id="schedule_val">
			</div>
		</div>
		{{ Form::label('edit_outbound_carrier', 'Carrier') }}
		{{ Form::text('edit_outbound_carrier', '', ['placeholder' => 'Carrier', 'class' => 'repetitive']) }}

		{{ Form::label('edit_outbound_driver', 'Driver') }}
		{{ Form::text('edit_outbound_driver', '', ['placeholder' => 'Driver', 'class' => 'repetitive']) }}

		{{ Form::label('edit_outbound_truck', 'Truck') }}
		{{ Form::text('edit_outbound_truck', '', ['placeholder' => 'Truck', 'class' => 'repetitive']) }}

		{{ Form::label('edit_outbound_trailer_number', 'Trailer Number') }}
		{{ Form::text('edit_outbound_trailer_number', '', ['placeholder' => 'Trailer Number', 'class' => 'repetitive']) }}

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

		{{ Form::label('outbound_customer_po', 'Customer Po') }}
		{{ Form::text('outbound_customer_po', '', ['placeholder' => 'Customer Po', 'class' => 'repetitive']) }}

		{{ Form::label('outbound_location', 'Location') }}
		{{ Form::text('outbound_location', '', ['placeholder' => 'Location', 'class' => 'repetitive']) }}

		{{ Form::label('outbound_order_number', 'Order Number') }}
		{{ Form::text('outbound_order_number', '', ['placeholder' => 'Order Number','class' => 'repetitive']) }}

		{{ Form::label('outbound_skids', 'Skids') }}
		{{ Form::text('outbound_skids', '', ['placeholder' => 'Skids', 'class' => 'repetitive']) }}

		<label for="outbound_pick_status">Pick Status</label>

		<select id="outbound_pick_status" name="outbound_pick_status">
			<option value="Inbound">Inbound</option>
			<option value="Outbound">Outbound</option>
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

		{{ Form::label('edit_outbound_customer_po', 'Customer Po') }}
		{{ Form::text('edit_outbound_customer_po', '', ['placeholder' => 'Customer Po', 'class' => 'repetitive']) }}

		{{ Form::label('edit_outbound_location', 'Location') }}
		{{ Form::text('edit_outbound_location', '', ['placeholder' => 'Location', 'class' => 'repetitive']) }}

		{{ Form::label('edit_outbound_order_number', 'Order Number') }}
		{{ Form::text('edit_outbound_order_number', '', ['placeholder' => 'Order Number','class' => 'repetitive']) }}

		{{ Form::label('edit_outbound_skids', 'Skids') }}
		{{ Form::text('edit_outbound_skids', '', ['placeholder' => 'Skids','class' => 'repetitive']) }}

		<label for="">Pick Status</label>

		<select id="edit_outbound_pick_status" name="edit_outbound_pick_status">
			<option value="Inbound">Inbound</option>
			<option value="Outbound">Outbound</option>
		</select>

		<a href="#" id="update2-btn" class="button expand">Update</a>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<!-- Start Inbound Schedule -->
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
			<span id="date-text"> - {{ $date }} &nbsp;
				<!-- <a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a> -->
			</span>
		</div>
		<div class="column small-12" style="overflow-x: scroll;padding: 0 !important;">
			<table class="responsive tcf-table">
				<thead>
					<tr>


						<th>Date</th>
						<th>Carrier</th>
						<th>Driver</th>
						<th>Start</th>
						<th>Truck</th>
						<th>Trailer</th>
						<th>Customer(Vendor)</th>
						<th>Customer PO#</th>
						<th>TCF PO#</th>
						<th>Dock/Delivery Time</th>
						<th>Product</th>
						<th>Skids</th>
						<th>Inbound/Outbound</th>


					</tr>
				</thead>
				<tbody>
					@foreach ($inbounds as $inbound)
					<tr>
						<td class="fixed-width-outbound">{{ $inbound->schedule }}</td>
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
							<a class="edit-inbound-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
							<a class="delete-inbound-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
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
			<div class="small-8 columns daily-date daily-date-inbound-edit">
				<span id="schedule_inbound"></span> &nbsp;<a href="#!" title="Change Date" id="change-date-btn-inbound-edit"><i class="fa fa-calendar"></i></a>
				<input type="hidden" name="schedule" id="schedule_val_inbound">
			</div>
			<span class="text-danger">{{ $errors->first('schedule') }}</span>
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


	<div style="color:red" class="alert alert-danger" role="alert" id="adiv">
		
	</div>

	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<!-- Inbound Shipping -->
<div class="row" style="max-width:100%;">
	<div class="column small-12">
		{{-- <a href="{{ URL::to('fs/inbound?d='.date('Y-m-d', strtotime($date))) }}">View full screen display</a> --}}
		<div class="column small-12 light-box margin-top-20">
			<span>Inbound Shipping Schedule</span>
			@if( Auth::user()->is_admin )
			@if ($date == date('l F j, Y') || strtotime($date) > strtotime(date('l F j, Y')))
			<a href="#" class="right inbound-shipping-new-entry-btn" data-reveal-id="inbound_shipping_modal"><i class="fa fa-plus"></i> New Entry</a>
			@endif
			@endif
			<span id="date-text"> - {{ $date }} &nbsp;
				<!-- <a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a> -->
			</span>
		</div>
		<div class="column small-12" style="overflow-x: scroll;padding: 0 !important;">
			<table class="responsive tcf-table">
				<thead>
					<tr>
						<th>Container Number</th>
						<th>Supplier</th>
						<th>Product</th>
						<th>KG</th>
						<th>Steamship Provider</th>
						<th>Arrival To Port</th>
						<th>Arrival To Destination</th>
						<th>Terminal Handling Fee Paid</th>
						<th>Pickup Location</th>
						<th>Pickup Appointment</th>
						<th>Return Location</th>
						<th>RV number</th>
						<th>Pickup number</th>
						<th>Actions</th>

					</tr>
				</thead>
				<tbody>
					@foreach ($inbound_shipping as $inbound)
					<tr>
						<td class="fixed-width-outbound">{{ $inbound->container_number }}</td>
						<td class="fixed-width-outbound">{{ $inbound->supplier }}</td>
						<td class="fixed-width-outbound">{{ $inbound->product }}</td>
						<td>{{ $inbound->kg }}</td>
						<td>{{ $inbound->steamship_provider }}</td>
						<td>{{ date('d/m/Y', strtotime($inbound->arrival_to_port) ) }}</td>
						<td>{{ date('d/m/Y', strtotime($inbound->arrival_to_destination) )}}</td>
						<td>{{ $inbound->terminal_handling_fee_paid ? 'Yes' : 'No' }}</td>
						<td>{{ $inbound->pickup_location }}</td>
						<td>{{ date('d/m/Y h:i a', strtotime($inbound->pickup_appointment) ); }} </td>
						<td>{{ $inbound->return_location }}</td>
						<td>{{ $inbound->rv_no }}</td>
						<td>{{ $inbound->pickup_no }}</td>
						<td data-id="{{ $inbound->id }}">
							@if( Auth::user()->is_admin )
							<a class="edit-inbound-shipping-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
							<a class="delete-inbound-shipping-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
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
<div id="inbound_shipping_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	<h2 id="modalTitle">Inbound Shipping</h2>
	<p class="lead">First Step</p>
	<form id="inbound-shipping-form">
		{{ Form::label('inbound_container_number', 'Container number') }}
		{{ Form::text('inbound_container_number', '', ['placeholder' => 'Container number', 'class' => 'repetitive']) }}

		{{ Form::label('inbound_supplier', 'Supplier number') }}
		{{ Form::text('inbound_supplier', '', ['placeholder' => 'Supplier number', 'class' => 'repetitive']) }}


		{{ Form::label('inbound_product', 'Product') }}
		{{ Form::text('inbound_product', '', ['placeholder' => 'Product', 'class' => 'repetitive']) }}


		{{ Form::label('inbound_kg', 'KG') }}
		{{ Form::number('inbound_kg', '', ['placeholder' => 'KG']) }}


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

		{{ Form::label('inbound_rv_number', 'RV number') }}
		{{ Form::number('inbound_rv_number', '', ['placeholder' => 'RV number']) }}

		{{ Form::label('inbound_pickup_number', 'Pickup number') }}
		{{ Form::number('inbound_pickup_number', '', ['placeholder' => 'Pickup number']) }}
		<a href="#" id="create-inbound-shipping-btn" class="button expand" data-action="create">Create</a>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>



@stop
@section('custom-js')
{{ HTML::script('assets/plugins/stupidtable.js') }}


<script type="text/javascript">
	//start of outbound
	$(document).on('close.fndtn.reveal', '[data-reveal]', function() {
		$('#outbound1-form').trigger('reset');
	});

	$(document).ready(function() {

		$('#change-date-btn-edit').datetimepicker({
			onGenerate: function() {

				$(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "",
			format: 'Y-m-d',
			onSelectDate: function($date) {
				var day = $date.getDate();
				var month = $date.getMonth() + 1;
				var year = $date.getFullYear();
				if (day < 10) {
					day = "0" + day;
				}
				if (month < 10) {
					month = "0" + month;
				}
				$("#schedule_val").val(year + '-' + month + '-' + day);
				$(".daily-date-edit").find("span").html(year + '-' + month + '-' + day);
			}
		});

		$('input[name="outbound_start_time"], input[name="edit_outbound_start_time"], input[name="edit_start_time"], input[name="outbound_dock_time"], input[name="edit_outbound_dock_time"]').datetimepicker({
			datepicker: false,
			format: 'h:i a'
		});

		//insert
		$('#create1-btn').click(function(event) {
			event.preventDefault();
			form = $('#outbound1-form'),
				carrier = $('input[name="outbound_carrier"]'),
				driver = $('input[name="outbound_driver"]'),
				truck = $('input[name="outbound_truck"]'),
				trailer = $('input[name="outbound_trailer_number"]'),
				start_time = $('input[name="outbound_start_time"]');
			region = $('input[name="outbound_region"]');

			fields = {
				outbound_carrier: carrier.val(),
				outbound_driver: driver.val(),
				outbound_truck: truck.val(),
				outbound_trailer_number: trailer.val(),
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
					console.log(response);

					//firat step
					var temp_schedule = response.created_at;
					var schedule = temp_schedule.slice(0, 10);
					if (response.schedule) {
						schedule = response.schedule;
					}
					$('input[name="edit_outbound_carrier"]').val(response.outbound_carrier);
					$('input[name="edit_outbound_driver"]').val(response.outbound_driver);
					$('input[name="edit_outbound_truck"]').val(response.outbound_truck);
					$('input[name="edit_outbound_trailer_number"]').val(response.outbound_trailer_number);
					$('input[name="edit_outbound_start_time"]').val(response.outbound_start_time);
					$('#schedule').text(schedule);
					$('#schedule_val').val(schedule);
					$('input[name="edit_outbound_region"]').val(response.outbound_region);
					$('#update-btn').attr('data-id', response.id);
				}
			});

			var count = $(this).closest(".outbound-box").find('.tcf-table > tbody').children('tr').length;

			if (count) {
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
				outbound_trailer_number: $('input[name="edit_outbound_trailer_number"]').val(),
				outbound_start_time: $('input[name="edit_outbound_start_time"]').val(),
				outbound_region: $('input[name="edit_outbound_region"]').val(),
				created_at: $('#schedule_val').val()
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
				outbound_customer_po: $('input[name="outbound_customer_po"]').val(),
				outbound_location: $('input[name="outbound_location"]').val(),
				outbound_order_number: $('input[name="outbound_order_number"]').val(),
				outbound_pick_status: $('#outbound_pick_status').val(),
				outbound_skids: $('input[name="outbound_skids"]').val(),
				user_id: '{{ Auth::user()->id }}'
			};

			if (fields.outbound_dock_time != '' || fields.outbound_customer != '' || fields.outbound_customer_po != '' || fields.outbound_location != '' || fields.outbound_order_number != '' || fields.outbound_pick_status != '') {

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
					$('input[name="edit_outbound_customer_po"]').val(response.outbound_customer_po);
					$('input[name="edit_outbound_location"]').val(response.outbound_location);
					$('input[name="edit_outbound_order_number"]').val(response.outbound_order_number);
					$('input[name="edit_outbound_pick_status"]').val(response.outbound_pick_status);
					$('input[name="edit_outbound_skids"]').val(response.outbound_skids);
					$('input[name="edit_created_at"]').val('02/18/1998');
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
				outbound_customer_po: $('input[name="edit_outbound_customer_po"]').val(),
				outbound_location: $('input[name="edit_outbound_location"]').val(),
				outbound_order_number: $('input[name="edit_outbound_order_number"]').val(),
				outbound_pick_status: $('#edit_outbound_pick_status').val(),
				outbound_skids: $('#edit_outbound_skids').val(),
				created_at: $('#edit_created_at').val(),
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
			timepicker: false,
			value: "{{ Input::get('d') }}",
			format: 'Y-m-d',
			onSelectDate: function($date) {
				window.location.href = '{{ URL::to("inbound_outbound") }}?d=' + $date.dateFormat('Y-m-d');
			}
		});


		$(".up,.down").click(function() {
			var row = $(this).parents("tr:first");
			var counter = 1;
			var array_data = [];

			if ($(this).is(".up")) {
				row.insertBefore(row.prev());
			} else {
				row.insertAfter(row.next());
			}

			$(".sort-number").each(function(key, value) {
				array_data.push([$(value).attr("data-id"), key + 1]);
			});

			$.ajax({
				type: "POST",
				data: {
					_token: '{{ csrf_token() }}',
					data: array_data
				},
				url: '{{ URL::to("outbound_schedule/sortNumber") }}',
				success: function(data) {
					console.log(data);
					return false;
				}

			});
		});


	}); //end document
	//end of outbound 


	//start of inbound
	$(document).on('close.fndtn.reveal', '[data-reveal]', function() {
		$('#inbound-form').trigger('reset');
	});

	$(document).ready(function() {
		$('#change-date-btn-inbound-edit').datetimepicker({
			onGenerate: function() {

				$(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "",
			format: 'Y-m-d',
			onSelectDate: function($date) {
				var day = $date.getDate();
				var month = $date.getMonth() + 1;
				var year = $date.getFullYear();
				if (day < 10) {
					day = "0" + day;
				}
				if (month < 10) {
					month = "0" + month;
				}
				$("#schedule_val_inbound").val(year + '-' + month + '-' + day);
				$(".daily-date-inbound-edit").find("span").html(year + '-' + month + '-' + day);
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
		$('.new-entry-btn').click(function() {
			$("#schedule_val_inbound").val("{{ Input::get('d') }}");
			$(".daily-date-inbound-edit").find("span").html("{{ Input::get('d') }}");
			$('#create-btn').text('Create');
		});

		//create
		$('#create-btn').click(function(event) {
			event.preventDefault();


			form = $('#inbound-form'),

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
				schedule: $('#schedule_val_inbound').val(),
				inbound_customer_po: $('input[name="inbound_customer_po"]').val(),
				inbound_delivery_option: $("input[name='inbound_delivery_option']:checked").val(),
			};

			// if (action == 'create') {
			// 	if (fields.outbound_carrier == null) {

			// 		event.preventDefault();

			// 		$('#inbound-form').bootstrapValidator({
			// 			feedbackIcons: {
			// 				valid: 'glyphicon glyphicon-ok',
			// 				invalid: 'glyphicon glyphicon-remove',
			// 				validating: 'glyphicon glyphicon-refresh'
			// 			},
			// 			fields: {
			// 				inbound_kg: {
			// 					validators: {
			// 						notEmpty: {
			// 							message: 'The username is required'
			// 						}
			// 					}
			// 				},

			// 			}
			// 		});


			// 	}
			// }

			// if (fields.inbound_vendor != '' || fields.inbound_po_number != '' || fields.inbound_carrier != '' || fields.inbound_product != '' || fields.inbound_cases != '' || fields.inbound_kg != '' || fields.inbound_eta != '') 
			// {

			repetitive = getRepetitive();


			if (action == 'create') {


				if ( $('#schedule_val_inbound').val() == '' || fields.inbound_vendor == '' || fields.inbound_po_number == '' || fields.inbound_carrier == '') {

					// 	alert("asdadas");
					// 	$('#inbound-form').bootstrapValidator({
					// 	feedbackIcons: {
					// 		valid: 'glyphicon glyphicon-ok',
					// 		invalid: 'glyphicon glyphicon-remove',
					// 		validating: 'glyphicon glyphicon-refresh'
					// 	},
					// 	fields: {
					// 		inbound_vendor: {
					// 			validators: {
					// 				notEmpty: {
					// 					message: 'The username is required'
					// 				}
					// 			}
					// 		},

					// 	}
					// });
					$('#adiv').html("Please fill in empty fields!!!");

				} else {

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


							window.location.reload();
							$('#inbound_modal').foundation('reveal', 'close');
							new_row = $('<tr>' +
								'<td>' + response.inbound_vendor + '</td>' +
								'<td>' + response.inbound_po_number + '</td>' +
								'<td>' + response.inbound_customer_po + '</td>' +
								'<td>' + response.inbound_carrier + '</td>' +
								'<td>' + fields.inbound_product + '</td>' +
								'<td>' + fields.inbound_kg + '</td>' +
								'<td>' + fields.inbound_cases + '</td>' +
								'<td>' + fields.inbound_eta + '</td>' +
								'<td>' + response.inbound_delivery_option + '</td>' +
								'<td data-id="' + response.id + '">' +
								'<a class="edit-inbound-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
								'<a class="delete-inbound-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
								'</td>' +
								'</tr>');


							$(new_row).hide().appendTo('.tcf-table').fadeIn(300);
							form.trigger('reset');
						}
					});
				}



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
						window.location.reload();
						$('td[data-id="' + id + '"]').parent('tr').html('' +
							'<td>' + response.inbound_vendor + '</td>' +
							'<td>' + response.inbound_po_number + '</td>' +
							'<td>' + response.inbound_customer_po + '</td>' +
							'<td>' + response.inbound_carrier + '</td>' +
							'<td>' + fields.inbound_product + '</td>' +
							'<td>' + fields.inbound_kg + '</td>' +
							'<td>' + fields.inbound_cases + '</td>' +
							'<td>' + fields.inbound_eta + '</td>' +
							'<td>' + response.inbound_delivery_option + '</td>' +
							'<td data-id="' + response.id + '">' +
							'<a class="edit-inbound-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
							'<a class="delete-inbound-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
							'</td>' +
							'');
						$('#inbound_modal').foundation('reveal', 'close');

					}
				});
			}



		});

		//delete
		$('body').on('click', '.delete-inbound-btn', function(event) {
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
		$('body').on('click', '.edit-inbound-btn', function(event) {

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
					var temp_schedule = response.created_at;
					var schedule = temp_schedule.slice(0, 10);
					if (response.schedule) {
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
					$('#schedule_inbound').text(schedule);
					$('#schedule_val_inbound').val(schedule);

					if (response.inbound_delivery_option) {
						if (response.inbound_delivery_option == 'pickup') {
							$("#pick_up").attr('checked', 'checked');
						} else if (response.inbound_delivery_option == 'delivery') {
							$("#delivery").attr('checked', 'checked');
						}
					}
				}
			});

			$('#inbound_modal').foundation('reveal', 'open');
		});

		//sort table
		$('.tcf-table').stupidtable();

		//change date
		// $('#change-date-btn').datetimepicker({
		// 	onGenerate:function(){
		// 	    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
		// 	},
		// 	timepicker: false,
		// 	value: "{{ Input::get('d') }}",
		// 	format: 'Y-m-d',
		// 	onSelectDate:function($date){
		// 		window.location.href = '{{ URL::to("inbound_outbound") }}?d=' + $date.dateFormat('Y-m-d');
		// 	}
		// });

	}); //end document ready
	//end of inbound




	//start of inbound shipping
	$(document).on('close.fndtn.reveal', '[data-reveal]', function() {
		$('#inbound-shipping-form').trigger('reset');
	});

	$(document).ready(function() {

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
		$('.inbound-shipping-new-entry-btn').click(function() {
			$('#create-inbound-shipping-btn').text('Create');
		});

		//create
		$('#create-inbound-shipping-btn').click(function(event) {
			event.preventDefault();
			form = $('#inbound-shipping-form'),

				action = $(this).attr('data-action');

			fields = {
				container_number: $('input[name="inbound_container_number"]').val(),
				supplier: $('input[name="inbound_supplier"]').val(),
				product: $('input[name="inbound_product"]').val(),
				kg: $('input[name="inbound_kg"]').val(),
				steamship_provider: $('input[name="inbound_steamship_provider"]').val(),
				arrival_to_port: $('input[name="inbound_arrival_to_port"]').val(),
				arrival_to_destination: $('input[name="inbound_arrival_to_destination"]').val(),
				terminal_handling_fee_paid: $('input[name="inbound_terminal_handling_fee_paid"]:checked').val(),
				pickup_location: $('input[name="inbound_pickup_location"]').val(),
				pickup_appointment: $('input[name="inbound_pickup_appointment"]').val(),
				return_location: $('input[name="inbound_return_location"]').val(),
				rv_no: $('input[name="inbound_rv_number"]').val(),
				pickup_no: $('input[name="inbound_pickup_number"]').val(),
			};

			console.log(fields);

			if (fields.inbound_container_number != '' || fields.inbound_supplier != '' || fields.inbound_product != '' || fields.inbound_kg != '' || fields.inbound_steamship_provider != '' || fields.inbound_arrival_to_port != '' || fields.inbound_arrival_to_destination != '') {

				repetitive = getRepetitive();

				if (action == 'create') {
					// insert
					$.ajax({
						type: 'post',
						url: '{{ URL::to("inbound_shipping/insert") }}',
						data: {
							fields: fields,
							_token: '{{ csrf_token() }}',
							repetitive: repetitive
						},
						dataType: 'json',
						success: function(response) {
							console.log(response);
							window.location.reload();
							$('#inbound_shipping_modal').foundation('reveal', 'close');
							new_row = $('<tr>' +

								'<td>' + fields.container_number + '</td>' +
								'<td>' + fields.supplier + '</td>' +
								'<td>' + fields.product + '</td>' +
								'<td>' + fields.kg + '</td>' +
								'<td>' + fields.steamship_provider + '</td>' +
								'<td>' + moment(fields.arrival_to_port).format('DD/MM/YYYY') + '</td>' +
								'<td>' + moment(fields.arrival_to_destination).format('DD/MM/YYYY') + '</td>' +
								'<td>' + (fields.terminal_handling_fee_paid ? 'Yes' : 'No') + '</td>' +
								'<td>' + fields.pickup_location + '</td>' +
								'<td>' + moment(fields.pickup_appointment).format('DD/MM/YYYY hh:mm a') + '</td>' +
								'<td>' + fields.return_location + '</td>' +
								'<td>' + fields.rv_no + '</td>' +
								'<td>' + fields.pickup_no + '</td>' +

								//'<td>'+fields.inbound_eta+'</td>' +
								'<td data-id="' + response.id + '">' +
								'<a class="edit-inbound-shipping-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
								'<a class="delete-inbound-shipping-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
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
						url: '{{ URL::to("inbound_shipping/update") }}',
						data: {
							id: id,
							fields: fields,
							_token: '{{ csrf_token() }}',
							repetitive: repetitive
						},
						dataType: 'json',
						success: function(response) {
							window.location.reload();
							console.log(response);
							$('td[data-id="' + id + '"]').parent('tr').html('' +

								'<td>' + fields.container_number + '</td>' +
								'<td>' + fields.supplier + '</td>' +
								'<td>' + fields.product + '</td>' +
								'<td>' + fields.kg + '</td>' +
								'<td>' + fields.steamship_provider + '</td>' +
								'<td>' + moment(fields.arrival_to_port).format('DD/MM/YYYY') + '</td>' +
								'<td>' + moment(fields.arrival_to_destination).format('DD/MM/YYYY') + '</td>' +
								'<td>' + (fields.terminal_handling_fee_paid ? 'Yes' : 'No') + '</td>' +
								'<td>' + fields.pickup_location + '</td>' +
								'<td>' + moment(fields.pickup_appointment).format('DD/MM/YYYY hh:mm a') + '</td>' +
								'<td>' + fields.return_location + '</td>' +
								'<td>' + fields.rv_no + '</td>' +
								'<td>' + fields.pickup_no + '</td>' +

								//'<td>'+fields.eta+'</td>' +
								'<td data-id="' + response.id + '">' +
								'<a class="edit-inbound-shipping-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
								'<a class="delete-inbound-shipping-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
								'</td>' +
								'');
							$('#inbound_shipping_modal').foundation('reveal', 'close');
						}
					});
				}

			}

		});

		//delete
		$('body').on('click', '.delete-inbound-shipping-btn', function(event) {
			event.preventDefault();
			tr = $(this).closest('tr');
			id = $(this).parent().data('id');
			if (confirm('Delete confirmation')) {
				$.ajax({
					type: 'post',
					url: '{{ URL::to("inbound_shipping/delete") }}',
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
		$('body').on('click', '.edit-inbound-shipping-btn', function(event) {
			event.preventDefault();
			id = $(this).parent().data('id');

			$('#create-inbound-shipping-btn').attr('data-action', 'edit');
			$('#create-inbound-shipping-btn').text('Update');
			$('#create-inbound-shipping-btn').attr('data-id', id);
			$.ajax({
				type: 'post',
				url: '{{ URL::to("inbound_shipping/edit") }}',
				data: {
					id: id,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function(response) {
					console.log(response);
					$('#update-btn').attr('data-id', response.id);
					$('input[name="inbound_container_number"]').val(response.container_number);
					$('input[name="inbound_supplier"]').val(response.supplier);
					$('input[name="inbound_product"]').val(response.product);
					$('input[name="inbound_kg"]').val(response.kg);
					$('input[name="inbound_steamship_provider"]').val(response.steamship_provider);
					$('input[name="inbound_arrival_to_port"]').val(response.arrival_to_port);
					$('input[name="inbound_arrival_to_destination"]').val(response.arrival_to_destination);
					$('input[name="inbound_terminal_handling_fee_paid"][value="' + response.terminal_handling_fee_paid + '"]').prop("checked", true);;
					$('input[name="inbound_pickup_location"]').val(response.pickup_location);
					$('input[name="inbound_pickup_appointment"]').val(response.pickup_appointment);
					$('input[name="inbound_return_location"]').val(response.return_location);
					$('input[name="inbound_rv_number"]').val(response.rv_no);
					$('input[name="inbound_pickup_number"]').val(response.pickup_no);
				}
			});

			$('#inbound_shipping_modal').foundation('reveal', 'open');
		});

		//sort table
		$('.tcf-table').stupidtable();

	}); //end document ready
	//end of inbound shipping
</script>
{{ HTML::script('assets/plugins/datahistory.js') }}
@stop