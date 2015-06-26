// Slide menu
$(document).ready(function(){
  $('.toggle-menu').jPushMenu({closeOnClickLink: false});
  $('.dropdown-toggle').dropdown();
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

// Make ColorBox responsive
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

// Color Picker

function updateColors(color) {
    var col = "transparent";
    if(color) {
        col = color.toHexString();
    }
    if(color != $.cookie("vamshop-color")) {
    $.cookie("vamshop-color", color.toHexString(), { expires: 30, path: '/' })
    }
    $(".navbar-default").css("background", col);
    $(".navbar-default .navbar-collapse").css("border-color", col);
    $(".navbar-default .navbar-form").css("border-color", col);
    $(".btn-warning").css({"background": col,"border": "1px solid "+col});
    $(".btn-warning.checkout").css("background", col);
    $(".featured-categories .thumbnail .title").css("background", col);
    $(".shop-products .thumbnail .price").css("background", col);
}

$(function() {

var col = "transparent";
if(typeof $.cookie("vamshop-color") != "undefined"){
   col = $.cookie("vamshop-color");
}    
    $(".navbar-default").css("background", col);
    $(".navbar-default .navbar-collapse").css("border-color", col);
    $(".navbar-default .navbar-form").css("border-color", col);
    $(".btn-warning").css({"background": col,"border": "1px solid "+col});
    $(".btn-warning.checkout").css("background", col);
    $(".featured-categories .thumbnail .title").css("background", col);
    $(".shop-products .thumbnail .price").css("background", col);

    if (!col) { var col = "#ff6633";}
    
$("#color-picker").spectrum({
    allowEmpty:true,
    color: col,
    showInput: true,
    showButtons: false,
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    hideAfterPaletteSelect:true,
    clickoutFiresChange: true,
    showAlpha: true,
    preferredFormat: "hex",
    localStorageKey: "vamshop",
    move: function (color) {
        updateColors(color);
    },
    show: function () {
    },
    beforeShow: function () {
    },
    hide: function (color) {
        updateColors(color);
    },
    palette: [
        ["rgb(255, 102, 51)", "rgb(0, 129, 194)", "rgb(26, 177, 36)", "rgb(208, 22, 22)", "rgb(210, 193, 82)", "rgb(163, 163, 163)", "rgb(85, 85, 85)"]
    ]
});

});