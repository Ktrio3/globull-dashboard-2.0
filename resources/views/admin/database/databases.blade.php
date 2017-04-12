@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Databases" }}</li>
@endsection

@section('pagetitle') Databases @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
    <script src="{{url('/Datatables/datatables.min.js')}}"></script>
    <script>
      var databases = <?php echo json_encode(App\Database::with(['attributes', 'student_type'])->get()) ?>;
      console.log(databases)
      var DATA_EDIT_URL = "{{route('database.index')}}";
    </script>
    <script src="{{url('/js/databases-view.js')}}"></script>
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p> Info </p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped" id="databases-table">
          <thead>
              <tr>
                  <th>
                      Database
                  </th>
                  <th>
                      Table
                  </th>
                  <th>
                      Student Type
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
