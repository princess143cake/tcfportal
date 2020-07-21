@extends('layouts.default')

@section('title'){{ 'Home' }}@stop

@section('content')
	
	<div class="row" style="min-width: 100%">
		<div class="column small-12">
			<h5 class="font-gray" id="current-date">Schedules for today {{ $current_date }}</h5>
			<div class="row">
				<div class="column small-11 small-centered large-4 large-uncentered home-box">
					<a href="{{ URL::to('fs/production_daily') }}"class="home-btn">
						<div class="home-circle prod-circle">
							<i class="fa fa-calendar fa-2x"></i>
						</div>

						<span class="home-btn-text">
							<h4>{{ $production_count }}</h4>
							PRODUCTION ENTRIES
						</span>
					</a>	
				</div>
				<div class="column small-11 small-centered large-4 large-uncentered home-box">
					<a href="{{ URL::to('fs/outbound') }}" class="home-btn">
						<div class="home-circle outb-circle ">
							<i class="fa fa-truck fa-2x"></i>
						</div>

						<span class="home-btn-text">
							<h4>{{ $outbound_count }}</h4>
							OUTBOUND/INBOUND ENTRIES
						</span>
					</a>	
				</div>
				
			</div>
			<div class="row">
				<div class="column small-12 light-box margin-top-20">
					<span>Most Recent Entries For Today</span>
				</div>
				<div class="column small-12 light-border">
					<br>
					
					@if ($activities->toArray())
						@foreach ($activities as $activity)
							@if ($activity->type != 'production')
								<p class="font-small"><b>{{ User::find($activity->user_id)->name }}</b> created a new <a href="{{ URL::to('/inbound_outbound') }}">{{ $activity->type }} schedule</a> <span data-livestamp="{{ strtotime($activity->created_at) }}"></span>.</p>
							@else
								@if(!empty(User::find($activity->user_id)->name))
									<p class="font-small"><b>{{ User::find($activity->user_id)->name }}</b> created a new <a href="{{ URL::to('production?product-date=').date('Y-m-d') }}">{{ $activity->type }} schedule</a> <span data-livestamp="{{ strtotime($activity->created_at) }}"></span>.</p>
								@endif
							@endif
						@endforeach
					@else
						<h5>No entries yet.</h5>	
					@endif
				</div>
			</div>
		</div>
	</div>	

@stop