@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Attributes" }}</li>
@endsection

@section('pagetitle') Attributes @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
    <script src="{{url('/Datatables/datatables.min.js')}}"></script>
    <script>
      var attributes = <?php echo json_encode(App\Attribute::with(['statuses', 'attribute_type'])->get()) ?>;
      var ATTR_EDIT_URL = "{{route('attributes.index')}}";
    </script>
    <script src="{{url('/js/attributes-view.js')}}"></script>
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p>Below is a list of all the attributes availabull. Attributes make up the different fields that students have and need to complete, such as
        Admissions Deposit, or general information about students, such as First Name. Each attribute belongs to an attribute type, which categorizes
        the attributes into groups to display to the student. Each student type has a variety of attributes that belong to it.
      </p>
      <p>
        Each attribute has several statuses, which mark what state the attribute is in, or they are "fillable". Statuses that are marked as complete
        will show up as completed on the student's dashboard. Attributes that are marked as fillable do not have statuses. These attributes
        are things that vary by student, and need to be filled individually, such as first name and last name. Attributes that are fillable will have
        a single status with "-fillable" on the end of their code. 
      </p>
      <p>If the user has the correct permissions, the attributes can be edited by following the link on their name.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped" id="attributes-table">
          <thead>
              <tr>
                  <th>
                      Attribute
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
                      Statuses
                  </th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>
  </div>
@endsection
