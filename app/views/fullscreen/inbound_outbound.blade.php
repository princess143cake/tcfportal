@extends('layouts.fullscreen')

@section('title'){{ 'Inbound Schedule' }}@stop

@section('custom-css')
<style type="text/css">
    .point {
        cursor: pointer !important;
    }

    span {
        color: red;
    }

    .f2:hover {

        border-color: coral;

        opacity: 1.0;
    }

    td {

        font-weight: bold
    }

    tr:hover {
        background-color: #ece1ed;
    }
</style>
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js" integrity="sha512-Vp2UimVVK8kNOjXqqj/B0Fyo96SDPj9OCSm1vmYSrLYF3mwIOBXh/yRZDVKo8NemQn1GUjjK0vFJuCSCkYai/A==" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />   -->


//Data Tables cdn css
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">


<a href="/inbound_outbound">
    <h4 class="fs-f4">{{ HTML::image('/tcf-logo.jpg', '', array('class' => 'tcf-logo')) }}{{ $date }} Inbound and Outbound Schedule</h4>
</a>



<div class="fs-daily p-10">


    <div class="col-md-6 px-10 px-10"><input style="width: 200px; " class="f2 pull-right" type="date" name="searchdate" id="searchdate" onchange="handler(event);" /></span></div>
    <span style="color:black; margin-top:5px;" class="pull-right ">Search: &nbsp;</span>


    <table class="fs-table responsive margin-top-20" id="sort-column">
        <thead>

            <th class="column_sort" id="id" data-order="desc" style="cursor:pointer; width:50px;">
                ID <i id="arrow-down" class="fa fa-caret-down" aria-hidden="true"></i>
                <i id="arrow-up" class="fa fa-caret-up" aria-hidden="true">
            </th>

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
        <tbody id="inbound-outbound-data">

            @include('fullscreen.inbound_outbound_datalist')
        </tbody>

    </table>


    <div id="pagination" style="margin-left: 500px; " class="row  d-flex justify-content-center">
        <div class="col-sm-12 text-center">
            {{$inbounds->links()}}
        </div>
    </div>



</div>



<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc">



@stop



@section('custom-js')
{{ HTML::script('assets/plugins/stupidtable.js') }}


<!-- Data Tables cdn jquery -->
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<!-- sort cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sortable/0.8.0/js/sortable.min.js" integrity="sha512-DEcSaL0BWApJ//v7ZfqAI04nvK+NQcUVwrrx/l1x7OJgU0Cwbq7e459NBMzLPrm8eLPzAwBtiJJS4AvLZDZ8xA==" crossorigin="anonymous"></script>


<!-- <script>
$(document).ready( function () {
    $('#sort-column').DataTable();
} ); 

</script>-->


