@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Student Types" }}</li>
@endsection

@section('pagetitle') Student Types @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('Datatables/datatables.min.css')}}">

@endsection

@section('js')
@parent
    <script src="{{url('Datatables/datatables.min.js')}}"></script>
    <script>
      var student_types = <?php echo json_encode(App\StudentType::with('attributes')->get()) ?>;
      var STUDTYPE_EDIT_URL = "{{route('student-types.index')}}";
    </script>
    <script src="{{url('js/student-types-view.js')}}"></script>
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
      <table class="table table-striped" id="student-types-table">
          <thead>
              <tr>
                  <th>
                      Student Type
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
                      Attr.
                  </th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>
  </div>
@endsection
