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

// Color box for product images
$(document).ready(function(){
  $(".colorbox").colorbox({rel: "colorbox"});
  $(".ask").colorbox({});
  $(".buy").colorbox({});
});

// Anti-spam for forms
$(document).ready(function(){
$(function($){

    $('.form-anti-bot, .form-anti-bot-2').hide(); // hide inputs from users
    var answer = $('.form-anti-bot input#anti-bot-a').val(); // get answer
    $('.form-anti-bot input#anti-bot-q').val( answer ); // set answer into other input

    if ( $('form input#anti-bot-q').length == 0 ) {
        var current_date = new Date();
        var current_year = current_date.getFullYear();
        $('form').append('<input type="hidden" name="anti-bot-q" id="anti-bot-q" value="'+current_year+'" />'); // add whole input with answer via javascript to form
    }

});
});

// Focus input
$(document).ready(function(){
$(function () {
  $(window).load(function () {
    $('#contentform :input:text:visible:enabled:first').focus();
  });
})
});