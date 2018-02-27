@extends('layouts.fullscreen')

@section('content')

<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ "Outbound Week Overview" }}</h4>


<div class="fs-daily" style="overflow-y:auto;">

@foreach($products as $key => $product)
    <div class="fs-weekly">
        <table class="responsive fs-table">
            <thead>
                <tr>
                    <th class="center-align" colspan="3" >{{date("l F j, Y", strtotime($key))}}</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($product))
                @foreach($product as $product_key => $product_value)
                    @if(!empty($product_value))
                <tr>
                    <td class="outbound-title fixed-width">DRIVER</td>
                    <td class="outbound-title fixed-width">TRUCK</td>
                    <td class="outbound-title fixed-width">START</td>
                </tr>
                <tr>
                    <td class="fixed-width">{{(!empty($product_value)) ? $product_value->outbound_driver : ''}}</td>
                    <td class="fixed-width">{{(!empty($product_value)) ? $product_value->outbound_truck : ''}}</td>
                    <td class="fixed-width">{{(!empty($product_value)) ? date("h:i a", $product_value->outbound_start_time) : ''}}</td>
                </tr>
                <tr>
                    <td class="outbound-title fixed-width">STOPS</td>
                    <td class="outbound-title fixed-width">REGION</td>
                    <td class="outbound-title fixed-width">&nbsp;</td>
                </tr>
                <tr>
                    <td class="fixed-width">{{(!empty($product_value)) ? count($product_value->secondphase) : ''}}</td>
                    <td class="fixed-width">{{(!empty($product_value)) ? $product_value->outbound_region : ''}}</td>
                    <td class="fixed-width">&nbsp;</td>
                </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endforeach

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
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_weekly") }}',
          '{{ URL::to("fsf/inbound_weekly") }}'
        ];
        var rotation_2 = [
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_v2") }}',
          '{{ URL::to("fsf/inbound_v2") }}',
          '{{ URL::to("fsf/outbound_weekly") }}',
          '{{ URL::to("fsf/inbound_weekly") }}'
        ];
      } else {
        var rotation = [
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound_weekly") }}',
          '{{ URL::to("fs/inbound_weekly") }}'
        ];
        var rotation_2 = [
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound") }}',
          '{{ URL::to("fs/inbound") }}',
          '{{ URL::to("fs/outbound_weekly") }}',
          '{{ URL::to("fs/inbound_weekly") }}'
        ];
      }

      var next_rotation = rotation_2.indexOf('{{Request::fullURL() }}') + 1;
      if(next_rotation >= rotation.length +1) next_rotation = 0;
      window.location = rotation[next_rotation];
    }, 20000);

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