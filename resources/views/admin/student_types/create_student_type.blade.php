@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('student-types.index') }}">Student Types</a> &gt;</li>
<li class="last">{{ "Create Student Type" }}</li>
@endsection

@section('pagetitle') Create Student Type @endsection

@section('css')
@parent

@endsection

@section('js')
@parent
@endsection

@section('content')
  @parent
  {{Form::model($student_type, array('route' => array('student-types.store')))}}
    @include('components.student_type')
  {{Form::close()}}
@endsection
