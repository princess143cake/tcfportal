@extends('layouts.default')

@section('css')
    <link href="main.css" />
@stop

@section('title'){{ 'Home' }}@stop

@section('content')

	<div class="row">
		<div class="column small-12">
			<div class="column small-12 light-box margin-top-20">
				<span>Users</span>
				<a href="#" class="right" data-reveal-id="addUserModal"><i class="fa fa-plus"></i> New Entry</a>
			</div>

			<table class="responsive tcf-table">
			  	<thead>
					<tr>
						<th>USERNAME</th>
						<th>Name</th>
						<th>ACCOUNT STATUS</th>
						<th>IS ADMIN</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					@if (!empty($users))
						@foreach($users as $key => $value)
					<tr id="row-id-{{$value->id}}">
						<td class="user-username">{{$value->username}}</td>
						<td class="user-name">{{$value->name}}</td>
						<td class="user-status" cell-value="{{$value->active}}">{{($value->active == 0) ? 'inactive' : 'active'}}</td>
						<td class="user-is-admin" cell-value="{{$value->is_admin}}">{{($value->is_admin == 0) ? 'not admin' : 'admin'}}</td>
						<td class="center-align"> <a user-id="{{$value->id}}" class="user-edit edit-btn" href="#" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i><a user-id="{{$value->id}}" class="user-delete delete-btn" href="#" title="Delete"><i class="fa fa-trash fa-lg"></i></td>
					</tr>
						@endforeach
					@else
					<tr>
						<td colspan="10">No Data</td>$value->active
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div id="addUserModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Add User</h2>
		<form id="user-form">
			{{ Form::label('user_username', 'Username') }}
			{{ Form::text('user_username', '', ['placeholder' => 'Username']) }}

			{{ Form::label('user_password', 'Password') }}
			{{ Form::password('user_password', '', ['placeholder' => 'Password','id' => 'password']) }}

			{{ Form::label('user_retype_password', 'Retype password') }}
			{{ Form::password('user_retype_password', '', ['placeholder' => 'Password', 'id' => 'confirm-password']) }}

			{{ Form::label('user_name', 'Name') }}
			{{ Form::text('user_name', '', ['placeholder' => 'Name', 'id' => 'name']) }}

			{{ Form::label('user_status', 'Status :') }}
			<label><input type="radio" name="user-status" class="user-status" value="1" checked/> Active</label>
			<label><input type="radio" name="user-status" class="user-status" value="0"/> Inactive</label>

			{{ Form::label('user_isadmin', 'Is Admin? :') }}
			<label><input type="radio" name="user-is-admin" class="user-is-admin" value="1"/> Yes</label>
			<label><input type="radio" name="user-is-admin" class="user-is-admin" value="0" checked/> No</label>

			{{ Form::label('access_rights', 'Access Rights :') }}
			<label><input id="privilege-production" type="checkbox" name="privilege-production" class="user-privilege" value=""/> Production Schedule</label>
			<label><input id="privilege-outbound" type="checkbox" name="privilege-outbound" class="user-privilege" value=""/> Outbound Schedule</label>
			<label><input id="privilege-inbound" type="checkbox" name="privilege-inbound" class="user-privilege" value=""/> Inbound Schedule</label>
			<label><input id="privilege-inboundshipping" type="checkbox" name="privilege-inboundshipping" class="user-privilege" value=""/> Inbound Shipping</label>
			<label><input id="privilege-history" type="checkbox" name="privilege-history" class="user-privilege" value=""/> Data History</label>
			<label><input id="privilege-status" type="checkbox" name="privilege-status" class="privilege-status" value="production-status"/> Production Status(Only)</label>


			<div class="row">
				<div class="small-12 center-align msg-alert">
				</div>
			</div>
			<br/>
			<a href="#" id="create-btn" class="button expand" data-action="create">Create</a>
		</form>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

	<div id="editUserModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h2 id="modalTitle">Edit User</h2>
		<form id="user-form">
			<input type="hidden" id="user-id-edit" name="_token" value="">
			{{ Form::label('user_username', 'Username') }}
			{{ Form::text('user_username_edit', '', ['placeholder' => 'Username','id' => 'user-name-edit']) }}

			{{ Form::label('user_name', 'Name') }}
			{{ Form::text('user_name_edit', '', ['placeholder' => 'Name', 'id' => 'name-edit']) }}

			{{ Form::label('user_status', 'Status :') }}
			<label><input type="radio" name="user-status" class="user-status-edit" value="1" checked/> Active</label>
			<label><input type="radio" name="user-status" class="user-status-edit" value="0"/> Inactive</label>

			{{ Form::label('user_isadmin', 'Is Admin? :') }}
			<label><input type="radio" name="user-is-admin" class="user-is-admin-edit" value="1"/> Yes</label>
			<label><input type="radio" name="user-is-admin" class="user-is-admin-edit" value="0" checked/> No</label>

			{{ Form::label('access_rights', 'Access Rights :') }}
			<label><input id="privilege-production-edit" type="checkbox" name="privilege-production-edit" class="user-privilege" value=""/> Production Schedule</label>
			<label><input id="privilege-outbound-edit" type="checkbox" name="privilege-outbound-edit" class="user-privilege" value=""/> Outbound Schedule</label>
			<label><input id="privilege-inbound-edit" type="checkbox" name="privilege-inbound-edit" class="user-privilege" value=""/> Inbound Schedule</label>
			<label><input id="privilege-inboundshipping-edit" type="checkbox" name="privilegeinbound-shipping-edit" class="user-privilege" value=""/> Inbound Shipping</label>
			<label><input id="privilege-history-edit" type="checkbox" name="privilege-history-edit" class="user-privilege" value=""/> Data History</label>
			<label><input id="privilege-status-edit" type="checkbox" name="privilege-status-edit" class="user-privilege" value=""/> Production Status(Only)</label>

			<div class="row">
				<div class="small-12 center-align msg-alert msg-alert-edit">
				</div>
			</div>
			<br/>
			<a href="#" id="edit-btn" class="button expand" data-action="create">Edit</a>
		</form>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

