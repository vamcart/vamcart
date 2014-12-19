//<![CDATA[
$(document).ready(function(){
  $('.toggle-menu').jPushMenu({closeOnClickLink: false});
  $('.dropdown-toggle').dropdown();
});
//]]>
$(document).ready(function() {
    $.material.init();
});

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

$('#nav').affix({
      offset: {
        top: $('header').height()
      }
});
