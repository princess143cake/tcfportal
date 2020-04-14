@extends('layouts.fullscreen')

@section('content')

<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ $date }}</h4>

<div class="fs-daily" style="overflow-y:auto;">
    <table class="fs-table responsive margin-top-20">
        <thead>
            <tr>
                <th class="production-header">PRODUCT</th>
                <th class="production-header">CUSTOMER</th>
                <th class="production-header">PACK SIZE</th>
                <th class="production-header">PROD SIZE</th>
                <th class="production-header">CASES</th>
                <th class="production-header">SKIDS</th>
                <th class="production-header">SHIFT</th>
                <th class="production-header">STATUS</th>
                <th class="production-header">NOTES</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($products))
                @foreach($products as $key => $value)
            <tr id="row-id-{{$value->id}}">
                <td class="product-product fixed-width">{{$value->production_product}}</td>
                <td class="product-customer fixed-width">{{$value->production_customer}}</td>
                <td class="product-pack-size cell-font-size">{{$value->production_pack_size}}</td>
                <td class="product-size cell-font-size">{{$value->production_product_size}}</td>
                <td class="product-cases cell-font-size">{{$value->production_cases}}</td>
                <td class="product-skids cell-font-size">{{$value->production_skids}}</td>
                <td class="product-shift cell-font-size">{{$value->production_shift}}</td>
                <td class="product-status cell-font-size">{{$value->production_status}}</td>
                <td class="product-notes fixed-width">{{$value->production_notes}}</td>
            </tr>
                @endforeach
            @else
            <tr class="production-empty">
                <td colspan="10">No Data</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@stop

@section('custom-js')
<script type="text/javascript">
  $(document).ready(function() {
    //refresh page every 30 seconds
    setInterval(function() {
        //alert('{{$date}}');

        var next_action = '{{$next_action}}';

        var uricontroller = '{{Request::segment(1)}}';

        if(next_action == 'weekly') {
            if(uricontroller == 'fsf') {
                window.location.href = '{{ URL::to("fsf/production_weekly_v2") }}'
            } else {
                window.location.href = '{{ URL::to("fs/production_weekly") }}'
            }
        } else {
            if(uricontroller == 'fsf') {
                window.location.href = '{{ URL::to("fsf/production_daily_v2") }}?next-action='+ "next_day";
            } else {
                window.location.href = '{{ URL::to("fs/production_daily") }}?next-action='+ "next_day";
            }
        }

      //location.reload();
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