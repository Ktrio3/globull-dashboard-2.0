@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Dashboard" }}</li>
@endsection

@section('pagetitle') Dashboard @endsection

@section('css')
@parent

<style>
  .border-below:not(:last-child) {
    border-bottom: 1px #ccc solid;
    margin-bottom: 1.5em;
  }

  tr.complete > td {
        background-color: #dff0d8;
  }
</style>
<link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">

@endsection

@section('js')
@parent

  <script src="{{url('/Datatables/datatables.min.js')}}"></script>
  <script>
    $(document).ready(function (){
      $('.table-responsive').DataTable({
        "columnDefs": [
          {"width": "10%", "orderable": false, "targets": [0,4] },
          {"orderable": false, "targets": [0,4] }
        ],
        "paging": false,
        "info" : false,
        "aaSorting": []
      })
    })
  </script>

@endsection

@section('content')
  @include('components.student-edit')
@endsection
