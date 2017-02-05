@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('student-types.index') }}">Student Types</a> &gt;</li>
<li class="last">{{ "Edit Student Type" }}</li>
@endsection

@section('pagetitle') Edit Student Type @endsection

@section('css')
@parent

@endsection

@section('js')
@parent
@endsection

@section('content')
  @parent
  {{Form::model($student_type, array('route' => array('student-types.update', $student_type->id), 'method' => 'put'))}}
    @include('components.student_type')
  {{Form::close()}}
@endsection
