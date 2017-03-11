@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li class="last">{{ "Students" }}</li>
@endsection

@section('pagetitle') Students @endsection

@section('css')
@parent
    <link rel="stylesheet" href="{{url('Datatables/datatables.min.css')}}">
@endsection

@section('js')
@parent
    <script src="{{url('Datatables/datatables.min.js')}}"></script>
    <script>
      var student_types = <?php echo json_encode(App\StudentType::with('attributes')->get()) ?>;
      var STUDTYPE_EDIT_URL = "{{route('student-types.index')}}";

      $(document).ready(function(){
        var table = $('#student-table').DataTable()

        $('#student-table tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        });

        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
      })
    </script>
    <script src="{{url('js/student-types-view.js')}}"></script>
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p>The information on a particular student can be found by following the link on their UID or NetID.
        The search bar can be used to filter all the different columns at once. The search bars at the bottom will allow
        the columns to be filtered on a one-to-one basis. Clicking on a column header will order the rows, and
        shift-clicking will allow ordering by multiple columns.
      </p>
      <p>If the user has the correct permissions, an individual student record can be edited.</p>
      <a href="{{route("admin.export")}}">Click here to export student information.</a><br/><br/>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped" id="student-table">
          <thead>
              <tr>
                  <th>Student UNumber</th>
                  <th>NetID</th>
                  <th>Semester</th>
                  <th>Created At</th>
                  <th>Updated At</th>
              </tr>
          </thead>
          <tbody>
            @foreach(App\Student::all() as $student)
              <tr>
                <th>
                    <a href="{{route('admin.view-students', [$student->id])}}">{{$student->UID}}</a>
                </th>
                <th>
                    <a href="{{route('admin.view-students', [$student->id])}}">{{$student->netid}}</a>
                </th>
                <th>
                    {{$student->admit_semester}}
                </th>
                <th>
                    {{$student->created_at}}
                </th>
                <th>
                    {{$student->updated_at}}
                </th>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                  <th>Student UNumber</th>
                  <th>NetID</th>
                  <th>Semester</th>
                  <th>Created At</th>
                  <th>Updated At</th>
              </tr>
          </tfoot>
      </table>
    </div>
  </div>
@endsection
