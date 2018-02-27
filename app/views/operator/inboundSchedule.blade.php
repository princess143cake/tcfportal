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
				@if ($date == date('l F j, Y') || strtotime($date) > strtotime(date('l F j, Y')))
					<a href="#" class="right new-entry-btn" data-reveal-id="inbound_modal"><i class="fa fa-plus"></i> New Entry</a>
				@endif
				<span id="date-text"> - {{ $date }} &nbsp;<a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>
			</div>

			<table class="responsive tcf-table">
				<thead>
					<tr>
						<th>Vendor</th>
						<th>PO#</th>
						<th>Carrier</th>
						<th>Product</th>
						<th>KG</th>
						<th>SKIDS</th>
						<th class="point" data-sort="int">ETA <i class="fa fa-sort"></i></th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($inbounds as $inbound)
						<tr>
							<td class="fixed-width-outbound">{{ $inbound->inbound_vendor }}</td>
							<td class="fixed-width-outbound">{{ $inbound->inbound_po_number }}</td>
							<td class="fixed-width-outbound">{{ $inbound->inbound_carrier }}</td>							
							<td class="fixed-width-outbound">{{ $inbound->inbound_product }}</td>
							<td>{{ $inbound->inbound_cases }}</td>
							<td>{{ $inbound->inbound_kg }}</td>
							<td>{{ $inbound->inbound_eta ? date('h:i a', $inbound->inbound_eta) : '' }}</td>
							<td data-id="{{ $inbound->id }}">
								<a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
								<a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	{{-- Modals --}}
	<div id="inbound_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Inbound Schedule</h2>
		<p class="lead">First Step</p>
			<form id="inbound-form">
				{{ Form::label('inbound_vendor', 'Vendor') }}
				{{ Form::text('inbound_vendor', '', ['placeholder' => 'Vendor', 'class' => 'repetitive']) }}

				{{ Form::label('inbound_po_number', 'PO#') }}
				{{ Form::text('inbound_po_number', '', ['placeholder' => 'PO#', 'class' => 'repetitive']) }}

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

		$('input[name="inbound_eta"]').datetimepicker({
			datepicker: false,
			format: 'h:i a'
		});

		$('.new-entry-btn').click(function(){
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
				date: '{{ $date }}'
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
								'<td>'+fields.inbound_cases+'</td>' +
								'<td>'+fields.inbound_kg+'</td>' +
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
								'<td>'+fields.inbound_cases+'</td>' +
								'<td>'+fields.inbound_kg+'</td>' +
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
				$('input[name="inbound_vendor"]').val(response.inbound_vendor);
				$('input[name="inbound_po_number"]').val(response.inbound_po_number);
				$('input[name="inbound_carrier"]').val(response.inbound_carrier);
				$('input[name="edit_start_time"]').val(response.outbound_start_time);
				$('input[name="inbound_product"]').val(response.inbound_product);
				$('input[name="inbound_cases"]').val(response.inbound_cases);
				$('input[name="inbound_kg"]').val(response.inbound_kg);
				$('input[name="inbound_eta"]').val(response.inbound_eta);
				$('#update-btn').attr('data-id', response.id);
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