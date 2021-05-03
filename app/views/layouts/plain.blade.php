@yield('content')
@section('custom-js')
	<script type="text/javascript">
	$(document).ready(function() {
		$('#side-nav ul li a, .left-off-canvas-menu ul li a').hover(function() {
			$(this).addClass('hover-side-nav');
		}, function() {
			$(this).removeClass('hover-side-nav');
		});
	});
	</script>
@stop

@include('layouts.scripts')
