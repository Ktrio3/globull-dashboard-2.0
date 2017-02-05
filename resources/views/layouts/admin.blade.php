@extends('layouts.app')

@section('meta')
<meta name="Description" content="USF Orientation Dashboard">
<meta name="Keywords" content="usf, orientation, tracking, requirements, dashboard">
@endsection

@section('pagetitle') Admin @endsection

@section('css')
<!-- Dashboard -->
<link rel="stylesheet" href="{{ url('css/dashboard.min.css') }}" />
<!-- Growl -->
<link rel="stylesheet" href="{{ url('css/jquery.growl.min.css') }}" />
@endsection

@section('breadcrumbs')
<li><a href="{{ url('admin') }}">Admin</a> &gt;</li>
@endsection

@section('js')
<script src="{{ url('js/jquery.growl.min.js') }}"></script>
@endsection
