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
  {{Form::model($database, array('route' => array('database.store')))}}
    @include('components.databases')
  {{Form::close()}}
  <h3> Mapping attributes to columns</h3>
  <p>Save this database connection, and edit it to add attributes to pull.</p>
@endsection
