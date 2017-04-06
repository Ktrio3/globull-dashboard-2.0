$(document).ready(function(){
  console.log(attribute_database)
  console.log(attributes)

    var table = $('#attributes-table').DataTable({
        "data": attribute_database,
        "bPaginate": false,
        "columns": [
          { "data": "name" },
          {
            "data": null,
            "defaultContent": "Is found in the following column:"
          },
          { "data": "id" },
          {
              "className":      'details-remove',
              "orderable":      false,
              "searchable":     false,
              "data": null,
              "defaultContent": "<span style='color:red;font-size: 2em; margin-top:5px;' class='glyphicon glyphicon-remove'></span>"
          },
        ],
        "columnDefs": [
          { "width": "30%", "targets": [0] },
          { "width": "30%", "targets": [2] },
					{ "width": "10%", "targets": [3] },
        ],
        "order": [[0, 'asc']],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          // Create inputs

          console.log(typeof(aData.pivot))

          if(!aData.hasOwnProperty('pivot'))
          {
            column = ''
            attribute_id = ''
          }
          else
          {
            column = aData.pivot.column
            attribute_id = aData.pivot.attribute_id
          }

          $('td:eq(0)', nRow).html( createSelect("attribute", nRow._DT_RowIndex, attribute_id) );
          $('td:eq(2)', nRow).html( tableInput("column", nRow._DT_RowIndex, column) );
        }
    });

    // Add event listener for deleting attributes
    $('#attributes-table tbody').on('click', 'td.details-remove', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        if(confirm("Are you sure you want to delete this attribute permanently?"))
          row.remove().draw();;
    } );

    // Add event listener for creating attributes
    $('#create-attribute').on('click', function () {
      table.rows.add( [{
        "name": "",
        "id": -1,
        "description": "",
        "complete": 0,
        "code": ""
      } ] ).draw();
    } );
});

function createSelect(name, rowNum, value, hiddenID = false, id = -1)
{
  select = '<select class="form-control" required="required" name="attributes['
  select += rowNum + '][' + name + ']" value="' + value + '" id="code">'
  select += "<option value=''></option>"

  attributes.forEach(function(element)
  {
    if(value == element.id)
      select += "<option value='" + element.id + "' selected>" + element.name + "</option>"
    else
      select += "<option value='" + element.id + "'>" + element.name + "</option>"
  })

  select += "</select>"

  if(hiddenID)
  {
    r +='<input class="form-control" required="required" name="attributes['
    r +=  rowNum + '][id]" type="hidden" value="' + id + '" id="code">'
  }

  return select
}

function tableInput ( name, rowNum, value, hiddenID = false, id = -1 ) {
  r = '<input class="form-control" required="required" name="attributes['
  r +=  rowNum + '][' + name + ']" type="text" value="' + value + '" id="code">'

  if(hiddenID)
  {
    r +='<input class="form-control" required="required" name="attributes['
    r +=  rowNum + '][id]" type="hidden" value="' + id + '" id="code">'
  }

  return r;
}
