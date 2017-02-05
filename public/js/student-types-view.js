$(document).ready(function(){
    var table = $('#student-types-table').DataTable({
        "columns": [
            null,
            null,
            null,
            null,
            {
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
            },
        ],
        "order": [[0, 'asc']]
    });

    // Add event listener for opening and closing details
    $('#student-types-table tbody').on('click', 'td.details-control', function () {
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
return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<tr>'+
        '<td>Full name:</td>'+
        '<td>'+ 'Name' +'</td>'+
    '</tr>'+
    '<tr>'+
        '<td>Extension number:</td>'+
        '<td>'+ 'Name' +'</td>'+
    '</tr>'+
    '<tr>'+
        '<td>Extra info:</td>'+
        '<td>And any further details here (images etc)...</td>'+
    '</tr>'+
'</table>';
}
