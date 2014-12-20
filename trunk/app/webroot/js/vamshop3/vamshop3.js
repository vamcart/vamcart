// Slide menu
$(document).ready(function(){
  $('.toggle-menu').jPushMenu({closeOnClickLink: false});
  $('.dropdown-toggle').dropdown();
});

// Google material design theme init
$(document).ready(function() {
    $.material.init();
});

// Scroll to top button 
$(function(){
 
	$(document).on( 'scroll', function(){
 
		if ($(window).scrollTop() > 100) {
			$('.scroll-top-wrapper').addClass('show');
		} else {
			$('.scroll-top-wrapper').removeClass('show');
		}
	});
 
	$('.scroll-top-wrapper').on('click', scrollToTop);
});
 
function scrollToTop() {
	verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
	element = $('body');
	offset = element.offset();
	offsetTop = offset.top;
	$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}

// Fixed nav
$('#nav').affix({
      offset: {
        top: $('header').height()
      }
});
