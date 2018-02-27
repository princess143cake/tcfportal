@include('layouts.header')
@if(Request::segment(1) != 'fsf')
<section id="top-nav">
    <div id="logo" class="left">
        <a href="{{ URL::to('/') }}">TILLSONBURG CUSTOM FOODS</a>
    </div>
    @if(!empty($hide_header) && !$hide_header)
    <div id="user-display" class="right">
        <a href="#" data-dropdown="user-menu" aria-controls="user-menu" aria-expanded="false" class="dropdown">{{ Auth::User()->name }} <i class="fa fa-sort-down"></i></a>
        <ul id="user-menu" data-dropdown-content class="f-dropdown" aria-hidden="true">
          <li><a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Log Out</a></li>
        </ul>
    </div>
    @endif
</section>
@endif
<div id="page-wrap"> {{-- Page Wrap Starts --}}
    <div class="row" style="min-width: 100%">
        <div class="large-12 column"> 
            @yield('content')
        </div> 
    </div>
</div> {{-- End of Page Wrap --}}

@include('layouts.scripts')