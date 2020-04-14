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

	<div class="row">
		<div class="column small-12 light-box margin-top-20">
			<span>Data History</span>
		</div>
		<div class="column small-12 light-border">
			@if( Auth::user()->is_admin )
			<button id="clear-data-history-btn" class="secondary tiny margin-top-20">Clear Data History</button>
			<button id="remove-items-btn" class="secondary tiny margin-top-20" disabled>Remove Selected Items</button>
			@endif
			<ul class="no-bullet">	
				@foreach ($history as $data)
					<li data-id="{{ $data->id }}"><input type="checkbox" class="check-li" name="delete-item" id="delete{{ $data->id }}"><label for="{{ 'delete'.$data->id }}"><span class="data-field">{{ ucwords(str_replace('_',' ',$data->field)) }}</span></label> <span class="data-value">{{ $data->value }}</span></li>	
				@endforeach
			</ul>
		</div>
	</div>

@stop

@section('custom-js')

<script type="text/javascript">
	$(document).ready(function() {

		$('.check-li').click(function() {
			if ($('.check-li:checked').length > 0) {
				$('#remove-items-btn').prop('disabled', false);
			} else {
				$('#remove-items-btn').prop('disabled', true);
			}
		});

		$('#remove-items-btn').click(function() {
			ids = [];
			if (confirm('Remove selected items?')) {
				$('.check-li:checked').each(function() {
					ids.push($(this).closest('li').data('id'));
				});
				
				$.ajax({
					type: 'post',
					url: '{{ URL::to("data_history/delete") }}',
					data: {
						_token: '{{ csrf_token() }}',
						ids: ids
					},
					success: function() {
						$('.check-li:checked').closest('li').fadeOut(500);
					}
				});
			}

		});

		$('#clear-data-history-btn').click(function() {

			if (confirm('Clear data history?')) {
				$.ajax({
					type: 'post',
					url: '{{ URL::to("data_history/clear") }}',
					data: {
						_token: '{{ csrf_token() }}'
					},
					success: function() {
						$('.check-li').closest('li').fadeOut(300);
					}
				});
			}

		});

	});// end documenr ready
</script>

@stop