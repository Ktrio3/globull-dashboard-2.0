<div class="row">
  <div class="col-xs-12">
    {{Form::button('Create New Attribute', ['class' => 'btn btn-primary pull-right', 'id'=> 'create-attribute', 'style' => 'margin-bottom:20px;'])}}
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped" id="attributes-table">
        <thead>
            <tr>
              <th>
                  Attribute
              </th>
              <th>
                  Is found in the following column:
              </th>
              <th>
                  Column
              </th>
              <th>
                  Delete
              </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
</div>
