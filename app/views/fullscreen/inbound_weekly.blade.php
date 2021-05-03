@extends('layouts.fullscreen')

@section('content')

<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ "Inbound Week Overview" }}</h4>


<div class="fs-daily" style="overflow-y:auto;">

@foreach($products as $key => $product)
    <div class="fs-weekly">
        <table class="responsive fs-table">
            <thead>
                <tr>
                    <th class="center-align" colspan="3" >{{date("l F j, Y", strtotime($key))}}</th>
                </tr>
                <tr class="hover-day">
                    <th class="fixed-width">VENDORs</th>
                    <th class="fixed-width">PRODUCT</th>
                    <th class="fixed-width-xm">KG</th>
                </tr>
            </thead>
            <tbody>
                @for($row = 0; $row <= ($max_row - 1); $row++)
                    <tr>
                        <td class="fixed-width">{{(!empty($product[$row])) ? $product[$row]->inbound_vendor : ''}}</td>
                        <td class="fixed-width">{{(!empty($product[$row])) ? $product[$row]->inbound_product : ''}}</td>
                        <td class="fixed-width-xm">{{(!empty($product[$row])) ? $product[$row]->inbound_kg : ''}}</td>
                    </tr>
                @endfor
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
      if(next_rotation >= rotation.length) next_rotation = 0;
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