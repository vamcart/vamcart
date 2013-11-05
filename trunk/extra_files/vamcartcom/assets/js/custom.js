/*
|--------------------------------------------------------------------------
| UItoTop jQuery Plugin 1.2 by Matt Varone
| http://www.mattvarone.com/web-design/uitotop-jquery-plugin/
|--------------------------------------------------------------------------
*/
(function($){
	$.fn.UItoTop = function(options) {

 		var defaults = {
    			text: '',
    			min: 200,
    			inDelay:600,
				outDelay:400,
				containerID: 'toTop',
    			containerHoverID: 'toTopHover',
    			scrollSpeed: 1200,
    			easingType: 'linear'
 		    },
            settings = $.extend(defaults, options),
            containerIDhash = '#' + settings.containerID,
            containerHoverIDHash = '#'+settings.containerHoverID;
		
		$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');
		$(containerIDhash).hide().on('click.UItoTop',function(){
			$('html, body').animate({scrollTop:0}, settings.scrollSpeed, settings.easingType);
			$('#'+settings.containerHoverID, this).stop().animate({'opacity': 0 }, settings.inDelay, settings.easingType);
			return false;
		})
		.prepend('<span id="'+settings.containerHoverID+'"></span>')
		.hover(function() {
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 1
				}, 600, 'linear');
			}, function() { 
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 0
				}, 700, 'linear');
			});
					
		$(window).scroll(function() {
			var sd = $(window).scrollTop();
			if(typeof document.body.style.maxHeight === "undefined") {
				$(containerIDhash).css({
					'position': 'absolute',
					'top': sd + $(window).height() - 50
				});
			}
			if ( sd > settings.min ) 
				$(containerIDhash).fadeIn(settings.inDelay);
			else 
				$(containerIDhash).fadeOut(settings.Outdelay);
		});
};
})(jQuery);

    // To Top Button
    // -----------------------------------------------------------------------------
    $(function(){
        $().UItoTop({ easingType: 'easeOutQuart' });
    });

jQuery('.nav-collapse .nav > li > a').click(function(){
			
			jQuery('.collapse.in').removeClass('in').css('height', '0');

		});


jQuery(document).ready(function(){
	jQuery('#nav').localScroll(3000);
	jQuery('#main-nav select').localScroll(400);
	jQuery('.camein').localScroll(400);
	jQuery('.scrollto').localScroll(400);
	jQuery('.plans').localScroll(400);
})
//  COMMENT 


		
jQuery('#show1').bind('inview', function (event, visible) {
        if (visible == true) {
            jQuery(this).addClass("animated fadeInRightBig");
        }else{
            jQuery(this).removeClass("animated fadeInRightBig");
        }
    });

jQuery('#show2').bind('inview', function (event, visible) {
        if (visible == true) {
            jQuery(this).addClass("animated fadeInLeftBig");
        }else{
            jQuery(this).removeClass("animated fadeInLeftBig");
        }
    });
