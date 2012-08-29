(function($){
	
    $.confirm = function(params){
		
        if($('#confirmOverlay').length){
            // A confirm is already shown on the page:
            return false;
        }
		
        var markup = [
        '<div id="confirmOverlay">',
        '<div id="confirmBox">',
        '<h1>',params.title,'</h1>',
        '<p>',params.message,'</p>',
        '<div id="confirmButtons">',
        buttonHTML,
        '</div></div></div>'
        ].join('');
		
        $(markup).hide().appendTo('body').fadeIn();
		
        var buttons = $('#confirmBox .button'),
        i = 0;

        $.each(params.buttons,function(name,obj){
            buttons.eq(i++).click(function(){
				
                // Calling the action attribute when a
                // click occurs, and hiding the confirm.
				
                obj.action();
                $.confirm.hide();
                return false;
            });
        });
    }

    $.confirm.hide = function(){
        $('#confirmOverlay').fadeOut(function(){
            $(this).remove();
        });
    }
})(jQuery);