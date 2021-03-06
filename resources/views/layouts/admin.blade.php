@extends('layouts.app')

@section('meta')
<meta name="Description" content="USF Orientation Dashboard">
<meta name="Keywords" content="usf, orientation, tracking, requirements, dashboard">
@endsection

@section('pagetitle') Admin @endsection

@section('navbar')
  @if (Auth::check())
    @include('admin.navbar.navbar')
  @endif
@endsection

@section('css')
<!-- Dashboard -->
<link rel="stylesheet" href="{{ url('css/dashboard.min.css') }}" />
<!-- Growl -->
<link rel="stylesheet" href="{{ url('css/jquery.growl.min.css') }}" />
@endsection

@section('breadcrumbs')
<li><a href="{{ route('admin.index') }}">Admin</a> &gt;</li>
@endsection

@section('js')
<script src="{{ url('js/jquery.growl.min.js') }}"></script>
@endsection
