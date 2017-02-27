@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Preview" }}</li>
@endsection

@section('pagetitle') Student Preview @endsection

@section('css')
@parent
  <link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('js')
@parent
  <script src="{{url('/js/select2.min.js')}}"></script>
  <script>
    $(document).ready(function(){
      $('#types').select2()
    })
  </script>
@endsection

@section('content')
  @parent
  {{Form::open(array('route' => array('admin.preview'), 'method' => 'post'))}}
  <div class="row">
    <div class="col-xs-12">
      <p> This page allows you to preview what the different student types will see.</p>
      <p>Select some student types below to see what students with those types will see. Note that All does not select all
      student types; it is a special type that all students fall into.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-5">
      {{Form::bsSelect('student_types[]', "Student Types", App\StudentType::pluck('name', 'id')->toArray(), null, "Select Some Student Types", [ 'id' => 'types', 'multiple', 'required'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Preview', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
  {{Form::close()}}
@endsection
