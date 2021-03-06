@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('users.index') }}">Users</a> &gt;</li>
<li class="last">{{ "Update User" }}</li>
@endsection

@section('pagetitle') Update User @endsection

@section('css')
@parent
  <link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('js')
@parent
  <script>
    var roles = <?php echo json_encode(App\Role::all()) ?>;
  </script>
  <script src="{{url('/js/select2.min.js')}}"></script>
  <script src="{{url('/js/user-role-select.js')}}"></script>
@endsection

@section('content')
  @parent
  {{Form::model($user, array('route' => array('users.update', $user->id), 'method'=> 'PUT'))}}
    @include('components.users')
  {{Form::close()}}
@endsection
