@extends('layouts.default')

@section('css')
    <link href="main.css" />
@stop

@section('title'){{ 'Home' }}@stop

@section('content')
	

	<div class="row daily-row">
		<div class="column small-12">
			<div>
				<div class="column small-12 light-box margin-top-20">
					<span>Production Schedule</span>
					<span id="date-text"> - {{ date("l F j, Y", strtotime($date)) }} &nbsp;<a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>

					@if(user_access_rights(5) == "false" && Auth::user()->is_admin )
					<a href="#" class="right" data-reveal-id="addProductionModal"><i class="fa fa-plus"></i> New Entry</a>
					<a href="#" class="right" id="weeklybtn"> Weekly view</a>
					@endif
				</div>

				<table class="responsive production-table">
				  	<thead>
						<tr>
							<th class="align-left">PRODUCT</th>
							<th class="align-left">CUSTOMER</th>
							<th class="align-left">PACK SIZE</th>
							<th class="align-left">PROD SIZE</th>
							<th class="align-left">CASES</th>
							<th class="align-left">SKIDS</th>
							<th class="align-left">SHIFT</th>
							<th class="align-left">STATUS</th>
							<th class="align-left">NOTES</th>
							<th class="align-left">ACTION</th>
						</tr>
					</thead>
					<tbody>
						@if (!empty($products))
							@foreach($products as $key => $value)
						<tr id="row-id-{{$value->id}}">
							<td class="product-product fixed-width">{{$value->production_product}}</td>
							<td class="product-customer fixed-width">{{$value->production_customer}}</td>
							<td class="product-pack-size">{{$value->production_pack_size}}</td>
							<td class="product-size">{{$value->production_product_size}}</td>
							<td class="product-cases">{{$value->production_cases}}</td>
							<td class="product-skids">{{$value->production_skids}}</td>
							<td class="product-shift">{{$value->production_shift}}</td>
							<td class="product-status">{{$value->production_status}}</td>
							<td class="product-notes fixed-width">{{$value->production_notes}}</td>

							{{--@if (user_access_rights(1) == "true" && user_access_rights(5) == "true")	
								<td class="center-align"> <a production-id="{{$value->id}}" class="production-edit-status edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></td>
							@else --}}
							<td class="center-align"> 
							@if (user_access_rights(1) == "true" && Auth::user()->is_admin )
								<a production-id="{{$value->id}}" class="production-edit edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i><a production-id="{{$value->id}}" class="production-delete delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i>
							@endif
							</td>

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
		</div>
	</div>

	<div id="addProductionModal" class="add-edit-modal reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h3 id="title-status">Add Product</h2>
		<div>
			<form id="production-form">
				<div class="row">
					<input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
					<div class="column small-12 small-centered large-6 large-uncentered">
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Date :</label>
									</div>
									<div class="small-9 columns daily-date daily-date-edit">
										<span>{{date("Y-m-d", strtotime($date))}}</span> &nbsp;<a href="#" title="Change Date" id="change-date-btn-view"><i class="fa fa-calendar"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Product :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input repetitive" name="production_product" type="text" id="product" placeholder="Product">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Customer :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input repetitive" name="production_customer" type="text" id="customer" placeholder="Customer">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Pack Size :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input repetitive" name="production_pack_size" type="text" id="pack_size" placeholder="Pack Size">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Product Size :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input repetitive" name="production_product_size" type="text" id="product_size" placeholder="Product Size">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="column small-12 small-centered large-6 large-uncentered">
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline"># of Cases :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input" type="number" id="cases" placeholder="# of Cases">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline"># of Skids :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input" type="number" id="skids" placeholder="# of Skids">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Shift :</label>
									</div>
									<div class="small-9 columns">
								        <select id="shift">
								          	<option value="Day">Day</option>
								          	<option value="Night">Night</option>
								        </select>
										<!--input class="production-input" name="production_shift" type="text" id="shift" placeholder="Shift"-->
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Status :</label>
									</div>
									<div class="small-9 columns">
								        <select id="status">
								          	<option value="Pending">Pending</option>
								          	<option value="Completed">Completed</option>
								        </select>
										<!--input class="production-input repetitive" name="production_status" type="text" id="status" placeholder="Status"-->
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Notes :</label>
									</div>
									<div class="small-9 columns">
										<input class="production-input" type="text" id="notes" placeholder="Notes">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				</br>
				</br>
				<div class="row">
					<div class="small-12 center-align msg-alert">
					</div>
				</div>
				</br>
				<div class="row">
					<div class="small-12 center-align">
						<a href="#" id="addProductionbtn" class="button expand">Create</a>
						<!--a href="#" id="cancelAddProductionbtn" class="button alert button expand">Cancel</a-->
					</div>
				</div>
			</form>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
	</div>

	<div id="editProductionModal" class="add-edit-modal reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h3 id="title-status">Edit Product</h2>
		<div>
			<form id="production-form-edit">
				<div class="row">
					<input type="hidden" id="csrf_token_edit" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" id="production-id-edit" name="_token" value="">
					<div class="column small-12 small-centered large-6 large-uncentered">
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Date :</label>
									</div>
									<div class="small-9 columns daily-date daily-date-edit">
										<span>{{date("Y-m-d", strtotime($date))}}</span> &nbsp;<a href="#" title="Change Date" id="change-date-btn-edit"><i class="fa fa-calendar"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Product :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input repetitive" name="edit_production_product" type="text" id="edit-product" placeholder="Product">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Customer :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input repetitive" name="edit_production_customer" type="text" id="edit-customer" placeholder="Customer">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Pack Size :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input repetitive" name="edit_production_pack_size" type="text" id="edit-pack_size" placeholder="Pack Size">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Product Size :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input repetitive" name="edit_production_product_size" type="text" id="edit-product_size" placeholder="Product Size">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="column small-12 small-centered large-6 large-uncentered">
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline"># of Cases :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input" type="text" id="edit-cases" placeholder="# of Cases">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline"># of Skids :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input" type="text" id="edit-skids" placeholder="# of Skids">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Shift :</label>
									</div>
									<div class="small-9 columns">

						        		<select id="edit-shift">
								          	<option value="Day">Day</option>
								          	<option value="Night">Night</option>
								        </select>

										<!--input class="edit-production-input repetitive" name="edit_production_shift" type="text" id="edit-shift" placeholder="Shift"-->
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Status :</label>
									</div>
									<div class="small-9 columns">

						        		<select id="edit-status">
								          	<option value="Pending">Pending</option>
								          	<option value="Completed">Completed</option>
								        </select>

										<!--input class="edit-production-input repetitive" name="edit_production_status" type="text" id="edit-status" placeholder="Status"-->
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Notes :</label>
									</div>
									<div class="small-9 columns">
										<input class="edit-production-input" type="text" id="edit-notes" placeholder="Notes">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				</br>
				</br>
				<div class="row">
					<div class="small-12 center-align msg-alert msg-alert-edit">
					</div>
				</div>
				</br>
				<div class="row">
					<div class="small-12 center-align">
						<a href="#" id="editProductionbtn" class="button success expand">Edit</a>&nbsp;
						<!--a href="#" id="cancelEditProductionbtn" class="button alert">Cancel</a-->
					</div>
				</div>
			</form>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
	</div>


	<div id="editProductionStatusModal" class="add-edit-modal reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h3 id="title-status">Edit Product Status</h2>
		<div>
			<form id="production-form-edit">
				<div class="row">
					<input type="hidden" id="csrf_token_edit" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" id="production-status-id-edit" name="_token" value="">
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-3 columns">
										<label for="right-label" class="right inline">Status :</label>
									</div>
									<div class="small-9 columns">

						        		<select id="edit-production-status">
								          	<option value="Pending">Pending</option>
								          	<option value="Completed">Completed</option>
								        </select>

										<!--input class="edit-production-input repetitive" name="edit_production_status" type="text" id="edit-status" placeholder="Status"-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				</br>
				</br>
				<div class="row">
					<div class="small-12 center-align msg-alert msg-alert-edit">
					</div>
				</div>
				</br>
				<div class="row">
					<div class="small-12 center-align">
						<a href="#" id="editProductionStatusbtn" class="button success expand">Edit</a>&nbsp;
						<!--a href="#" id="cancelEditProductionbtn" class="button alert">Cancel</a-->
					</div>
				</div>
			</form>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
	</div>









	<div id="deleteProductionModal" class="add-edit-modal reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h3 id="title-status">Are you sure you want to delete this item?</h2>
		<br/>
		<br/>

		<input type="hidden" id="csrf_token_delete" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" id="production-id-delete" name="_token" value="">
		<div>
			<div class="row">
				<div class="small-12 center-align">
					<a href="#" id="deleteProductionbtn" class="button success">Confirm</a>&nbsp;
					<a href="#" id="cancelDeleteProductionbtn" class="button alert">Cancel</a>
				</div>
			</div>
		</div>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>	
	</div>

	<div id="successModal" class="add-edit-modal reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h3 id="title-status" class="center-align">Successfully added Schedule Item</h2>
		<br/>
		<br/>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>	
	</div>
