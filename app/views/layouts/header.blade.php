<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Scheduler App | @yield('title')</title>



    {{-- Default --}}
    {{ HTML::style('assets/f5/css/normalize.css') }}
    {{ HTML::style('assets/f5/css/foundation.css') }}

    {{-- App Stylesheets --}}
    {{ HTML::style('assets/css/style.css') }}
    {{ HTML::style('assets/css/classes.css') }}
    {{ HTML::style('assets/css/responsive-tables.css') }}
    {{ HTML::style('assets/dtp/jquery.datetimepicker.css') }}
    {{ HTML::style('assets/jquery-ui/jquery-ui.min.css') }}
    {{ HTML::style('assets/jquery-ui/jquery-ui.theme.css') }}
	
    {{-- Google Fonts --}}
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'> 
    
    {{-- Font Awesome --}}
    {{ HTML::style('assets/fa/css/font-awesome.min.css') }}

    {{-- Custom Stylesheets --}}
    @yield('custom-css')

    {{-- Modernizr --}}
    {{ HTML::script('assets/f5/js/vendor/modernizr.js') }}

    
</head>
<body>
    