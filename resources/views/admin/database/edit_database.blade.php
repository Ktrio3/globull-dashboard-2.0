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
    var attributes = <?php echo json_encode(App\Attribute::all()); ?>;
  </script>
  <script src="{{url('/js/select2.min.js')}}"></script>
  <script src="{{url('/js/modify-database-attributes.js')}}"></script>
@endsection

@section('content')
  @parent
  {{Form::model($database, array('route' => array('database.update', $database->id)))}}
    @include('components.databases')
  {{Form::close()}}
  <h3> Mapping attributes to columns</h3>
  <a href="{{route('database.edit_attributes', ['id' => 1])}}">Click here to add attributes for this database connection</a>
@endsection
