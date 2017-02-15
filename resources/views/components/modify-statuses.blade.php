<div class="row">
  <div class="col-xs-12">
    {{Form::button('Create New Status', ['class' => 'btn btn-primary pull-right', 'id'=> 'create-status', 'style' => 'margin-bottom:20px;'])}}
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-striped" id="statuses-table">
        <thead>
            <tr>
              <th>
                  Status
              </th>
              <th>
                  Import Code
              </th>
              <th>
                  Description
              </th>
              <th>
                  Completed
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
