@extends('layouts.default')

@section('title'){{ 'Home' }}@stop

@section('custom-css')
<style type="text/css">
	.li-days {
		padding: 0 !important;
		white-space: nowrap;
	}
</style>
@stop

@section('content')

	<div class="row" style="min-width: 100%">
		<div class="column small-12">
			<div class="column small-12 light-box margin-top-20">
				<span>Production Schedule Weekly Overview</span>
				<span style="margin-left: 15px"><a href="#" title="Change Date" id="change-date-btn"><i class="fa fa-calendar"></i></a></span>

				<a href="#" class="right" data-reveal-id="addProductionModal"><i class="fa fa-plus"></i> New Entry</a>
				<a href="#" class="right" id="dailybtn"> Daily view</a>
			</div>
			
			<ul class="tabs small-block-grid-1 large-block-grid-5" data-tab>
				@foreach($products as $key => $product)
					<li class="tab-title li-days {{ Input::get('product-date') == date('Y-m-d', strtotime($key)) ? 'active' : '' }}"><a href="#{{ date("lMd", strtotime($key)) }}" style="color: #565D66;">{{ date("D M d", strtotime($key)) }}</a></li>
				@endforeach
			</ul>

			<div class="tabs-content margin-top-20">

				@foreach($products as $key => $product)
					<div data-date-value="{{ date('Y-m-d', strtotime($key)) }}" class="product-day content {{ Input::get('product-date') == date('Y-m-d', strtotime($key)) ? 'active' : '' }}" id="{{ date("lMd", strtotime($key)) }}">
						<table class="responsive tcf-table">
							<thead>
								<tr class="hover-day">
									<th>PRODUCT</th>
									<th>CUSTOMER</th>
									<th>CASES</th>
									<th>SHIFT</th>
									<th>STATUS</th>
								</tr>
							</thead>
							<tbody>
								@for($row = 0; $row <= ($max_row - 1); $row++)
									<tr>
										<td>{{(!empty($product[$row])) ? $product[$row]->production_product : ''}}</td>
										<td>{{(!empty($product[$row])) ? $product[$row]->production_customer : ''}}</td>
										<td>{{(!empty($product[$row])) ? $product[$row]->production_cases : ''}}</td>
										<td>{{(!empty($product[$row])) ? $product[$row]->production_shift : ''}}</td>
										<td>{{(!empty($product[$row])) ? $product[$row]->production_status : ''}}</td>
									</tr>
							  	@endfor
							</tbody>
						</table>
					</div>
				@endforeach
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
				window.location.href = '{{ URL::to("production/weekly") }}?product-date=' + $date.dateFormat('Y-m-d');
			}
		});

        $("body").on("click", ".product-day", function() {
            var schedule_date = $(this).data("date-value"),
                url           = '{{url::to("production")}}'
            ;

            $('<form>', {
                "html": '<input type="text" id="product-date" name="product-date" value="' + schedule_date + '" />',
                "action": url,
                "method" :"get"
            }).appendTo(document.body).submit();
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

				  $(".daily-date-edit").find("span").html(year + '-'+ month + '-' + day);
			}
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
                error_msg    = ""
            ;

            $(".msg-alert").empty();

            $('#production-form .production-input').each(function(){
                if($(this).val() != '' || $(this).attr('checked')) {
                    validate = true;
                }
            });

            if(validate) {
            	repetitive = {};

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
                   		"_token" : '{{ csrf_token() }}',
                   		repetitive: repetitive
                   	},
                    success : function(result) {
                        obj_result = JSON.parse(result);

                        if(obj_result.status == 'failed') {
                            error_msg = obj_result.message;
                        } else {
                        	location.reload();
                        }
                    }
                });
            } else {
                error_msg += "Please fill out above fields.";
            }

            $(".msg-alert").append(error_msg);
        });

        $("#dailybtn").click(function() {
            var url           = '{{url::to("production")}}',
                schedule_date = $("#change-date-btn").val()
            ; 

            $('<form>', {
                "action" : url,
                "method" :"get"
            }).appendTo(document.body).submit();
        });

	}); //end document
</script>
@stop