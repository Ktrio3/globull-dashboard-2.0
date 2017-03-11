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
      <p>A temporary home screen for uploads
      </p>
      {{Form::open(array('route' => array('admin.upload'), 'files' => true))}}
        {{Form::file('sheet', ['required'])}}
        {{Form::submit('Save User', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
      {{Form::close()}}

    </div>
  </div>
@endsection
