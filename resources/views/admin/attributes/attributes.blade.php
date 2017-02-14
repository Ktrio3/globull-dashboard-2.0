@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Attributes" }}</li>
@endsection

@section('pagetitle') Attributes @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
    <script src="{{url('/Datatables/datatables.min.js')}}"></script>
    <script>
      var attributes = <?php echo json_encode(App\Attribute::with('statuses')->get()) ?>;
      var ATTR_EDIT_URL = "{{route('attributes.index')}}";
    </script>
    <script src="{{url('/js/attributes-view.js')}}"></script>
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p>Some super important text here explaining what is going down.</p>
    </div>
  </div>
  <div class="row" style="margin-bottom:20px;">
    <div class="col-xs-12">
      <a href="{{route('student-types.create')}}">Create a new student type</a>
    </div>
  </div>
  <div class="row" style="margin-bottom:20px;">
    <div class="col-xs-12">
      <a href="{{route('attributes.create')}}">Create a new attribute</a>
    </div>
  </div>
  <div class="row" style="margin-bottom:20px;">
    <div class="col-xs-12">
      <a href="{{route('attribute-types.create')}}">Create a new attribute type</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped" id="attributes-table">
          <thead>
              <tr>
                  <th>
                      Attribute
                  </th>
                  <th>
                      Import Code
                  </th>
                  <th>
                      Description
                  </th>
                  <th>
                      Num. Students
                  </th>
                  <th style="width:50px;">
                      Statuses
                  </th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>
  </div>
@endsection
