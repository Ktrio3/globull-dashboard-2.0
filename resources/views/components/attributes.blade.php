<fieldset>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('name', "Attribute Name", null, ['required'])}}
    </div>
    <div class="col-xs-2">
      {{Form::bsText('code', "Import Code", null, ['required'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::bsTextarea('description', "Attribute Description", null, ['required', 'style' => 'height:80px;'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3">
      <?php if(isset($attribute))
              $attributeTypes = $attribute->attribute_type()->pluck('name', 'id')->toArray(); //Default values
            else
              $attributeTypes = []; //No default values
            /* Default values are passed to select initally to allow select2 to select them, and allow us
                to continue passing the objects for use in the select2 templater
                (See attribute-select.js)
                 */
            ?>
      {{Form::bsSelect('attribute_type', "Attribute Types", $attributeTypes, array_keys($attributeTypes), "Select an existing attribute type", ['required', 'id' => 'attribute_types'])}}
    </div>
    <div class="col-xs-9">
      {{Form::button('Make Attribute Fillable', ['class' => 'btn btn-primary pull-right', 'id' => 'toggle_is_info', 'style' => 'margin-bottom:20px;'])}}
      {{Form::hidden('is_info', null, ['id' => 'is_info'])}}
    </div>
  </div>
  <div id="status-div">
    @include('components.modify-statuses')
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Save Attribute', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
</fieldset>
