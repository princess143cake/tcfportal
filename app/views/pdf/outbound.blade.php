<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>test</title>
	<style type="text/css">
		.custom-tab{
			margin-left: 100px;
		}
		.t-number{
			margin-left: 40px;
		}
		table {
		  border: 1px solid black;
		  border-collapse: collapse;
		    width: 100%;

		}
		th {
  height: 50px;
}
	</style>	    
</head>
<body>
<h3>Route Details</h3>
<div>
	<div>
		<p>Carrier <span class="custom-tab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->outbound_carrier }}</span> </p>
		<p>Driver <span class="custom-tab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->outbound_driver }}</span> </p>
		<p>Truck <span class="custom-tab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->outbound_truck }}</span> </p>
		<p>Trailer Number <span class="custom-tab">: {{ $data->outbound_trailer_number }}</span> </p>
		<p>Start Time <span class="custom-tab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$data->outbound_start_time ? date('h:i a', $data->outbound_start_time) : '' }}</span> </p>
		<p>Region <span class="custom-tab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->outbound_region }}</span> </p>
	</div>
</div>
<hr>
<h3>Stops</h3>
@if($data->secondphase)
<table border="1">
	<thead>
		<tr>
			<th>Dock Time</th>
			<th>Customer</th>
			<th>Location</th>
			<th>Order No.</th>	
			<th>Skids</th>	
			<th>Pick Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data->secondphase as $stop)
			<tr>
				<td>{{ $stop->outbound_dock_time ? date('h:i a', $stop->outbound_dock_time) : '' }}</td>
				<td>{{ $stop->outbound_customer }}</td>
				<td>{{ $stop->outbound_location }}</td>
				<td>{{ $stop->outbound_order_number }}</td>
				<td>{{ $stop->outbound_skids }}</td>
				<td>{{ $stop->outbound_pick_status }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@endif
</body>
</html>