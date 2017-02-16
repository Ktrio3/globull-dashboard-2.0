@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Users" }}</li>
@endsection

@section('pagetitle') Users @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
    <script src="{{url('/Datatables/datatables.min.js')}}"></script>
    <script src="{{url('/js/users-view.js')}}"></script>
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
      <table class="table table-striped" id="users-table">
          <thead>
              <tr>
                  <th>
                      User
                  </th>
                  <th>
                      Netid
                  </th>
                  <th>
                      Email
                  </th>
                  <th>
                      Role
                  </th>
                  <th>
                      Created
                  </th>
                  <th>
                      Updated
                  </th>
              </tr>
          </thead>
          <tbody>
            @foreach(App\User::all() as $user)
              <tr>
                <td><a href="{{route('users.edit', array($user->id))}}">{{$user->first_name . ' ' . $user->last_name}}</a></td>
                <td>{{$user->netid}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role->role}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
@endsection
