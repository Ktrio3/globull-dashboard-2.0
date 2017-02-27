$(document).ready(function(){

  is_status();

  // Add event listener for creating attributes
  $('#toggle_is_info').on('click', toggle_status);
});

function is_status()
{
  var is_info = $('#is_info')

  if(is_info.val() == 1)
  {
    $('#status-div').hide()
    $('#toggle_is_info').text('Use Statuses')
  }
  else
  {
    $('#status-div').show()
    $('#toggle_is_info').text('Make Attribute Fillable')
  }
}

function toggle_status()
{
  var is_info = $('#is_info')

  if(is_info.val() == 1)
  {
    is_info.val(0)
  }
  else
  {
    is_info.val(1)
  }

  is_status()
}
