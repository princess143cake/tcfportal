@extends('layouts.login')

@section('title'){{ 'Login' }}@stop

@section('content')
	
	<div class="row">
		<div class="column large-5 large-centered margin-top-100 text-center">
			<h3>TCF Scheduler Application</h3>
			<div class="column large-10 large-centered">	
				<form action="{{ URL::to('login') }}" method="post">
					{{ Form::text('username', null, ['placeholder' => 'Username', 'autofocus' => '']) }}
					{{ Form::password('password', ['placeholder' => 'Password']) }}
					
					{{-- Error login --}}
					@if ($errors->first())
						<span class="error">{{ $errors->first() }}</span>	
					@endif

					<button class="button expand">LOG IN</button>
				</form>
			</div>
		</div>
	</div>

@stop