@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('student-types.index') }}">Student Types</a> &gt;</li>
<li class="last">{{ "Edit Student Type" }}</li>
@endsection

@section('pagetitle') Edit Student Type @endsection

@section('css')
@parent
<link href="/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
@parent
<script src="/js/select2.min.js"></script>
<script>
  var attributes = <?php echo json_encode(App\Attribute::all()) ?>;
</script>
<script src="/js/attribute-select.js"></script>
@endsection

@section('content')
  @parent
  {{Form::model($student_type, array('route' => array('student-types.update', $student_type->id), 'method' => 'put'))}}
    @include('components.student_type')
  {{Form::close()}}
@endsection
