$.get(view.path, function(data) {
	var body = data.replace(/^[\S\s]*<body[^>]*?>/i, "").replace(/<\/body[\S\s]*$/i, "");
	var style = '<style type="text\/css">' + data.replace(/^[\S\s]*<style type="text\/css">/i, "").replace(/<\/style[\S\s]*$/i, "");
    $('#result').html(body);
    $('#result').append(style);
    $.each(row_input, function (i, j) {
    	$('#result tr.row' + j).find('td').each(function(key, ele) {
    		var myClasses  = this.classList;
    		var target_col = parseInt(myClasses[0].replace('column',''));
    		var col_text   = $('span', this).text();
    		if( target_col >= col){
    			$(this).html('<input value="'+col_text+'" type="text" class="input_update" name="data_update['+j+']['+target_col+']">');
    		}
    	});
    })
})