<script>
    function handler(e) {


        //   var query = e.target.value;

        //   alert(query);

        //   if(query != ''){

        //     fields = {
        // 				date: query
        //   }
        //  alert(fields);
        //                 $.ajax({
        // 					type: 'post',
        // 					url: '{{ URL::to("fs/inbound_outbound") }}',
        // 					data: {
        // 						fields: fields,
        // 						_token: '{{ csrf_token() }}',
        // 						repetitive: repetitive
        // 					},
        // 					dataType: 'json',
        // 					success: function(response) {
        // 						window.location.reload();
        // 					}
        // 				    });
        //   }



    }
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#arrow-up").hide();
        // function fetch_data(sort_type = '', column_name = '') {

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     var _token = $('input[name="_token"]').val();
        //     $.ajax({

        //         //url: BASE_URL +"fs/inbound_outbound/sort_table_column?sortby=" + column_name + "&sorttype=" + sort_type,
        //         // url: BASE_URL + "/exam_manage_ajax?sortby=" + column_name + "&sorttype" + sort_type,
        //         //url: '{{ URL::to("/exam_manage_ajax?sortby=") }}',
        //         // url: "{{url('/exam_manage_ajax?sortby=')}}" + reverse_order + "&sorttype" + column_name,
        //          url: '{{url("fs/inbound_outbound/sort_table_column")}}',
        //         //url: "http://tcfportal.local/fs/inbound_outbound",

        //         // url: "/fs/inbound_outbound/sort_table_column",
        //         // url: "{{url('/fs/inbound_outbound/sort_table_column?sortby=')}}" + reverse_order + "&sorttype" + column_name,
        //         method: 'GET',
        //         data: {

        //             column_name: column_name,
        //             sort_type: sort_type,
        //             _token: _token,
        //         },
        //         success: function(data) {
        //              $('#fs-daily tbody').html(data);
        //              $('#'+column_name+'').append(arrow);
        //             //$('#inbound-outbound-data').html(data);
        //             //window.location.href = 'http://tcfportal.local/fs/inbound_outbound';

        //         }
        //     });
        // }

        function fetch_data(sort_type = '', column_name = '') {

        }




        $(document).on('click', '.column_sort', function() {



          

            //var schedule = $(this).closest('tr').find('td').eq(2).text();
            var schedule = $('#sort-column').find('td:eq(1)').text();

            var column_name = $(this).attr("id");


            var order_type = $(this).data("order");
            var arrow = '';

            var reverse_order = '';
            var rowCount = $('tr:last-child td:first-child').html();
            //var rowCount = document.getElementById('sort-column').rows[0].cells.length

            // var rowCount = $('#inbound tr').find('td:eq(0)').length;

            //alert(rowCount);
            if (order_type == 'desc') {
                $("#arrow-down").hide();
                $("#arrow-up").show();
                //$("#arrow-down").css("display:none");
                $(this).data('order', 'asc');
                reverse_order = 'asc';


            } else {
                $("#arrow-down").show();
                $("#arrow-up").hide();
                $(this).data('order', 'desc');
                reverse_order = 'desc';

            }


            var _token = $('input[name="_token"]').val();
            $.ajax({

                //url: BASE_URL +"fs/inbound_outbound/sort_table_column?sortby=" + column_name + "&sorttype=" + sort_type,
                // url: BASE_URL + "/exam_manage_ajax?sortby=" + column_name + "&sorttype" + sort_type,
                //url: '{{ URL::to("/exam_manage_ajax?sortby=") }}',
                // url: "{{url('/exam_manage_ajax?sortby=')}}" + reverse_order + "&sorttype" + column_name,
                //   url: '{{url("fs/inbound_outbound/sort_table_column?sortby=")}}'+ reverse_order + "&sorttype" + column_name,

                url: '{{url("fs/inbound_outbound/sort_table_column")}}',
                //url: "http://tcfportal.local/fs/inbound_outbound",

                // url: "/fs/inbound_outbound/sort_table_column",
                // url: "{{url('/fs/inbound_outbound/sort_table_column?sortby=')}}" + reverse_order + "&sorttype" + column_name,
                method: 'GET',
                data: {

                    column_name: column_name,
                    sort_type: order_type,
                    schedule: schedule,
                    _token: _token,
                },
                success: function(data) {
                    //$('#tbody').html(data);
                    $('#' + column_name + '').append(arrow);
                    $('#inbound-outbound-data').html(data);
                    //window.location.href = 'http://tcfportal.local/fs/inbound_outboundsort_table_column?column_name='+coulumn_name+ '&sort_type='+order_typec+'&schedule='+schedule;

                }
            });



            $('#hidden_column_name').val(column_name);
            $('#hidden_sort_type').val(reverse_order);
            //fetch_data(reverse_order, column_name);
        });



        //var selectedDate = '';



        $("#searchdate").on("keyup change", function(e) {

            $("#pagination").hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var selectedDate = $(this).val();
            // alert(selectedDate);

            // fields = {
            //     searchdate: $('#searchdate').val(),
            // };



            if (selectedDate != null) {


                var _token = $('input[name="_token"]').val();
                // submit form
                $.ajax({
                    //url: '{{ url("fs/inbound_outbound") }}',
                    url: 'http://tcfportal.local/fs/inbound_outbound',
                    method: 'GET',
                    data: {
                        selectedDate: selectedDate,
                        _token: _token,
                    },


                    success: function(response) {
                        $('#inbound-outbound-data').html(response);
                        //window.location.href = 'http://tcfportal.local/fs/inbound_outbound?selectedDate=' + selectedDate;
                    }
                });

            }

        });

        // $("#searchdate").on("change",function(e){
        //    selected = $(this).val();
        //    // alert(selected);



        //     // if(selected != null){

        //     // }

        //     fields = {
        //     searchdate: carrier.val(),

        //         }

        //         // submit form
        //         $.ajax({
        // 				type: 'post',
        // 				url: '{{ URL::to("fs/inbound_outbound") }}',
        // 				data: {
        // 					fields: fields,
        // 					_token: '{{ csrf_token() }}',
        // 					repetitive: repetitive
        // 				},
        // 				dataType: 'json',
        // 				success: function(response) {
        // 					window.location.reload();
        // 				}
        // 			});
        // });




        //     (function($){
        // // Define click handler. 
        // $('schedule_val_inbound').on('click', function(e){
        //     var query = $(this).val();

        //     alert( query);
        // });



        //     $( function() {
        //         $( "#datepicker" ).datepicker();

        //          var date = $('#datepicker').datepicker({ dateFormat: 'yy-dd-mm' }).val();

        //          $('#datepicker').keyup(function() {

        //             alert(date);
        //          })

        // } );




        $('#change-date-btn-inbound-edit').datetimepicker({
            onGenerate: function() {

                $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
            },
            timepicker: false,
            value: "",
            format: 'Y-m-d',
            onSelectDate: function($date) {
                var day = $date.getDate();
                var month = $date.getMonth() + 1;
                var year = $date.getFullYear();
                if (day < 10) {
                    day = "0" + day;
                }
                if (month < 10) {
                    month = "0" + month;
                }
                $("#schedule_val_inbound").val(year + '-' + month + '-' + day);
                $(".daily-date-inbound-edit").find("span").html(year + '-' + month + '-' + day);
            }
        });


        //sort table
        $('.fs-table').stupidtable();

        // setInterval(function() {
        //     var uricontroller = '{{Request::segment(1)}}';

        //     if (uricontroller == 'fs') {
        //         var rotation = [
        //             '{{ URL::to("fs/outbound") }}',
        //             '{{ URL::to("fs/inbound") }}'
        //         ];

        //         var rotation_2 = [
        //             '{{ URL::to("fs/outbound") }}',
        //             '{{ URL::to("fs/outbound_weekly") }}'
        //         ];
        //     }
        //     var next_rotation = rotation_2.indexOf('{{Request::fullURL() }}') + 1;
        //     if (next_rotation > rotation.length + 1) next_rotation = 0;
        //     window.location = rotation[next_rotation];

        // },3000);

        //refresh page every 30 seconds
        // setInterval(function() {
        //     var uricontroller = '{{Request::segment(1)}}';

        //     if (uricontroller == 'fsf') {
        //         var rotation = [
        //             '{{ URL::to("fsf/outbound_v2") }}',
        //             '{{ URL::to("fsf/inbound_v2") }}',
        //             '{{ URL::to("fsf/outbound_v2?d=".$nextday) }}',
        //             '{{ URL::to("fsf/inbound_v2?d=".$today) }}',
        //             '{{ URL::to("fsf/outbound_weekly") }}'
        //         ];
        //         var rotation_2 = [
        //             '{{ URL::to("fsf/outbound_v2") }}',
        //             '{{ URL::to("fsf/inbound_v2") }}',
        //             '{{ URL::to("fsf/outbound_v2?d=".$today) }}',
        //             '{{ URL::to("fsf/inbound_v2?d=".$nextday) }}',
        //             '{{ URL::to("fsf/outbound_weekly") }}'
        //         ];
        //     } else {
        //         var rotation = [
        //             '{{ URL::to("fs/outbound") }}',
        //             '{{ URL::to("fs/inbound") }}',
        //             '{{ URL::to("fs/outbound?d=".$nextday) }}',
        //             '{{ URL::to("fs/inbound?d=".$today) }}',
        //             '{{ URL::to("fs/outbound_weekly") }}'
        //         ];
        //         var rotation_2 = [
        //             '{{ URL::to("fs/outbound") }}',
        //             '{{ URL::to("fs/inbound") }}',
        //             '{{ URL::to("fs/outbound?d=".$today) }}',
        //             '{{ URL::to("fs/inbound?d=".$nextday) }}',
        //             '{{ URL::to("fs/outbound_weekly") }}'
        //         ];
        //     }

        //     var next_rotation = rotation_2.indexOf('{{Request::fullURL() }}') + 1;
        //     if (next_rotation > rotation.length + 1) next_rotation = 0;
        //     window.location = rotation[next_rotation];
        // }, 30000);

        //autoscroll when it has many items
        autscrollscreen();

        function autscrollscreen() {
            var screen_height = screen.height;
            var scrollingUp = 0;
            var div_height = $(".fs-daily").height();

            $(".fs-daily").css("max-height", screen_height - 20);

            if (div_height > screen_height) {
                window.setInterval(scrollit, 3000);

                function scrollit() {
                    if (scrollingUp == 0) {
                        $('.fs-daily').delay(5000).animate({
                            scrollTop: $(".fs-daily").scrollTop() + 100
                        }, 'slow');
                    }
                }
            }
        }

    });
</script>
@stop