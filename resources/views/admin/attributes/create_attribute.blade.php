@extends('layouts.admin')

@section('breadcrumbs')
@parent
<li><a href="{{ route('attributes.index') }}">Attributes</a> &gt;</li>
<li class="last">{{ "Create Attribute" }}</li>
@endsection

@section('pagetitle') Create Attribute @endsection

@section('css')
@parent
  <link rel="stylesheet" href="{{url('/Datatables/datatables.min.css')}}">
  <link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('js')
@parent
  <script src="{{url('/Datatables/datatables.min.js')}}"></script>
  <script>
    var statuses = <?php echo json_encode($attribute->statuses()->whereHas('attribute', function($q){$q->where('is_info', '<>', 1);})) ?>;
    var attributeTypes = <?php echo json_encode(App\AttributeType::all()) ?>;
  </script>
  <script src="{{url('/js/select2.min.js')}}"></script>
  <script src="{{url('/js/attribute-type-select.js')}}"></script>
  <script src="{{url('/js/modify-statuses.js')}}"></script>
  <script src="{{url('/js/attributes.js')}}"></script>
@endsection

@section('content')
  @parent
  {{Form::model($attribute, array('route' => array('attributes.store')))}}
    @include('components.attributes')
  {{Form::close()}}
@endsection
