    {{ HTML::script('assets/f5/js/vendor/jquery.js') }}
    {{ HTML::script('assets/f5/js/foundation.min.js') }}

    {{ HTML::script('assets/dtp/build/jquery.datetimepicker.full.min.js') }}
    {{ HTML::script('assets/plugins/responsive-tables.js') }}
    {{ HTML::script('assets/jquery-ui/jquery-ui.min.js') }}
	{{ HTML::script('assets/plugins/moment.js') }}
	{{ HTML::script('assets/plugins/livestamp.js') }}
    <script>
        $(document).foundation();
    </script>
	<script type="text/javascript">
	    $(document).ready(function() {
	        $('#side-nav ul li a, .left-off-canvas-menu ul li a').hover(function() {
	            $(this).addClass('hover-side-nav');
	        }, function() {
	            $(this).removeClass('hover-side-nav');
	        });

	        $("body").on("click", ".user-settings", function() {
	            $('#userSettings').foundation('reveal', 'open');
	        });

	        $("#update-btn-settings").click(function() {
	        	var user_id 		 = "{{@Auth::user()->id}}",
	        		password 		 = $(this).closest("form").find("#user_password_settings").val(),
	        		confirm_password = $(this).closest("form").find("#user_retype_password_settings").val(),
	        		url 	    	 = '{{ URL::to("manage_user/editSettings") }}',
	        		error_msg 		 = "",
	        		form_object 	 = {}
	        	;

	        	$(".msg-alert-settings").empty();

	        	if(password.length == 0) {
	        		error_msg += "Password is Required<br/>";
	        	}

	        	if(confirm_password.length == 0) {
	        		error_msg += "Confirm Password is Required<br/>";
	        	}

	        	if(error_msg == "") {
	        		if(confirm_password != password) {
	        			error_msg += "Password and Confirm Password should match.<br/>";
	        		} else {
						form_object['id'] 		= user_id;
						form_object['password'] = password;

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
		                            alert("Settings successfully updated.");
		                            location.reload();
		                        }
		                    }
		                });
	        		}
	        	}

	        	if(error_msg != "") {
	        		$(".msg-alert-settings").append(error_msg);
	        	}
	        })
	    });
	</script>
	
    {{-- Custom Javascripts --}}
    @yield('custom-js')
</body>
</html>