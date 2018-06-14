//html
<div id="myID">ga</div>

//script
$.fn.hello = function(options){
    var defaults = {
        content : 'Hello world',
        color : 'black',
        fontStyle : 'italic',
        fontSize : 12
    };
    var options = $.extend(defaults, options);
    return this.each(function(){
        var that = $(this);
        that.text(options.content).css({
            color : options.color,
            'font-style' : options.fontStyle,
            'font-size' : options.fontSize
        });
    });
}
$('#myID').hello({
    content : 'Xin chào lập trình viên',
    color : 'red',
    fontStyle : 'bold',
    fontSize : 16
})