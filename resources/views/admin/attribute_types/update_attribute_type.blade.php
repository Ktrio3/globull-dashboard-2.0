@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('attribute-types.index') }}">Attributes</a> &gt;</li>
<li class="last">{{ "Create Attribute Type" }}</li>
@endsection

@section('pagetitle') Update Attribute Type @endsection

@section('css')
@parent
  <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
  <script src="{{url('/Datatables/datatables.min.js')}}"></script>
@endsection

@section('content')
  @parent
  {{Form::model($attributeType, array('route' => array('attribute-types.update', $attributeType->id), 'method' => 'put'))}}
    @include('components.attribute_types')
  {{Form::close()}}
@endsection
