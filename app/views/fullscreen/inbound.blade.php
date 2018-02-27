@extends('layouts.fullscreen')

@section('title'){{ 'Inbound Schedule' }}@stop

@section('custom-css')
  <style type="text/css">
    .point {
      cursor: pointer !important;
    }
  </style>
@stop

@section('content')

<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ $date }} Inbound Schedule</h4>
<div class="fs-daily" style="overflow-y:auto;">
    <table class="fs-table responsive margin-top-20">
        <thead>
            <tr>
              <th>Vendor</th>
              <th>PO#</th>
              <th>Carrier</th>
              <th>Product</th>
              <th>KG</th>
              <th>SKIDS</th>
              <th class="point" data-sort="int">ETA <i class=""></i></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($inbounds as $inbound)
              <tr>
                <td class="fixed-width-outbound">{{ $inbound->inbound_vendor }}</td>
                <td class="fixed-width-outbound">{{ $inbound->inbound_po_number }}</td>
                <td class="fixed-width-outbound">{{ $inbound->inbound_carrier }}</td>
                <td class="fixed-width-outbound">{{ $inbound->inbound_product }}</td>
                <td class="cell-font-size">{{ $inbound->inbound_cases }}</td>
                <td class="cell-font-size">{{ $inbound->inbound_kg }}</td>
                <td class="cell-font-size">{{ date('h:i a', $inbound->inbound_eta) }}</td>
              </tr>
            @endforeach
        </tbody>

    </table>
</div>

@stop

@section('custom-js')
{{ HTML::script('assets/plugins/stupidtable.js') }}
<script type="text/javascript">
  $(document).ready(function() {
      //sort table
    $('.fs-table').stupidtable();

    //refresh page every 30 seconds
    setInterval(function() {
      var uricontroller = '{{Request::segment(1)}}';

      if(uricontroller == 'fsf') {
        var rotation = [
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_v2?d=".$nextday) }}',
          '{{ URL::to("fsf/inbound_v2?d=".$today) }}',
          '{{ URL::to("fsf/outbound_weekly") }}'
        ];
        var rotation_2 = [
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_v2?d=".$today) }}',
          '{{ URL::to("fsf/inbound_v2?d=".$nextday) }}',
          '{{ URL::to("fsf/outbound_weekly") }}'
        ];
      } else {
        var rotation = [
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound?d=".$nextday) }}',
          '{{ URL::to("fs/inbound?d=".$today) }}',
          '{{ URL::to("fs/outbound_weekly") }}'
        ];
        var rotation_2 = [
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound?d=".$today) }}',
          '{{ URL::to("fs/inbound?d=".$nextday) }}',
          '{{ URL::to("fs/outbound_weekly") }}'
        ];
      }

      var next_rotation = rotation_2.indexOf('{{Request::fullURL() }}') + 1;
      if(next_rotation > rotation.length +1) next_rotation = 0;
      window.location = rotation[next_rotation];
    }, 30000);

    //autoscroll when it has many items
    autscrollscreen();

    function autscrollscreen() {
        var screen_height = screen.height;
        var scrollingUp   = 0;
        var div_height    = $(".fs-daily").height();

        $(".fs-daily").css("max-height", screen_height - 20);

        if(div_height > screen_height) {
            window.setInterval(scrollit, 3000);

            function scrollit() {
                if(scrollingUp == 0) {
                    $('.fs-daily').delay(5000).animate({ scrollTop: $(".fs-daily").scrollTop() + 100 }, 'slow');
                }
            }
        }
    }

  });
</script>
@stop