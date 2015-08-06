// Slide menu
$(document).ready(function(){
  $('.toggle-menu').jPushMenu({closeOnClickLink: false});
  $('.dropdown-toggle').dropdown();
});

// Scroll to top button 
$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollup', // Element ID
	        scrollDistance: 200, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 500, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 500, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-chevron-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

// Ajax cart

  function onProductFormSubmit(id, quantity) {
    var str = $("#product-form"+id).serialize();
    var action = $("#product-form"+id).attr("action");

    $.post(action, str, function(data) {
      $("#shopping-cart-box").html(data);
      //$("html, body").animate({ scrollTop: 0 }, "slow");
      //$(".shopping-cart-widget").addClass("ajax-cart-hightlight");
      $("nav .dropdown-toggle.cart").dropdown("toggle");
      $("nav .navbar-toggle").click();
      $("nav .navbar-toggle").focus();
    });
  }

// Sequence slider

$(document).ready(function(){
    var options = {
        nextButton: true,
        prevButton: true,
        animateStartingFrameIn: true,
        autoPlay: true,
        autoPlayDelay: 4000,
    };
    
    var mySequence = $("#sequence").sequence(options).data("sequence");
});

// Responsive equal height
// http://codepen.io/micahgodbolt/pen/FgqLc

$(document).ready(function(){

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

if ($(window).width() > 767) {
$(window).load(function() {
  equalheight('.featured-categories .thumbnails .thumbnail');
  equalheight('.shop-products .thumbnails .thumbnail');
});

$(window).resize(function(){
  equalheight('.featured-categories .thumbnails .thumbnail');
  equalheight('.shop-products .thumbnails .thumbnail');
});
}

});


// Make ColorBox responsive

$(document).ready(function(){

	jQuery.colorbox.settings.maxWidth  = '95%';
	jQuery.colorbox.settings.maxHeight = '95%';

	// ColorBox resize function
	var resizeTimer;
	function resizeColorBox()
	{
		if (resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
				if (jQuery('#cboxOverlay').is(':visible')) {
						jQuery.colorbox.load(true);
				}
		}, 300);
	}

	// Resize ColorBox when resizing window or changing mobile device orientation
	jQuery(window).resize(resizeColorBox);

});
