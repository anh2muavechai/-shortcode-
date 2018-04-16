//get screen width and height
function getViewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
}

//create element uniqueId
function generateUniqueId(prefix) {
	var r = Math.floor((Math.random() * 10000) + 1);
	var id = prefix + r;

	if( document.getElementById(id) )
		return generateUniqueId(prefix);
	else
		return id;
}