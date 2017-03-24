@section('content')
  @parent
  <div class="row">
    <div class="col-xs-12">
      <p> Use the following options below to export the student information contained in the dashboard.
    </div>
  </div>
  {{Form::open(array('route' => array('admin.export'), 'method' => 'post'))}}
    <div class="row">
      <div class="col-xs-12">
        {{Form::bsRadio('filter', 'Include all students', 0, 1, ['required'])}}
        {{Form::bsRadio('filter', 'Filter students by criteria:', 1, 0, ['required'])}}
        {{Form::bsCheckbox('incomplete', 'Incomplete students only?')}}
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        {{Form::bsSelect('studentTypes[]', 'Student Types', App\StudentType::all()->pluck('name', 'id')->toArray(), [], 'Select some types', ['class' => 'attributes', 'multiple'])}}
      </div>
    </div>
    <?php $count = 0;?>
    @foreach(App\AttributeType::all() as $type)
      @if($count % 2 == 0)
        <div class="row">
      @endif
      <div class="col-xs-6">
        {{Form::bsSelect('attributes['.$type->id.'][]', $type->name . ' Attributes', $type->attributes->pluck('name', 'id')->toArray(), [], 'Select some attributes', ['class' => ' attributes', 'multiple'])}}
      </div>
      @if($count % 2 == 1)
        </div>
      @endif
      <?php $count++; ?>
    @endforeach
    <div class="row">
      <div class="col-xs-12">
        {{Form::submit('Export', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
      </div>
    </div>
  {{Form::close()}}
@endsection
