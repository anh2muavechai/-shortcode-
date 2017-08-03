			$('.input').keypress(function (e) {
				if (e.which == 13) {
					$('form#login').submit();
				    return false;    //<---- Add this line
				}
			});