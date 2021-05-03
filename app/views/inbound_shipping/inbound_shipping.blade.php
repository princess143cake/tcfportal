@extends('layouts.plain')

@section('title'){{ 'Inbound Shipping' }}@stop

@section('custom-css')
    <style type="text/css">
        .point {
            cursor: pointer !important;
        }
    </style>
@stop

@section('content')

    <div class="row" style="max-width:100%;">
        <div class="column small-12">
            {{-- <a href="{{ URL::to('fs/inbound?d='.date('Y-m-d', strtotime($date))) }}">View full screen display</a> --}}
            <div class="column small-12 light-box margin-top-20">
                <span>Inbound Shipping Schedule</span>
                @if( Auth::user()->is_admin )
                    @if ($date == date('l F j, Y') || strtotime($date) > strtotime(date('l F j, Y')))
                        <a href="#" class="right new-entry-btn" data-reveal-id="inbound_modal"><i class="fa fa-plus"></i> New Entry</a>
                    @endif
                @endif
                <span id="date-text"> - {{ $date }} &nbsp;<a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>
            </div>
            <div class="column small-12" style="overflow-x: scroll;padding: 0 !important;">
                <table class="responsive tcf-table">
                    <thead>
                        <tr>
                            <th>Container Number</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>KG</th>
                            <th>Steamship Provider</th>
                            <th>Arrival To Port</th>
                            <th>Arrival To Destination</th>                            
                            <th>Terminal Handling Fee Paid</th>
                            <th>Pickup Location</th>
                            <th>Pickup Appointment</th>
                            <th>Return Location</th>
                            <th>RV number</th>
                            <th>Pickup number</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inbounds as $inbound)
                            <tr>
                                <td class="fixed-width-outbound">{{ $inbound->container_number }}</td>
                                <td class="fixed-width-outbound">{{ $inbound->supplier }}</td>                        
                                <td class="fixed-width-outbound">{{ $inbound->product }}</td>
                                <td>{{ $inbound->kg }}</td>
                                <td>{{ $inbound->steamship_provider }}</td>
                                <td>{{ date('d/m/Y', strtotime($inbound->arrival_to_port) ) }}</td>
                                <td>{{ date('d/m/Y', strtotime($inbound->arrival_to_destination) )}}</td>
                                <td>{{ $inbound->terminal_handling_fee_paid ? 'Yes' : 'No' }}</td>
                                <td>{{ $inbound->pickup_location }}</td>
                                <td>{{ date('d/m/Y h:i a', strtotime($inbound->pickup_appointment) ); }} </td>
                                <td>{{ $inbound->return_location }}</td>
                                <td>{{ $inbound->rv_no }}</td>
                                <td>{{ $inbound->pickup_no }}</td>
                                <td data-id="{{ $inbound->id }}">
                                    @if( Auth::user()->is_admin )
                                    <a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                    <a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    <div id="inbound_modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h2 id="modalTitle">Inbound Shipping</h2>
        <p class="lead">First Step</p>
            <form id="inbound-form">
                {{ Form::label('inbound_container_number', 'Container number') }}
                {{ Form::text('inbound_container_number', '', ['placeholder' => 'Container number', 'class' => 'repetitive']) }}

                {{ Form::label('inbound_supplier', 'Supplier number') }}
                {{ Form::text('inbound_supplier', '', ['placeholder' => 'Supplier number', 'class' => 'repetitive']) }}


                {{ Form::label('inbound_product', 'Product') }}
                {{ Form::text('inbound_product', '', ['placeholder' => 'Product', 'class' => 'repetitive']) }}


                {{ Form::label('inbound_kg', 'KG') }}
                {{ Form::number('inbound_kg', '', ['placeholder' => 'KG']) }}

    
                {{ Form::label('inbound_steamship_provider', 'Steamship Provider') }}
                {{ Form::text('inbound_steamship_provider', '', ['placeholder' => 'Steamship Provider']) }}

                {{ Form::label('inbound_arrival_to_port', 'Arrival to Port') }}
                {{ Form::text('inbound_arrival_to_port', '', ['placeholder' => 'Arrival to Port']) }}

                {{ Form::label('inbound_arrival_to_destination', 'Arrival to Destination') }}
                {{ Form::text('inbound_arrival_to_destination', '', ['placeholder' => 'Arrival to Destination']) }}

                {{ Form::label('', 'Terminal Handling Fee Paid') }}
                <span> Yes </span>
                {{ Form::radio('inbound_terminal_handling_fee_paid', 1, true) }}
                <span> No </span>
                {{ Form::radio('inbound_terminal_handling_fee_paid', 0) }}<br />

                {{ Form::label('inbound_pickup_location', 'Pickup Location') }}
                {{ Form::text('inbound_pickup_location', '', ['placeholder' => 'Pickup Location']) }}

                {{ Form::label('inbound_pickup_appointment', 'Pickup Appointment') }}
                {{ Form::text('inbound_pickup_appointment', '', ['placeholder' => 'Pickup Appointment']) }}

                {{ Form::label('inbound_return_location', 'Return Location') }}
                {{ Form::text('inbound_return_location', '', ['placeholder' => 'Return Location']) }}
            
                {{ Form::label('inbound_rv_number', 'RV number') }}
                {{ Form::number('inbound_rv_number', '', ['placeholder' => 'RV number']) }}
                
                {{ Form::label('inbound_pickup_number', 'Pickup number') }}
                {{ Form::number('inbound_pickup_number', '', ['placeholder' => 'Pickup number']) }}
                <a href="#" id="create-btn" class="button expand" data-action="create"></a>
            </form>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

