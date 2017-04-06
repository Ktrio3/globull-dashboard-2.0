@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('database.index') }}">Databases</a> &gt;</li>
<li class="last">{{ "Create Database" }}</li>
@endsection

@section('pagetitle') Create Database Connection @endsection

@section('css')
@parent
  <link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('js')
@parent
  <script src="{{url('/Datatables/datatables.min.js')}}"></script>
  <script>
    var attribute_database = <?php echo json_encode($database->attributes); ?>;
    var attributes = <?php echo json_encode(App\Attribute::whereHas('student_types', function ($query) use ($database) {$query->where('student_types.id', $database->student_type);})->get());?>
  </script>
  <script src="{{url('/js/select2.min.js')}}"></script>
  <script src="{{url('/js/modify-database-attributes.js')}}"></script>
@endsection

@section('content')
  @parent
  {{Form::model($database)}}
    <div class="row">
      <div class="col-xs-4">
        {{Form::bsText('name', "Connection Name", null, ['disabled'])}}
      </div>
      <div class="col-xs-4">
        {{Form::bsText('host', "Host Name", null, ['disabled'])}}
      </div>
      <div class="col-xs-2">
        {{Form::bsText('port', "Port #", null, ['required', 'disabled'])}}
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        {{Form::bsText('database', "Name of database", null, ['disabled'])}}
      </div>
      <div class="col-xs-4">
        {{Form::bsText('username', "Username", null, ['disabled'])}}
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        {{Form::bsText('password', "Password", null, ['disabled'])}}
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        {{Form::bsText('table', "Table to query", null, ['disabled'])}}
      </div>
      <div class="col-xs-4">
        {{Form::bsText('uid_column', "Name of UID column", null, ['disabled'])}}
      </div>
      <div class="col-xs-4">
        {{Form::bsSelect('student_type', "Student Type", App\StudentType::pluck('name', 'id'), $database->student_type, "Select a student type", ['required', 'id' => 'roles', 'disabled'])}}
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        {{Form::bsSelect('driver', "Database Type", ["sqlsrv" => "Microsoft SQL Server", "mysqli" => "MySQL"], $database->driver, null, ['disabled'])}}
      </div>
    </div>
  {{Form::close()}}
  <h3> Mapping attributes to columns:</h3>
  {{Form::open(array('route' => array('database.update_attributes', $database->id), 'method' => 'POST'))}}
    @include('components.map_database_attributes')
    <div class="row">
      <div class="col-xs-12">
        {{Form::submit('Save Attributes', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
      </div>
    </div>
  {{Form::close()}}
@endsection
