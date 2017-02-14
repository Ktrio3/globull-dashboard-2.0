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
      <p>A temporary home screen with links to different areas of the site.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <ul>
        <li><a href="{{route('student-types.index')}}"> Student Types</a></li>
        <li>Upload</li>
        <li>Students</li>
        <li>Statistics</li>
        <li><a href="{{route('attribute-types.index')}}">Attribute Types</a></li>
        <li><a href="{{route('attributes.index')}}"> Attributes</a></li>
      </ul>
    </div>
  </div>
@endsection
