<fieldset>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('name', "Attribute Type Name", null, ['required'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::bsTextarea('description', "Attribute Type Description", null, ['required', 'style' => 'height:80px;'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Save Attribute Type', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
</fieldset>
