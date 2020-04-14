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

@stop

@section('content')
<form method="GET" action="report/filter-company-incompletes"></form>

	<div class="column small-12 light-box margin-top-20">
		<div class="small columns">
			<input type="hidden" name="d" id="d" value="{{ $date }}">
		<span>Select Action</span>
			<select name="option" id="option">							
				<option value="0">Please select action</option>
				<option value="inbound_shipping">Inbound Shipping</option>
				<option value="outbound_schedule">Outbound Schedule</option>
				<option value="inbound_schedule">Inbound Schedule</option>
			</select>
		</div>
	</div>

</form>

<div class="input-field col s12 m4" id="department-select-div">

</div>


@stop

@section('custom-js')
<script type="text/javascript">
	$("#option").change(function(){
		var option = $(this).val();
		var d = $('#d').val();

		$.ajax({
			type: "GET",
			url:"ajax/get/schedule",
			data:{
				option:option,
				d:d,
				_token: "{{ csrf_token() }}"
			},
			success: function(response){
				console.log(response);
				$("#department-select-div").html(response.view);
				$("#department-select option:first").attr('selected','selected');				
				$('#department-select').change();
			}
		});
	});
</script>

@stop