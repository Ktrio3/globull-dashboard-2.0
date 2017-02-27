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
      <p>A list of the different users that have access to admin side of the dashboard. The different roles are as follows:</p>
      <ul>
        <li>Master: Can add users</li>
        <li>Modder: Can edit/create Attributes, Student Types, etc.</li>
        <li>Uploader: Can upload excel sheets with student information.</li>
        <li>Updater: Can update an individual student's record by viewing their profile in the students tab.</li>
        <li>Viewer: Can view and export student records, view Student Types, Attributes, etc. and preview Student Type layouts. </li>
      </ul>
      <p>Note that each role has all of it's listed privelages, and all of the privelages of the roles below it.</p>
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
                <td><a href="{{route('users.edit', array($user->id))}}">{{$user->netid}}</a></td>
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
