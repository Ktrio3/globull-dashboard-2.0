$(document).ready(function(){
  var roleSelect = $('#roles').select2({
    data: roles,
    templateResult: formatRole,
    templateSelection: formatRoleBox,
  })

  console.log(roles)
});

function formatRole(item)
{
  if (!item.id) { return item.text; }
  var $attribute = $(
    "<div><label>" + item.role + "</label></div>"
  );
  return $attribute;
}

function formatRoleBox(item)
{
  return item.role;
}
