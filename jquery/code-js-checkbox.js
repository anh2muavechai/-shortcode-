$( "#even_allday_yn").prop('checked', true);

hoặc

$('#myCheckbox').attr('checked', 'checked');
remove
$('#myCheckbox').removeAttr('checked');

check is checked
if ($('#myCheckbox').is(':checked'))