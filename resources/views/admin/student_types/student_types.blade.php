@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Student Types" }}</li>
@endsection

@section('pagetitle') Student Types @endsection

@section('css')
@parent
    <link rel="stylesheet" href="/Datatables/datatables.min.css">

@endsection

@section('js')
@parent
    <script src="/Datatables/datatables.min.js"></script>
    <script src="/js/student-types-view.js"></script>
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
            @foreach(App\StudentType::all() as $type)
              <tr>
                  <td>
                      <a href="{{ route('student-types.edit', ['studentType' => $type->id]) }}" >{{$type->name}}</a>
                  </td>
                  <td>
                      {{$type->code}}
                  </td>
                  <td>
                      {{$type->description}}
                  </td>
                  <td>
                      50 (100%)
                  </td>
                  <td>
                      <span class="glyphicon glyphicon-plus"></span>
                  </td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
@endsection
