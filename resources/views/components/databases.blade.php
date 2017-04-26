<fieldset>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('name', "Connection Name", null, [''])}}
    </div>
    <div class="col-xs-4">
      {{Form::bsText('host', "Host Name", null, [''])}}
    </div>
    <div class="col-xs-2">
      {{Form::bsText('port', "Port #", null, ['required'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('database', "Name of database", null, [''])}}
    </div>
    <div class="col-xs-4">
      {{Form::bsText('username_database', "Username For Database", null, [''])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6">
      {{Form::bsText('password_database', "Password For Database", null, [''])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsText('table', "Table to query", null, [''])}}
    </div>
    <div class="col-xs-4">
      {{Form::bsText('uid_column', "Name of UID column", null, [''])}}
    </div>
    <div class="col-xs-4">
      <?php $vall = ''; if(isset($database->id)) $vall = $database->student_type;?>
      {{Form::bsSelect('student_type', "Student Type", App\StudentType::pluck('name', 'id'), $vall , "Select a student type", ['required', 'id' => 'roles'])}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-4">
      {{Form::bsSelect('driver', "Database Type", ["sqlsrv" => "Microsoft SQL Server", "mysqli" => "MySQL"], $database->driver)}}
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      {{Form::submit('Save Database', ['class' => 'btn btn-primary', 'style' => 'margin-bottom:20px;'])}}
    </div>
  </div>
</fieldset>
