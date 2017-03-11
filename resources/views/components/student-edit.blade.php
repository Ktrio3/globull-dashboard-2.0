@section('content')
  @parent
  <div class="row border-below">
    <div class="col-xs-12">
      <h3>Welcome to your Student Dashboard!</h3>
      <p>
        Here you will have a personalized view of what you
        have completed and have left to complete before joining us at Orientation.
        It can be a little overwhelming to get all the appropriate documentation turned in,
        and we hope this dashboard can make that transition much less stressful.
        The goal is to have every one of the items listed below highlighted in green,
        to show that they have been turned in and approved before your arrival!
      </P>
      <p>If you have any other questions or are having trouble navigating your dashboard, please email us at <a href="mailto:globullbeginnings@usf.edu">globullbeginnings@usf.edu</a></p>
    </div>
  </div>
  {{Form::model($student, array('route' => array('student.update', $student->id), 'method' => 'post'))}}
  @foreach($student->attribute_types() as $attribute_type)
    <div class="row border-below">
      <div class="col-xs-12" style="margin-bottom:1.5em;">
        <h3>{{$attribute_type->name}} <!--<span class="label label-primary pull-right">Last Updated: <span class="time">11 March 2016 14:28 UTC+5</span></span>--></h3>
        <p>{{$attribute_type->description}}</p>
        <?php //var_dump($student) ?>
        <table class="table table-responsive">
    			<thead>
            <tr>
              <th></th>
              <th>Item</th>
              <th>Status</th>
              <th>Note</th>
              <th></th>
            </tr>
          </thead>
    			<tbody>
            <?php
              //Select the attributes for this type for ONLY the types of student this student has
              $attributes = $attribute_type->attributes()->whereHas('student_types', function($q) use ($student){
                $first = true;
                foreach($student->student_types as $student_type)
                {
                  if($first)
                  {
                    $q->where('student_types.id', $student_type->id);
                    $first = false;
                  }
                  else
                    $q->orWhere('student_types.id', $student_type->id);
                }
              })->get();
            ?>
            @foreach($attributes as $attribute)
              <?php $status = $student->statuses()->where('attribute_id', '=', $attribute->id)->first();
                if($status == null)
                  $status = (object) ["complete" => 0, "name" => 'Not yet entered', 'pivot' => (object) ['message' => '']];
              ?>
              <tr style="height:50px;" @if($status->complete == 1) class="complete" @endif>
                <td style="text-align:center;width:7%;">
                  @if($status->complete == 1)
                    <span class="glyphicon glyphicon-ok text-success"></span>
                  @endif
                </td>
                <td style="text-align:center;"><strong>{{$attribute->name}}</strong></td>
                @if($attribute->is_info)
                  <?php $statusValue = $status->pivot->value ?>
                  <td style="text-align:center;">{{Form::text('attributes[' . $attribute->id . '][status][value]', $statusValue, ['class' => 'form-control'])}}</td>
                @else
                  <?php $statusValue = (isset($status->id) ? $status->id : null) ?>
                  <?php $statusesForSelect = $attribute->statuses()->pluck('name', 'id')->toArray()?>
                  <?php $statusesForSelect[] = null?>
                  <td style="text-align:center;">{{Form::select('attributes[' . $attribute->id . '][status][id]', $attribute->statuses()->pluck('name', 'id')->toArray(), $statusValue, ['placeholder' => 'No status entered', 'class' => 'form-control'])}}</td>
                 @endif
                <td style="text-align:center;">{{Form::text('attributes[' . $attribute->id . '][status][message]', $status->pivot->message, ['class' => 'form-control'])}}</td>
                <td></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endforeach
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Save Student', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
  {{Form::close()}}
@endsection
