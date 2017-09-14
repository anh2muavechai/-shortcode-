jQuery(document).ready( function() {
	jQuery(".user_vote").click( function(e) {
		e.preventDefault();
		data_name = data
		nonce = jQuery(this).attr("data-nonce")
		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : Ajax.ajaxurl,
			data : {action: "{action_name}", data_name : data, nonce: nonce},
			beforeSend: function() {
		        // setting a timeout
		        //addClass('loading');
		        i++;
		    },
			success: function(response) {
				//removeClass('loading');
				//do something
			},
			error: function(xhr) { // if error occured
		        alert("Error occured.please try again");
		        //.append(xhr.statusText + xhr.responseText);
		        //.removeClass('loading');
		    },
		    complete: function() {
		        i--;
		        if (i <= 0) {
		            //.removeClass('loading');
		        }
		    },
		})
	})
})