@stop

@section('custom-js')
<script type="text/javascript">
	$(document).on('close.fndtn.reveal', '[data-reveal]', function () {
	  	$('#outbound1-form').trigger('reset');
	});

	$(document).ready(function() {
		//change date
		$('#change-date-btn').datetimepicker({
			onGenerate:function(){
			    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "{{ Input::get('product-date') }}",
			format: 'Y-m-d',
			onSelectDate:function($date){
				window.location.href = '{{ URL::to("production") }}?product-date=' + $date.dateFormat('Y-m-d');
			}
		});

		$('#change-date-btn-add').datetimepicker({
			onGenerate:function(){
			    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "{{ Input::get('product-date') }}",
			format: 'Y-m-d',
			onSelectDate:function($date){
				window.location.href = '{{ URL::to("production") }}?product-date=' + $date.dateFormat('Y-m-d');
			}
		});

		$('#change-date-btn-edit').datetimepicker({
			onGenerate:function(){
			    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "{{ Input::get('product-date') }}",
			format: 'Y-m-d',
			onSelectDate:function($date){
				  var day = $date.getDate();
				  var month = $date.getMonth() + 1;
				  var year = $date.getFullYear();	
				  if(month < 10){
					  month = "0" + month;
				  }

				  $(".daily-date-edit").find("span").html(year + '-'+ month + '-' + day);
			}
		});

		$('#change-date-btn-view').datetimepicker({
			onGenerate:function(){
			    $(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
			},
			timepicker: false,
			value: "{{ Input::get('product-date') }}",
			format: 'Y-m-d',
			onSelectDate:function($date){
				  var day = $date.getDate();
				  var month = $date.getMonth() + 1;
				  var year = $date.getFullYear();

				  $(".daily-date-edit").find("span").html(year + '-'+ month + '-' + day);
			}
		});

        $("#weeklybtn").click(function() {
            var url           = '{{url::to("production/weekly")}}',
                schedule_date = $("#change-date-btn").val()
            ; 

            $('<form>', {
                "html"   : '<input type="text" id="product-date" name="product-date" value="' + schedule_date + '" />',
                "action" : url,
                "method" :"get"
            }).appendTo(document.body).submit();
        });

        $("#addProductionbtn").click(function() {
            var date         = $("#change-date-btn-view").val(),
                product      = $("#product").val(),
                customer     = $("#customer").val(),
                pack_size    = $("#pack_size").val(),
                product_size = $("#product_size").val(),
                cases        = $("#cases").val(),
                skids        = $("#skids").val(),
                shift        = $("#shift").val(),
                status       = $("#status").val(),
                notes        = $("#notes").val(),
                url          = '{{url::to("production/addProduction")}}',
                form_object  = {},
                validate     = false,
                error_msg    = "",
                chosen_date  = $("#change-date-btn").val()
            ;

            $(".msg-alert").empty();

            $('#production-form .production-input').each(function(){
                if($(this).val() != '' || $(this).attr('checked')) {
                    validate = true;
                }
            });

            if(validate) {
            	repetitive = getRepetitive();

                form_object['production_date']         = date;
                form_object['production_product']      = product;
                form_object['production_customer']     = customer;
                form_object['production_pack_size']    = pack_size;
                form_object['production_product_size'] = product_size;
                form_object['production_cases']        = cases;
                form_object['production_skids']        = skids;
                form_object['production_shift']        = shift;
                form_object['production_status']       = status;
                form_object['production_notes']        = notes;

                $.ajax({
                    async   : false,
                    method  : "POST",
                    url     : url,
                    data    : {
                    	"fields" : form_object,
                   		"_token" : $("#csrf_token").val(),
                   		repetitive: repetitive
                   	},
                    success : function(result) {
                        obj_result = JSON.parse(result);

                        if(obj_result.status == 'failed') {
                            error_msg = obj_result.message;
                        } else {
                        	location.reload();
                        	// $('#addProductionModal').foundation('reveal', 'close');
                        	// $('.production-input').val('');

                        	// if(date == chosen_date) {
                         //     $("body .production-table").find('tbody').after($('<tr id="row-id-'+obj_result.id+'" style="background-color:#A6E1A6 !important"><td class="product-product">'+product+'</td><td class="product-customer">'+customer+'</td><td class="product-pack-size">'+pack_size+'</td><td class="product-size">'+product_size+'</td><td class="product-cases">'+cases+'</td><td class="product-skids">'+skids+'</td><td class="product-shift">'+shift+'</td><td class="product-status">'+status+'</td><td class="product-notes">'+notes+'</td><td class="center-align">     <a production-id="' + obj_result.id + '" class="production-edit edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a><a href="#" production-id="'+obj_result.id+'" class="production-delete delete-btn"><i class="fa fa-trash fa-lg"></i></a></td></tr>'));
                        	// }
                        }
                    }
                });
            } else {
                error_msg += "Please fill out above fields.";
            }

            $(".msg-alert").append(error_msg);
        });

        $('#production-date').keypress(function(e) {
            if(e.which == 13) {
                getDataByDate();
            }
        });

        $('#production-date-weekly').keypress(function(e) {
            if(e.which == 13) {
                getDataByDateWeekly();
            }
        });

        $("#cancelAddProductionbtn").click(function() {
            $('#addProductionModal').foundation('reveal', 'close');
        });

        $("#cancelEditProductionbtn").click(function() {
            $('#editProductionModal').foundation('reveal', 'close');
        });

        $("#cancelDeleteProductionbtn").click(function() {
            $('#deleteProductionModal').foundation('reveal', 'close');
        });

        function getDataByDate() {
            var selected_date    = $('#production-date').val();
            var url              = '{{url::to("production")}}';

            if (isNaN(Date.parse(selected_date))==false) {
                myDate = new Date(Date.parse(selected_date));

            var form = $('<form action="' + url + '" method="post">' +
              '<input type="text" name="product-date" value="' + myDate + '" />' +
              '</form>');
            form.submit();

            } else {
                alert('Invalid date');
            }
        }

        function getDataByDateWeekly() {
            var selected_date    = $('#production-date-weekly').val();
            var url              = '{{url::to("production/weekly")}}';

            if (isNaN(Date.parse(selected_date))==false) {
                myDate = new Date(Date.parse(selected_date));

            var form = $('<form action="' + url + '" method="post">' +
              '<input type="text" name="product-date" value="' + myDate + '" />' +
              '</form>');
            form.submit();

            } else {
                alert('Invalid date');
            }
        }

        $("body").on("click", ".production-edit", function() {
            var production_id = $(this).attr('production-id'),
                date          = $("#change-date-btn").val(),
                product       = $(this).closest("tr").find("td.product-product").html(),
                customer      = $(this).closest("tr").find("td.product-customer").html(),
                pack_size     = $(this).closest("tr").find("td.product-pack-size").html(),
                product_size  = $(this).closest("tr").find("td.product-size").html(),
                cases         = $(this).closest("tr").find("td.product-cases").html(),
                skids         = $(this).closest("tr").find("td.product-skids").html(),
                shift         = $(this).closest("tr").find("td.product-shift").html(),
                status        = $(this).closest("tr").find("td.product-status").html(),
                notes         = $(this).closest("tr").find("td.product-notes").html()
            ;

            $("#production-id-edit").val(production_id);
            $("#edit-date").val(date);
            $("#edit-product").val(product);
            $("#edit-customer").val(customer);
            $("#edit-pack_size").val(pack_size);
            $("#edit-product_size").val(product_size);
            $("#edit-cases").val(cases);
            $("#edit-skids").val(skids);
            $("#edit-shift").val(shift);
            $("#edit-status").val(status);
            $("#edit-notes").val(notes);

            $('#editProductionModal').foundation('reveal', 'open');
        });


        $("body").on("click", ".production-edit-status", function() {
            var production_id = $(this).attr('production-id'),
                status        = $(this).closest("tr").find("td.product-status").html()
            ;

            $("#production-status-id-edit").val(production_id);
            $("#edit-production-status").val(status);

            $('#editProductionStatusModal').foundation('reveal', 'open');
        });

        $("#editProductionStatusbtn").click(function() {
        	var production_id = $("#production-status-id-edit").val(),
        		status        = $("#edit-production-status").val(),
                url           = '{{url::to("production/editProductionStatus")}}',
        		form_object   = {};

            form_object['id']           		   = production_id;
            form_object['production_status']       = status;

            $.ajax({
                async   : false,
                method  : "POST",
                url     : url,
                data    : {
            		"fields" : form_object,
               		"_token" : $("#csrf_token_edit").val()
               	},
                success : function(result) {
                	location.reload();
                }
            });
        });

        $("#editProductionbtn").click(function() {
            var production_id   = $("#production-id-edit").val(),
            	production_date = $(".daily-date-edit").find("span").html(),
                date            = $("#edit-date").val(),
                product         = $("#edit-product").val(),
                customer        = $("#edit-customer").val(),
                pack_size       = $("#edit-pack_size").val(),
                product_size    = $("#edit-product_size").val(),
                cases           = $("#edit-cases").val(),
                skids           = $("#edit-skids").val(),
                shift           = $("#edit-shift").val(),
                status          = $("#edit-status").val(),
                notes           = $("#edit-notes").val(),
                url             = '{{url::to("production/editProduction")}}',
                form_object     = {},
                validate        = false,
                error_msg       = ""
            ;

            $(".msg-alert-edit").empty();

            $('#production-form-edit .edit-production-input').each(function(){
                if($(this).val() != '' || $(this).attr('checked')) {
                    validate = true;
                }
            });

            if(validate) {

            	repetitive = getRepetitive();

                form_object['id']           		   = production_id;
                form_object['production_date']         = production_date;
                form_object['production_product']      = product;
                form_object['production_customer']     = customer;
                form_object['production_pack_size']    = pack_size;
                form_object['production_product_size'] = product_size;
                form_object['production_cases']        = cases;
                form_object['production_skids']        = skids;
                form_object['production_shift']        = shift;
                form_object['production_status']       = status;
                form_object['production_notes']        = notes;

                $.ajax({
                    async   : false,
                    method  : "POST",
                    url     : url,
                    data    : {
                		"fields" : form_object,
                   		"_token" : $("#csrf_token_edit").val(),
                   		repetitive: repetitive
                   	},
                    success : function(result) {
                        obj_result = JSON.parse(result);

                        if(obj_result.status == 'failed') {
                            error_msg = obj_result.message;
                        } else {
                            $('#row-id-'+production_id).remove();

                            if(production_date == '{{$date}}') {
                            	$("body .production-table").find('tbody').after($('<tr id="row-id-'+production_id+'" style="background-color:#A6E1A6 !important"><td class="product-product">'+product+'</td><td class="product-customer">'+customer+'</td><td class="product-pack-size">'+pack_size+'</td><td class="product-size">'+product_size+'</td><td class="product-cases">'+cases+'</td><td class="product-skids">'+skids+'</td><td class="product-shift">'+shift+'</td><td class="product-status">'+status+'</td><td class="product-notes">'+notes+'</td><td class="center-align"><a href="#" production-id="' + production_id + '" class="production-edit edit-btn"><i class="fa fa-pencil-square-o fa-lg"></i></a><a href="#" production-id="'+production_id+'" class="production-delete delete-btn"><i class="fa fa-trash fa-lg"></i></a></td></tr>'));
                            }

                            $('.production-input').val('');
                            $('.production-empty').remove();
                            $('#editProductionModal').foundation('reveal', 'close');
                        }
                    }
                });
            } else {
                error_msg += "Please fill out above fields.";
            }

            $(".msg-alert-edit").append(error_msg);
        });

        $("body").on("click", ".production-delete", function() {
            var production_id = $(this).attr('production-id');

            $("#production-id-delete").val(production_id);

            $('#deleteProductionModal').foundation('reveal', 'open');
        });

        $("body").on("click","#deleteProductionbtn", function() {
            var production_id = $("#production-id-delete").val(),
                url           = '{{url::to("production/deleteProduction")}}',
                form_object   = {}
            ;

            form_object['id'] = production_id;

            $.ajax({
                async   : false,
                method  : "POST",
                url     : url,
                data    : {"fields" : form_object,
                           "_token" : $("#csrf_token_edit").val()},
                success : function(result) {
                    obj_result = JSON.parse(result);

                    if(obj_result.status == 'failed') {
                        error_msg = obj_result.message;
                    } else {
                        $('#row-id-'+production_id).remove();
                        $('#deleteProductionModal').foundation('reveal', 'close');
                    }
                }
            });
        });

        $("body").on("click", ".manage-entry", function() {

        	var visibility_entry = $(".view-all-entries").is(":visible"); 
        	
        	if(!visibility_entry) {
        		$(".view-all-entries").show();
        		$(".production-home").hide();
        		$(".manage-entry").html("Add Schedule Item");
        	} else {
        		$(".manage-entry").html("Manage Schedule Item");
        		$(".view-all-entries").hide();
        		$(".production-home").show();
        	}


        });


	}); //end document
</script>
{{ HTML::script('assets/plugins/datahistory.js') }}
@stop