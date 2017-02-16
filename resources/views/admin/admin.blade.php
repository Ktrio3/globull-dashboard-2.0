@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Home" }}</li>
@endsection

@section('pagetitle') Admin Dashboard @endsection

@section('css')
@parent
@endsection

@section('js')
@parent
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p>A temporary home screen with links to different areas of the site. A brief description of the admin site would
        go nicely here, similar to the one Yaya sent me.
      </p>
    </div>
  </div>
@endsection
