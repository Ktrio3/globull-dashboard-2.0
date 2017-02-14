$(document).ready(function(){
    var table = $('#statuses-table').DataTable({
        "data": statuses,
        "bPaginate": false,
        "columns": [
          { "data": "name" },
          { "data": "code" },
          { "data": "description" },
          {
              "className":      'details-remove',
              "orderable":      false,
              "searchable":     false,
              "data": null,
              "defaultContent": "<span class='glyphicon glyphicon-remove'></span>"
          },
        ],
        "columnDefs": [
          { "width": "20%", "targets": [0] },
          { "width": "10%", "targets": [1] },
          { "width": "5%", "targets": [3] },
        ],
        "order": [[0, 'asc']],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          // Create inputs
          $('td:eq(0)', nRow).html( tableInput("name", nRow._DT_RowIndex, aData.name) );
          $('td:eq(1)', nRow).html( tableInput("code", nRow._DT_RowIndex, aData.code) );
          $('td:eq(2)', nRow).html( tableInput("description", nRow._DT_RowIndex, aData.description, true, aData.id) );
        }
    });

    // Add event listener for deleting attributes
    $('#statuses-table tbody').on('click', 'td.details-remove', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        if(confirm("Are you sure you want to delete this status permanently?"))
          row.remove().draw();;
    } );

    // Add event listener for creating attributes
    $('#create-status').on('click', function () {
      table.rows.add( [{
        "name": "",
        "id": -1,
        "description": "",
        "code": ""
      } ] ).draw();
    } );
});

function tableInput ( name, rowNum, value, hiddenID = false, id = -1 ) {
  r = '<input class="form-control" required="required" name="statuses['
  r +=  rowNum + '][' + name + ']" type="text" value="' + value + '" id="code">'

  if(hiddenID)
  {
    r +='<input class="form-control" required="required" name="statuses['
    r +=  rowNum + '][id]" type="hidden" value="' + id + '" id="code">'
  }

  return r;
}