@stop

@section('custom-js')
<script type="text/javascript">
	$(document).ready(function() {

		$("#create-btn").click(function() {
			var form_object  		 = {},
				privilege_object 	 = {},
				username             = $("#user_username").val(),
				password             = $("#user_password").val(),
				password2            = $("#user_retype_password").val(),
				name                 = $("#name").val(),
				active 	             = $(".user-status:checked").val(),
				is_admin             = $(".user-is-admin:checked").val(),
				error_msg            = "",
				url 	             = '{{ URL::to("manage_user/addUser") }}',
				privilege_production = $("#privilege-production").prop("checked"),
				privilege_outbound   = $("#privilege-outbound").prop("checked"),
				privilege_inbound    = $("#privilege-inbound").prop("checked"),
				privilage_inbound_shipping    = $("#privilege-inboundshipping").prop("checked"),
				privilege_history    = $("#privilege-history").prop("checked"),
				privilege_status 	 = $(".privilege-status").prop("checked")
			;
			
			$(".msg-alert").empty();

			if(username.length == 0) {
				error_msg += "Username Field is required.<br/>";
			}

			if(password.length == 0) {
				error_msg += "Password Field is required.<br/>";
			}

			if(password2.length == 0) {
				error_msg += "Confirm password Field is required.<br/>";
			}

			if(name.length == 0) {
				error_msg += "Name Field is required.<br/>";
			}

			if(error_msg == "") {
				if(password != password2) {
					error_msg += "Password and Confirm password needs to match.<br/>";
				} else {
					form_object['username'] = username;
					form_object['password'] = password;
					form_object['name']     = name;
					form_object['active']   = active;
					form_object['is_admin'] = is_admin;

					privilege_object['production'] = privilege_production;
					privilege_object['outbound']   = privilege_outbound;
					privilege_object['inbound']    = privilege_inbound;
					privilege_object['inboundshipping']    = privilage_inbound_shipping;
					privilege_object['history']    = privilege_history;
					privilege_object['production-status'] = privilege_status;

					if(privilege_status == true) {
						privilege_object['production'] = true;
					}

	                $.ajax({
	                    async   : false,
	                    method  : "POST",
	                    url     : url,
	                    data    : {"fields"        : form_object,
	                    		   "access_rights" : privilege_object,
	                               "_token"        : "{{ csrf_token() }}"},
	                    success : function(result) {
	                        obj_result = JSON.parse(result);

	                        if(obj_result.status == 'failed') {
	                            error_msg = obj_result.message;
	                        } else {
	                            alert("User successfully added.");
	                            location.reload();
	                        }
	                    }
	                });
				}
			}
			
			if(error_msg != "") {
				$(".msg-alert").append(error_msg);
			}
		});

		$("body").on("click", ".user-delete", function() {
			var user_id 	= $(this).attr("user-id"),
				form_object = {},
				url 	    = '{{ URL::to("manage_user/deleteUser") }}',
				error_msg   = ""
			;

			form_object['id'] = user_id;

            $.ajax({
                async   : false,
                method  : "POST",
                url     : url,
                data    : {"fields" : form_object,
                           "_token" : "{{ csrf_token() }}"},
                success : function(result) {
                    obj_result = JSON.parse(result);

                    if(obj_result.status == 'failed') {
                        error_msg = obj_result.message;
                    } else {
                        alert("User successfully remove.");
                        location.reload();
                    }
                }
            });

			if(error_msg != "") {
				$(".msg-alert").append(error_msg);
			}
		});

		$("body").on("click", ".user-edit", function() {
			var username = $(this).closest("tr").find(".user-username").html(),
				name 	 = $(this).closest("tr").find(".user-name").html(),
				active   = $(this).closest("tr").find(".user-status").attr("cell-value"),
				is_admin = $(this).closest("tr").find(".user-is-admin").attr("cell-value"),
				user_id  = $(this).attr("user-id");
			;

			$("#user-id-edit").val(user_id);
			$("#user-name-edit").val(username);
			$("#name-edit").val(name);
			$(".user-status-edit[value='" + active+ "'").prop("checked",true);
			$(".user-is-admin-edit[value='" + is_admin+ "'").prop("checked",true);

			$('#editUserModal').foundation('reveal', 'open');
		});

		$("body").on("click", "#edit-btn", function() {
			var user_id 	= $("#user-id-edit").val(),
				username    = $("#user-name-edit").val(),
				name        = $("#name-edit").val(),
				active 	    = $(".user-status-edit:checked").val(),
				is_admin    = $(".user-is-admin-edit:checked").val(),
				error_msg   = "",
				url 	    = '{{ URL::to("manage_user/editUser") }}',
				form_object = {},

				privilege_production = $("#privilege-production-edit").prop("checked"),
				privilege_outbound   = $("#privilege-outbound-edit").prop("checked"),
				privilege_inbound    = $("#privilege-inbound-edit").prop("checked"),
				privilage_inbound_shipping    = $("#privilege-inboundshipping-edit").prop("checked"),
				privilege_history    = $("#privilege-history-edit").prop("checked"),
				privilege_production_status = $("#privilege-status-edit").prop("checked"),
				privilege_object 	 = {}
			;

			$(".msg-alert-edit").empty();

			if(username.length == 0) {
				error_msg += "Username Field is required.<br/>";
			}

			if(name.length == 0) {
				error_msg += "Name Field is required.<br/>";
			}

			if(error_msg == "") {
					form_object['id'] 		= user_id;
					form_object['username'] = username;
					form_object['name']     = name;
					form_object['active']   = active;
					form_object['is_admin'] = is_admin;

					privilege_object['production'] = privilege_production;
					privilege_object['outbound']   = privilege_outbound;
					privilege_object['inbound']    = privilege_inbound;
					privilege_object['inboundshipping']    = privilage_inbound_shipping;
					privilege_object['history']    = privilege_history;
					privilege_object['production-status']    = privilege_production_status;

					if(privilege_production_status == true) {
						privilege_object['production'] = true;
					}

	                $.ajax({
	                    async   : false,
	                    method  : "POST",
	                    url     : url,
	                    data    : {"fields" : form_object,
	                    		   "access_rights" : privilege_object,
	                               "_token" : "{{ csrf_token() }}"},
	                    success : function(result) {
	                        obj_result = JSON.parse(result);

	                        if(obj_result.status == 'failed') {
	                            error_msg = obj_result.message;
	                        } else {
	                            alert("User successfully updated.");
	                            location.reload();
	                        }
	                    }
	                });
			}

			if(error_msg != "") {
				$(".msg-alert-edit").append(error_msg);
			}
		});

		$("body").on("click", ".privilege-status", function() {
			var privilegeVal = $(this).val();

			if(privilegeVal == 'production-status') {
				$(".user-privilege").prop("checked", false);
			}
		});

		$("body").on("click", ".user-privilege", function() {
			$(".privilege-status").prop("checked", false);
		});




	}); //end document
</script>
@stop