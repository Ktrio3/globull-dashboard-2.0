$(document).ready(function(){
    var table = $('#databases-table').DataTable({
        "data": databases,
        "columns": [
          { "data": "name" },
          { "data": "table" },
          { "data": "student_type" },
          {
              "className":      'details-control',
              "orderable":      false,
              "searchable":     false,
              "data": null,
              "defaultContent": "<span class='glyphicon glyphicon-plus-sign' style='font-size:2em;color:green;'></span>"
          },
        ],
        "columnDefs": [
          {
            "render": function(data, type, row){
              return "<a href='" + DATA_EDIT_URL + '/' + row.id + "/edit'>" + data + "</a>"
            },
            "targets": 0
          },
          {
            "render": function(data, type, row){
              return row.student_type.description;
            },
            "targets": 2
          }
        ],
        "order": [[0, 'asc']]
    });

    // Add event listener for opening and closing details
    $('#databases-table tbody').on('click', 'td.details-control', function () {
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

        //Change dropdown icons
        $('td.details-control').html("<span class='glyphicon glyphicon-plus-sign' style='font-size:2em;color:green;'></span>");
        $('tr.shown td.details-control').html("<span class='glyphicon glyphicon-minus-sign' style='font-size:2em;color:red;'></span>");
    } );
});

/* Formatting function for row details - modify as you need */
function format ( d ) {
// `d` is the original data object for the row
r = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<thead>'+
      '<tr>'+
        '<th>'+
          'Attribute'+
        '</th>'+
        '<th>'+
          'Code'+
        '</th>'+
        '<th>'+
          'Description'+
        '</th>'+
        '<th>'+
          'Column'+
        '</th>'+
      '</tr>'+
    '</thead>'+
    '<tbody>';

    d.attributes.forEach(function(value){
      r += '<tr><td>'+ value.name +'</td>'+
          '<td>'+ value.code +'</td>'+
          '<td>'+ value.description +'</td>'+
          '<td>'+ value.pivot.column +'</td>'
    });

  return r + '</tbody>'+'</table>';
}
