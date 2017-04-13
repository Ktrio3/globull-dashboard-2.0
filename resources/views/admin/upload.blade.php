@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Upload" }}</li>
@endsection

@section('pagetitle') Upload @endsection

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
      <p>A temporary home screen for uploads</p>
      {{Form::open(array('route' => array('admin.upload'), 'files' => true))}}
        {{Form::file('sheet', ['required'])}}
        {{Form::submit('Save User', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
      {{Form::close()}}
    </div>
  </div>
  {{Form::open(array('route' => 'database.run'))}}
    <p>Run the following database update:</p>
    <div class="row">
      <div class="col-xs-6">
          {{Form::bsSelect('database', "Database", App\Database::pluck('name', 'id')->toArray(), null, "Select A Datbase", ['required'])}}
          {{Form::submit('Run Database Update', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
      </div>
      <div class="col-xs-2">
          {{Form::bsText('year', "Year", null, ['required'])}}
      </div>
      <div class="col-xs-2">
          {{Form::bsSelect('semester', "Semester", ['08' => 'Fall', '01' => 'Spring', '05' => 'Summer'], null, "Select A Semester", ['required'])}}
      </div>
    </div>
  {{Form::close()}}
@endsection
