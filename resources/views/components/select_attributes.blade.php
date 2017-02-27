<fieldset>
  <div class="row">
    <div class="col-xs-8">
      <?php if(isset($student_type))
              $attributes = $student_type->attributes->pluck('name', 'id')->toArray(); //Default values
            else
              $attributes = []; //No default values
            /* Default values are passed to select initally to allow select2 to select them, and allow us
                to continue passing the objects for use in the select2 templater
                (See attribute-select.js)
                 */
            ?>
      {{Form::bsSelect('attributes[]', "Attributes", $attributes, array_keys($attributes), "Select an existing attribute", [ 'id' => 'attributes', 'multiple'])}}
    </div>
  </div>
</fieldset>
