@include('layouts.header')

<div id="page-wrap"> {{-- Page Wrap Starts --}}
    <div class="off-canvas-wrap" data-offcanvas>
            <div class="inner-wrap">

                <a class="left-off-canvas-toggle hide-for-large-only left" id="mobile-menu-btn" href="#" ><i class="fa fa-bars"></i></a>

                <aside class="left-off-canvas-menu">
                    <ul class="no-bullet">
                        <li><a href="{{ URL::to('/') }}" class="{{ Request::segment(1) == '' ? 'active-side-nav' : '' }}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>

                        @if(user_access_rights(1) == "true")
                        <li><a href="{{ URL::to('production?product-date=').date('Y-m-d') }}" class="{{ Request::segment(1) == 'production' ? 'active-side-nav' : '' }}"><i class="fa fa-calendar"></i> <span>Production Schedule</span></a></li>
                        @endif
                        @if(user_access_rights(2) == "true")
                        <li><a href="{{ URL::to('outbound_schedule') }}" class="{{ Request::segment(1) == 'outbound_schedule' ? 'active-side-nav' : '' }}"><i class="fa fa-truck"></i> <span>Outbound Schedule</span></a></li>
                        @endif
                        @if(user_access_rights(3) == "true")
                        <li><a href="{{ URL::to('inbound_schedule') }}" class="{{ Request::segment(1) == 'inbound_schedule' ? 'active-side-nav' : '' }}"><i class="fa fa-cubes"></i> <span>Inbound Schedule</span></a></li>
                        @endif
                        @if(user_access_rights(4) == "true")
                        <li><a href="{{ URL::to('data_history') }}" class="{{ Request::segment(1) == 'data_history' ? 'active-side-nav' : '' }}"><i class="fa fa-history"></i> <span>Data History</span></a></li>
                        @endif
                        @if(Auth::user()->is_admin)
                        <li><a href="{{ URL::to('manage_user') }}" class="{{ Request::segment(1) == 'manage_user' ? 'active-side-nav' : '' }}"><i class="fa fa-user"></i> <span>Manage User</span></a></li>
                        @endif
                    </ul>
                </aside>

                {{-- Top nav --}}
                <section id="top-nav">
                    <div id="logo" class="left">
                        <a href="{{ URL::to('/') }}">TILLSONBURG CUSTOM FOODS</a>
                    </div>
                    <div id="user-display" class="right">
                        <a href="#" data-dropdown="user-menu" aria-controls="user-menu" aria-expanded="false" class="dropdown">{{ Auth::User()->name }} <i class="fa fa-sort-down"></i></a>
                        <ul id="user-menu" data-dropdown-content class="f-dropdown" aria-hidden="true">
                          <li class="user-settings"><a href="#"><i class="fa fa-cog"></i>&nbsp;&nbsp; Settings</a></li>
                          <li><a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Log Out</a></li>
                        </ul>
                    </div>
                </section> 

                {{-- Side Nav --}}
                <section id="side-nav" class="show-for-large-up">
                    <ul class="no-bullet">
                        <li><a href="{{ URL::to('/') }}" class="{{ Request::segment(1) == '' ? 'active-side-nav' : '' }}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
                        @if(user_access_rights(1) == "true")
                        <li><a href="{{ URL::to('production?product-date=').date('Y-m-d') }}" class="{{ Request::segment(1) == 'production' ? 'active-side-nav' : '' }}"><i class="fa fa-calendar"></i> <span>Production Schedule</span></a></li>
                        @endif

                        @if(user_access_rights(2) == "true")
                        <li><a href="{{ URL::to('outbound_schedule') }}" class="{{ Request::segment(1) == 'outbound_schedule' ? 'active-side-nav' : '' }}"><i class="fa fa-truck"></i> <span>Outbound Schedule</span></a></li>
                        @endif
                        @if(user_access_rights(3) == "true")
                        <li><a href="{{ URL::to('inbound_schedule') }}" class="{{ Request::segment(1) == 'inbound_schedule' ? 'active-side-nav' : '' }}"><i class="fa fa-cubes"></i> <span>Inbound Schedule</span></a></li>
                        @endif
                        @if(user_access_rights(4) == "true")
                        <li><a href="{{ URL::to('data_history') }}" class="{{ Request::segment(1) == 'data_history' ? 'active-side-nav' : '' }}"><i class="fa fa-history"></i> <span>Data History</span></a></li>
                        @endif
                        @if(Auth::user()->is_admin)
                        <li><a href="{{ URL::to('manage_user') }}" class="{{ Request::segment(1) == 'manage_user' ? 'active-side-nav' : '' }}"><i class="fa fa-user"></i> <span>Manage User</span></a></li>
                        @endif
                    </ul>
                </section>
                {{-- Main content --}}
                <section id="content">
                    @yield('content')
                </section>
                
                <a class="exit-off-canvas"></a>

            </div>
        </div>
</div>

<div id="userSettings" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">User settings</h2>
    <form id="user-form">
        {{ Form::label('user_username', 'Username') }}
        {{ Form::text('user_username', Auth::user()->username, ['placeholder' => 'Username','id' => 'user-name','disabled' => 'disabled']) }}

        {{ Form::label('user_password_settings', 'Enter New Password') }}
        {{ Form::password('user_password_settings', '', ['placeholder' => 'Password','id' => 'password']) }}

        {{ Form::label('user_retype_password_settings', 'Retype New Password') }}
        {{ Form::password('user_retype_password_settings', '', ['placeholder' => 'Password', 'id' => 'confirm-password']) }}

        <div class="row">
            <div class="small-12 center-align msg-alert msg-alert-settings">
            </div>
        </div>
        <br/>
        <a href="#" id="update-btn-settings" class="button expand" data-action="create">Update</a>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>{{-- End of Page Wrap --}}

@section('custom-js')
	<script type="text/javascript">
	$(document).ready(function() {
		$('#side-nav ul li a, .left-off-canvas-menu ul li a').hover(function() {
			$(this).addClass('hover-side-nav');
		}, function() {
			$(this).removeClass('hover-side-nav');
		});
	});
	</script>
@stop

@include('layouts.scripts')