@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Export" }}</li>
@endsection

@section('pagetitle') Student Export @endsection

@section('css')
@parent
<link rel="stylesheet" href="{{url('css/select2.min.css')}}">
@endsection

@section('js')
@parent

  <script src="{{url('js/select2.min.js')}}"></script>
  <script>
    $(document).ready(function (){
      $('.attributes').select2({
        width:'100%'
      })
    })
  </script>

@endsection

@section('content')
  @include('components.student-export')
@endsection
