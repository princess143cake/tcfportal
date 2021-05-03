@extends('layouts.fullscreen')

@section('title'){{ 'Outbound Schedule' }}@stop

@section('custom-css')
<style type="text/css">
  .point {
    cursor: pointer !important;
  }

  .outbound-box {
    border: 4px solid #8D191C;
    padding: 10px;
  }
</style>
@stop

@section('content')
<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ $date }} Outbound Schedule</h4>
<div class="fs-daily" style="overflow-y:auto;">
  @foreach ($outbounds as $row)
  <div class="large-12 column outbound-box margin-top-20">
    <div class="large-2 column">
      <h5 class="fs-h5">Route</h5>
      <span class="route-text fixed-width-outbound">Carrier: {{ $row->outbound_carrier }}</span>
      <span class="route-text fixed-width-outbound">Driver: {{ $row->outbound_driver }}</span>
      <span class="route-text cell-font-size">Start Time: {{ $row->outbound_start_time ? date('h:i a', $row->outbound_start_time) : '' }}</span>
      <span class="route-text fixed-width-outbound">Truck: {{ $row->outbound_truck }}</span>
      <span class="route-text fixed-width-outbound">Region: {{ $row->outbound_region }}</span>
    </div>

    <div class="large-10 column">
      <h5 class="fs-h5">Stops</h5>
      @if ($row->secondphase->toArray())
      <table class="fs-table">
        <thead>
          <tr>
            <th class="point" data-sort="string">Customer <i class=""></i></th>
            <th class="point" data-sort="string">Location <i class=""></i></th>
            <th class="point" data-sort="string">Customer Po<i class=""></i></th>
            <th class="point" data-sort="int">Order No. <i class=""></i></th>
            <th class="point" data-sort="int">Dock Time <i class=""></i></th>
            <th class="point" data-sort="string">Skids <i class=""></i></th>
            <th class="point" data-sort="string">Pick Status <i class=""></i></th>

          </tr>
        </thead>
        <tbody>
          @foreach ($row->secondphase as $second)
          <tr>

            <td class="fixed-width-outbound">{{ $second->outbound_customer }}</td>
            <td class="fixed-width-outbound">{{ $second->outbound_location }}</td>
            <td class="fixed-width-outbound">{{ $second->outbound_customer_po }}</td>
            <td class="fixed-width-outbound">{{ $second->outbound_order_number }}</td>
            <td class="cell-font-size">{{ $second->outbound_dock_time ? date('h:i a', $second->outbound_dock_time) : '' }}</td>
            <td class="cell-font-size">{{ $second->outbound_skids }}</td>
            <td class="cell-font-size">{{ $second->outbound_pick_status }}</td>

          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <table class="fs-table" style="border:none !important">
        <tbody>
          <tr>
            <td colspan="5">No stops yet.</td>
          </tr>
        </tbody>
      </table>
      @endif
    </div>
  </div>
  @endforeach
</div>

<br>
<br>
<br>
<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ $date }} Inbound Schedule</h4>
<div class="fs-daily" style="overflow-y:auto;">
  <table class="fs-table responsive margin-top-20">
    <thead>
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
    </thead>
    <tbody>
      @foreach ($inbounds as $inbound)
      <tr>
        <td class="fixed-width-outbound">{{ $inbound->inbound_vendor }}</td>
        <td class="fixed-width-outbound">{{ $inbound->inbound_po_number }}</td>
        <td class="fixed-width-outbound">{{ $inbound->inbound_customer_po }}</td>
        <td class="fixed-width-outbound">{{ $inbound->inbound_carrier }}</td>
        <td class="fixed-width-outbound">{{ $inbound->inbound_product }}</td>
        <td class="cell-font-size">{{ $inbound->inbound_cases }}</td>
        <td class="cell-font-size">{{ $inbound->inbound_kg }}</td>
        <td class="cell-font-size">{{ date('h:i a', $inbound->inbound_eta) }}</td>
        <td class="fixed-width-outbound">{{ $inbound->inbound_delivery_option }}</td>
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

    //scrollme();

    function rotateme() {
      //setInterval(function() {
      var uricontroller = '{{Request::segment(1)}}';

      if (uricontroller == 'fsf') {
        var rotation = [
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_v2?d=".$nextday) }}',
          '{{ URL::to("fsf/inbound_v2?d=".$today) }}'
        ];
        var rotation_2 = [
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_v2?d=".$today) }}',
          '{{ URL::to("fsf/inbound_v2?d=".$nextday) }}'
        ];
      } else {
        var rotation = [
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound?d=".$nextday) }}',
          '{{ URL::to("fs/inbound?d=".$today) }}'
        ];
        var rotation_2 = [
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound?d=".$today) }}',
          '{{ URL::to("fs/inbound?d=".$nextday) }}'
        ];
      }

      var next_rotation = rotation_2.indexOf('{{Request::fullURL() }}') + 1;
      if (next_rotation > rotation.length + 1) next_rotation = 0;
      window.location = rotation[next_rotation];
      //}, 15000);
    }

    //autoscroll when it has many items
    autscrollscreen();

    function autscrollscreen() {
      var screen_height = $(window).height() - 120;
      var div_height = $(".fs-daily").height();
      var last_tr = $("tr:last").html();
      var scrollingUp = 0;

      if (div_height > screen_height) {
        $(".fs-daily").css("max-height", screen_height - 10 + "px");

        window.setInterval(scrollit, 20000);
      } else {
        window.setInterval(rotateme, 20000);
      }
      /*        var screen_height = screen.height;
              var scrollingUp   = 0;
              var div_height    = $(".fs-daily").height();

              $(".fs-daily").css("max-height", screen_height - 300 + "px");

              if(div_height > screen_height) {
                  window.setInterval(scrollit, 3000);

                  function scrollit() {
                      if(scrollingUp == 0) {
                          $('.fs-daily').delay(5000).animate({ scrollTop: $(".fs-daily").scrollTop() + 300 }, 'slow');
                          if($(".fs-daily").scrollTop() == $(".fs-daily")[0].scrollHeight - 600) {
                              //refresh page every 30 seconds
                              setInterval(function() {
                                rotateme();
                              }, 3000);
                          }
                      }
                  }
              }*/
    }

    function isOnScreen(element) {
      var curPos = element.offset();
      var curTop = curPos.top;
      var screenHeight = $(window).height();
      return (curTop + 100 > screenHeight) ? false : true;
    }

    function scrollit() {
      var screen_height = $(window).height() - 120;
      var div_height = $(".fs-daily").height();
      var last_tr = $("tr:last").html();
      var scrollingUp = 0;

      if (scrollingUp == 0) {
        if (isOnScreen($('tr:last'))) {
          rotateme();
        } else {
          $('.fs-daily').delay(0).animate({
            scrollTop: $(".fs-daily").scrollTop() + screen_height - 100
          }, 5000);
        }
      }
    }

  });
</script>
@stop