@stop

@section('custom-js')
{{ HTML::script('assets/plugins/stupidtable.js') }}
<script type="text/javascript">
    $(document).on('close.fndtn.reveal', '[data-reveal]', function () {
         $('#inbound-form').trigger('reset');
    });

    $(document).ready(function() {

        $('input[name="inbound_eta"]').datetimepicker({
            datepicker: false,
            format: 'h:i a'
        });
        
        $('input[name="inbound_arrival_to_port"], input[name="inbound_arrival_to_destination"]').datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });

        $('input[name="inbound_pickup_appointment"]').datetimepicker({
            format: 'Y-m-d h:i a'
        });
        $('.new-entry-btn').click(function(){
            $('#create-btn').text('Create');
        });

        //create
        $('#create-btn').click(function(event) {
            event.preventDefault();
            form    = $('#inbound-form'),

            action = $(this).attr('data-action');

            fields = {
                // inbound_vendor: $('input[name="inbound_vendor"]').val(),
                // inbound_po_number: $('input[name="inbound_po_number"]').val(),
                // inbound_carrier: $('input[name="inbound_carrier"]').val(),
                // inbound_product: $('input[name="inbound_product"]').val(),
                // inbound_cases: $('input[name="inbound_cases"]').val(),
                // inbound_kg: $('input[name="inbound_kg"]').val(),
                // inbound_eta: $('input[name="inbound_eta"]').val(),
                // user_id: '{{ Auth::user()->id }}',
                // date: '{{ $date }}',
                container_number: $('input[name="inbound_container_number"]').val(),
                supplier: $('input[name="inbound_supplier"]').val(),
                product: $('input[name="inbound_product"]').val(),
                kg: $('input[name="inbound_kg"]').val(),
                steamship_provider: $('input[name="inbound_steamship_provider"]').val(),
                arrival_to_port: $('input[name="inbound_arrival_to_port"]').val(),
                arrival_to_destination: $('input[name="inbound_arrival_to_destination"]').val(),
                terminal_handling_fee_paid: $('input[name="inbound_terminal_handling_fee_paid"]:checked').val(),
                pickup_location: $('input[name="inbound_pickup_location"]').val(),
                pickup_appointment: $('input[name="inbound_pickup_appointment"]').val(),
                return_location: $('input[name="inbound_return_location"]').val(),
                rv_no: $('input[name="inbound_rv_number"]').val(),
                pickup_no: $('input[name="inbound_pickup_number"]').val(),
            };

            console.log( fields );

            if (fields.inbound_container_number != '' || fields.inbound_supplier != '' || fields.inbound_product != '' || fields.inbound_kg != '' || fields.inbound_steamship_provider != '' || fields.inbound_arrival_to_port != '' || fields.inbound_arrival_to_destination != '') {

                repetitive = getRepetitive();

                if (action == 'create') {
                    // insert
                    $.ajax({
                        type: 'post',
                        url: '{{ URL::to("inbound_shipping/insert") }}',
                        data: {
                            fields: fields,
                            _token: '{{ csrf_token() }}',
                            repetitive: repetitive
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            $('#inbound_modal').foundation('reveal', 'close');
                            new_row = $('<tr>' +
                                // '<td>'+response.inbound_vendor+'</td>' +
                                // '<td>'+response.inbound_po_number+'</td>' +
                                // '<td>'+response.inbound_carrier+'</td>' +
                                // '<td>'+fields.inbound_product+'</td>' +
                                // '<td>'+fields.inbound_kg+'</td>' +
                                // '<td>'+fields.inbound_cases+'</td>' +

                                '<td>'+fields.container_number+'</td>' +
                                '<td>'+fields.supplier+'</td>' +
                                '<td>'+fields.product+'</td>' +
                                '<td>'+fields.kg+'</td>' +
                                '<td>'+fields.steamship_provider+'</td>' +
                                '<td>'+moment(fields.arrival_to_port).format('DD/MM/YYYY')+'</td>' +
                                '<td>'+moment(fields.arrival_to_destination).format('DD/MM/YYYY')+'</td>' +
                                '<td>'+ (fields.terminal_handling_fee_paid ? 'Yes' : 'No') +'</td>' +
                                '<td>'+fields.pickup_location+'</td>' +
                                '<td>'+moment(fields.pickup_appointment).format('DD/MM/YYYY hh:mm a') +'</td>' +
                                '<td>'+fields.return_location+'</td>' +
                                '<td>'+fields.rv_no+'</td>' +
                                '<td>'+fields.pickup_no+'</td>' +

                                //'<td>'+fields.inbound_eta+'</td>' +
                                '<td data-id="'+response.id+'">' +
                                    '<a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
                                    '<a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
                                '</td>' +
                            '</tr>');
                            $(new_row).hide().appendTo('.tcf-table').fadeIn(300);
                            form.trigger('reset');
                        }
                    }); 
                } else {
                    id = $(this).attr('data-id');
                    //update

                    $.ajax({
                        type: 'post',
                        url: '{{ URL::to("inbound_shipping/update") }}',
                        data: {
                            id: id,
                            fields: fields,
                            _token: '{{ csrf_token() }}',
                            repetitive: repetitive
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log( response );
                            $('td[data-id="'+id+'"]').parent('tr').html('' +
                                // '<td>'+response.inbound_vendor+'</td>' +
                                // '<td>'+response.inbound_po_number+'</td>' +
                                // '<td>'+response.inbound_carrier+'</td>' +
                                // '<td>'+fields.inbound_product+'</td>' +
                                // '<td>'+fields.inbound_kg+'</td>' +
                                // '<td>'+fields.inbound_cases+'</td>' +

                                '<td>'+fields.container_number+'</td>' +
                                '<td>'+fields.supplier+'</td>' +
                                '<td>'+fields.product+'</td>' +
                                '<td>'+fields.kg+'</td>' +
                                '<td>'+fields.steamship_provider+'</td>' +
                                '<td>'+moment(fields.arrival_to_port).format('DD/MM/YYYY')+'</td>' +
                                '<td>'+moment(fields.arrival_to_destination).format('DD/MM/YYYY')+'</td>' +
                                '<td>'+ (fields.terminal_handling_fee_paid ? 'Yes' : 'No') +'</td>' +
                                '<td>'+fields.pickup_location+'</td>' +
                                '<td>'+moment(fields.pickup_appointment).format('DD/MM/YYYY hh:mm a') +'</td>' +
                                '<td>'+fields.return_location+'</td>' +
                                '<td>'+fields.rv_no+'</td>' +
                                '<td>'+fields.pickup_no+'</td>' +

                                //'<td>'+fields.eta+'</td>' +
                                '<td data-id="'+response.id+'">' +
                                    '<a class="edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>' +
                                    '<a class="delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i> </a>' +
                                '</td>' +
                            '');
                            $('#inbound_modal').foundation('reveal', 'close');
                        }
                    });
                }

                }

        });

    //delete
    $('body').on('click', '.delete-btn', function(event) {
        event.preventDefault();
        tr = $(this).closest('tr');
        id = $(this).parent().data('id');
        if (confirm('Delete confirmation')) {
            $.ajax({
                type: 'post',
                url: '{{ URL::to("inbound_shipping/delete") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function() {
                    tr.fadeOut(300);
                }
            });
        }
    });

    //edit inbound / display inbound data by id
    $('body').on('click', '.edit-btn', function(event) {
        event.preventDefault();
        id = $(this).parent().data('id');

        $('#create-btn').attr('data-action', 'edit');
        $('#create-btn').text('Update');
        $('#create-btn').attr('data-id', id);
        $.ajax({
            type: 'post',
            url: '{{ URL::to("inbound_shipping/edit") }}',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                //firat step
                // $('input[name="inbound_vendor"]').val(response.inbound_vendor);
                // $('input[name="inbound_po_number"]').val(response.inbound_po_number);
                // $('input[name="inbound_carrier"]').val(response.inbound_carrier);
                // $('input[name="edit_start_time"]').val(response.outbound_start_time);
                // $('input[name="inbound_product"]').val(response.inbound_product);
                // $('input[name="inbound_cases"]').val(response.inbound_cases);
                // $('input[name="inbound_kg"]').val(response.inbound_kg);
                // $('input[name="inbound_eta"]').val(response.inbound_eta);
                $('#update-btn').attr('data-id', response.id);
                $('input[name="inbound_container_number"]').val( response.container_number ) ;
                $('input[name="inbound_supplier"]').val( response.supplier );
                $('input[name="inbound_product"]').val(response.product);
                $('input[name="inbound_kg"]').val(response.kg);                
                $('input[name="inbound_steamship_provider"]').val( response.steamship_provider );
                $('input[name="inbound_arrival_to_port"]').val( response.arrival_to_port );
                $('input[name="inbound_arrival_to_destination"]').val( response.arrival_to_destination );
                $('input[name="inbound_terminal_handling_fee_paid"][value="'+response.terminal_handling_fee_paid+'"]').prop("checked", true);;
                $('input[name="inbound_pickup_location"]').val( response.pickup_location );
                $('input[name="inbound_pickup_appointment"]').val( response.pickup_appointment );
                $('input[name="inbound_return_location"]').val( response.return_location );
                $('input[name="inbound_rv_number"]').val( response.rv_no );
                $('input[name="inbound_pickup_number"]').val( response.pickup_no );
            }
        });

        $('#inbound_modal').foundation('reveal', 'open');
    });

    //sort table
    $('.tcf-table').stupidtable();

    //change date
    $('#change-date-btn').datetimepicker({          
            timepicker: false,
            value: "{{ Input::get('d') }}",
            format: 'Y-m-d',
            onSelectDate:function($date){
                var d  = $date.dateFormat('Y-m-d');
                var option = $("#option").val();    

                $.ajax({
                    type: "GET",                    
                    url:"ajax/get/schedule",
                    data:{
                        option:option,
                        d:d,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        
                        console.log(response);
                        $("#department-select-div").html(response.view);
                        $("#department-select option:first").attr('selected','selected');               
                        $('#department-select').change();
                    }
                });

            }
        });

    }); //end document ready
</script>
{{ HTML::script('assets/plugins/datahistory.js') }}
@stop