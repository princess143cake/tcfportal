@extends('layouts.fullscreen')

@section('content')

<h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ "Production Week Overview" }}</h4>


<div class="fs-daily" style="overflow-y:auto;">

@foreach($products as $key => $product)
    <div class="fs-weekly">
        <table class="responsive fs-table">
            <thead>
                <tr>
                    <th class="center-align" colspan="3" >{{date("l F j, Y", strtotime($key))}}</th>
                </tr>
                <tr class="hover-day">
                    <th class="fixed-width">PRODUCT</th>
                    <th class="fixed-width">CUSTOMER</th>
                    <th class="fixed-width-xm">CASES</th>
                </tr>
            </thead>
            <tbody>
                @for($row = 0; $row <= ($max_row - 1); $row++)
                    <tr>
                        <td class="fixed-width">{{(!empty($product[$row])) ? $product[$row]->production_product : ''}}</td>
                        <td class="fixed-width">{{(!empty($product[$row])) ? $product[$row]->production_customer : ''}}</td>
                        <td class="fixed-width-xm">{{(!empty($product[$row])) ? $product[$row]->production_cases : ''}}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endforeach

</div>

@stop

@section('custom-js')
<script type="text/javascript">
  $(document).ready(function() {
    //refresh page every 30 seconds
    setInterval(function() {
        var uricontroller = '{{Request::segment(1)}}';

        if(uricontroller == 'fsf') {
            window.location.href = '{{ URL::to("fsf/production_daily_v2") }}';
        } else {
            window.location.href = '{{ URL::to("fs/production_daily") }}';
        }
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