$(document).ready(function(){
  var attributeSelect = $('#attributes').select2({
    data: attributes,
    templateResult: formatAttribute,
    templateSelection: formatAttributeBox,
  })
});

function formatAttribute(item)
{
  if (!item.id) { return item.text; }
  var $attribute = $(
    "<div><label>" + item.name + "</label><br />" + item.description + "</div>"
  );
  return $attribute;
}

function formatAttributeBox(item)
{
  return item.name;
}
