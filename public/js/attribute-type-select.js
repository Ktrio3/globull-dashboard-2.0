$(document).ready(function(){
  var attributeSelect = $('#attribute_types').select2({
    data: attributeTypes,
    templateResult: formatAttributeType,
    templateSelection: formatAttributeTypeBox,
  })
});

function formatAttributeType(item)
{
  if (!item.id) { return item.text; }
  var $attribute = $(
    "<div><label>" + item.name + "</label><br />" + item.description + "</div>"
  );
  return $attribute;
}

function formatAttributeTypeBox(item)
{
  return item.name;
}
