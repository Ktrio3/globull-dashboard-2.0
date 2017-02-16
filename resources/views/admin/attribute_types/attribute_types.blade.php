@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Attribute Types" }}</li>
@endsection

@section('pagetitle') Attribute Types @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
    <script src="{{url('/Datatables/datatables.min.js')}}"></script>
    <script>
      var attribute_types = <?php echo json_encode(App\AttributeType::with('attributes')->get()) ?>;
      var ATTR_TYPE_EDIT_URL = "{{route('attribute-types.index')}}";
    </script>
    <script src="{{url('/js/attribute-types-view.js')}}"></script>
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p>Some super important text here explaining what is going down.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped" id="attributes-table">
          <thead>
              <tr>
                  <th>
                      Attribute Type
                  </th>
                  <th>
                      Description
                  </th>
                  <th style="width:50px;">
                      Attributes
                  </th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>
  </div>
@endsection
