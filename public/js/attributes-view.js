$(document).ready(function(){
    var table = $('#attributes-table').DataTable({
        "data": attributes,
        "columns": [
          { "data": "name" },
          { "data": "code" },
          { "data": "description" },
          { "data": "id" },
          {
              "className":      'details-control',
              "orderable":      false,
              "searchable":     false,
              "data": null,
              "defaultContent": "<span class='glyphicon glyphicon-plus'></span>"
          },
        ],
        "columnDefs": [
          {
            "render": function(data, type, row){
              return "<a href='" + ATTR_EDIT_URL + '/' + row.id + "/edit'>" + data + "</a>"
            },
            "targets": 0
          }
        ],
        "order": [[0, 'asc']]
    });

    // Add event listener for opening and closing details
    $('#attributes-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
});

/* Formatting function for row details - modify as you need */
function format ( d ) {
// `d` is the original data object for the row
r = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<thead>'+
      '<tr>'+
        '<th>'+
          'Status'+
        '</th>'+
        '<th>'+
          'Code'+
        '</th>'+
        '<th>'+
          'Description'+
        '</th>'+
      '</tr>'+
    '</thead>'+
    '<tbody>';

    d.statuses.forEach(function(value){
      r += '<tr><td>'+ value.name +'</td>'+
          '<td>'+ value.code +'</td>'+
          '<td>'+ value.description +'</td></tr>'
    });

  return r + '</tbody>'+'</table>';
}
