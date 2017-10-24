var fields = [];
$.each($('input[name="email[]"'),function(e) {
	fields.push({value: $(this).val()});
})
