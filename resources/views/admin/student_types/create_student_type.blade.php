@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('student-types.index') }}">Student Types</a> &gt;</li>
<li class="last">{{ "Create Student Type" }}</li>
@endsection

@section('pagetitle') Create Student Type @endsection

@section('css')
@parent
<link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('js')
@parent
<script src="{{url('/js/select2.min.js')}}"></script>
<script>
  var attributes = <?php echo json_encode(App\Attribute::all()) ?>;
</script>
<script src="{{url('/js/attribute-select.js')}}"></script>
@endsection

@section('content')
  @parent
  {{Form::model($student_type, array('route' => array('student-types.store')))}}
    @include('components.student_type')
  {{Form::close()}}
@endsection
