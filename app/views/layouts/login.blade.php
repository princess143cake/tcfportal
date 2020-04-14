@include('layouts.header')

<div id="page-wrap"> {{-- Page Wrap Starts --}}
    @yield('content')
</div> {{-- End of Page Wrap --}}

@include('layouts.scripts')