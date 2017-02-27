<fieldset>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('first_name', "First Name", null, [''])}}
    </div>
    <div class="col-xs-4">
      {{Form::bsText('last_name', "Last Name", null, [''])}}
    </div>
    <div class="col-xs-2">
      {{Form::bsText('netid', "NetID", null, ['required'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('email', "Email", null, [''])}}
    </div>
    <div class="col-xs-2">
      <?php if($user)
              $userRoles = $user->role()->pluck('role', 'id')->toArray(); //Default values
            else
              $userRoles = []; //No default values
            /* Default values are passed to select initally to allow select2 to select them, and allow us
                to continue passing the objects for use in the select2 templater
                (See attribute-select.js)
                 */
            ?>
      {{Form::bsSelect('role_id', "Role", $userRoles, array_keys($userRoles), "Select an existing role", ['required', 'id' => 'roles'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Save User', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
</fieldset>
