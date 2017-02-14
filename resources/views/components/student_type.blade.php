<fieldset>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('name', "Student Type Name", null, ['required'])}}
    </div>
    <div class="col-xs-2">
      {{Form::bsText('code', "Student Type Code", null, ['required'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::bsTextarea('description', "Student Type Description", null, ['required', 'style' => 'height:80px;'])}}
    </div>
  </div>
  @include('components.select_attributes')
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Save Student Type', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
</fieldset>
