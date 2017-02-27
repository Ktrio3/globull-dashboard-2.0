@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Home" }}</li>
@endsection

@section('pagetitle') Admin Dashboard @endsection

@section('css')
@parent
@endsection

@section('js')
@parent
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p>Welcome to the admin side of the USF Orientation Dashboard! Here you can view the progress of students towards becoming
         new USF Bulls!
      </p>
      <p>
        The Student tab is the heart of the Dashboard. There you can view all of the student records, track an individual student's
        progress, and export the records to an excel sheet.
      </p>
      <p>
        The Statistics tab contains all sorts of useful ways to evaluate the progress of students en-masse.
      </p>
      <p>
        The Orientation Dashboard has a lot of data required "under-the-hood" to make it work. All of this data is visible through the
        Admin tab! If you are ever unsure about an attribute, status, import code, or anything else, more information about it can be
        found under here.
      </p>
    </div>
  </div>
@endsection
