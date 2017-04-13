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
          { "data": null },
          { "data": null },
          {
              "className":      'details-remove',
              "orderable":      false,
              "searchable":     false,
              "data": null,
              "defaultContent": "<span style='color:red;font-size: 2em; margin-top:5px;' class='glyphicon glyphicon-remove'></span>"
          }
        ],
        "columnDefs": [
          { "width": "30%", "targets": [0] },
          { "width": "30%", "targets": [2] },
          { "width": "20%", "targets": [3] },
					{ "width": "10%", "targets": [4] },
        ],
        "order": [[0, 'asc']],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          // Create inputs
          column = ''
          attribute_id = ''
          message_column = ''
          if(aData.hasOwnProperty('pivot'))
          {

            column = aData.pivot.column
            attribute_id = aData.pivot.attribute_id
            if(typeof aData.pivot.message_column !== "undefined" && aData.pivot.message_column != "null")
              message_column = aData.pivot.message_column
          }
          current_value = $('td:eq(0)', nRow).find("select").val()
          if(typeof current_value != "undefined")
            attribute_id = current_value

          current_value = $('td:eq(2)', nRow).find("input").val()
          if(typeof current_value !== "undefined")
            column = current_value

          current_value = $('td:eq(3)', nRow).find("input").val()
          if(typeof current_value !== "undefined")
            message_column = current_value

          $('td:eq(0)', nRow).html( createSelect("attribute", nRow._DT_RowIndex, attribute_id) );
          $('td:eq(2)', nRow).html( tableInput("column", nRow._DT_RowIndex, column) );
          $('td:eq(3)', nRow).html( tableInputNotRequired("message_column", nRow._DT_RowIndex, message_column) );
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
  select += rowNum + '][' + name + ']" value="' + value + '">'
  select += "<option value=''></option>"

  attributes.forEach(function(element)
  {
    if(value == element.id)
      select += "<option value='" + element.id + "' selected>" + element.name + " (" + element.code + ")" + "</option>"
    else
      select += "<option value='" + element.id + "'>" + element.name + " (" + element.code + ")" + "</option>"
  })

  select += "</select>"

  if(hiddenID)
  {
    r +='<input class="form-control" required="required" name="attributes['
    r +=  rowNum + '][id]" type="hidden" value="' + id + '">'
  }

  return select
}


function tableInput ( name, rowNum, value, hiddenID = false, id = -1 ) {
  r = '<input class="form-control" required="required" name="attributes['
  r +=  rowNum + '][' + name + ']" type="text" value="' + value + '">'

  if(hiddenID)
  {
    r +='<input class="form-control" required="required" name="attributes['
    r +=  rowNum + '][id]" type="hidden" value="' + id + '">'
  }

  return r;
}

function tableInputNotRequired ( name, rowNum, value, hiddenID = false, id = -1 ) {
  r = '<input class="form-control" name="attributes['
  r +=  rowNum + '][' + name + ']" type="text" value="' + value + '">'

  if(hiddenID)
  {
    r +='<input class="form-control" required="required" name="attributes['
    r +=  rowNum + '][id]" type="hidden" value="' + id + '">'
  }

  return r;
}
