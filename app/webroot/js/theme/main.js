// Only apply the fixed stuff to desktop devices
// -----------------------------------------------------------------------------

$(function(){

    if ( ! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {

        // #navigation fixed
        if ($(window).width() > 767) {
            //
            var menu = $('#navigation'),
                pos = menu.offset();

            $(window).scroll(function(){
                if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('default')){
                    menu.fadeOut('fast', function(){
                        $(this).removeClass('default').addClass('fixed').fadeIn('fast');
                    });
                } else if($(this).scrollTop() <= pos.top && menu.hasClass('fixed')){
                    menu.fadeOut('fast', function(){
                        $(this).removeClass('fixed').addClass('default').fadeIn('fast');
                    });
                }
            });
        }
    }

});

// ON DOCUMENT READY
// -----------------------------------------------------------------------------
$(document).ready(function(){

    // footer widget hide/show on mobile devices
    // -----------------------------------------------------------------------------
    function doFooter (){
        if ($(window).width() > 767) {
            $('#footer .widget-inner').slideDown("slow").removeClass("do");
            $('#footer .widget-title').removeClass("do");
        } else {
            $('#footer .widget-inner').slideUp("fast").addClass("do");
            $('#footer .widget-title').addClass("do");
        }
    }
    $(window).resize(function(){ doFooter(); });
    $(window).load(function(){ doFooter(); });
    $('#footer .widget-title').click(function(){
        $(this).next('.widget-inner.do').toggle("slow");
    });

    // Shoping cart SHOW/HIDE
    // -----------------------------------------------------------------------------
    $('.shopping-cart .cart').hover(
        function(){
            $('.shopping-cart .cart-dropdown').show();
        },
        function (){
            $('.shopping-cart .cart-dropdown').hide();
        }
    );
    $('.shopping-cart .cart-dropdown').bind({
        mouseenter: function(){
            $(this).show();
        },
        mouseleave: function(){
            $(this).hide();
        }
    });

    $('ul.icons.check a').click(function(){

        if ($(this).closest('li').hasClass('on')) {
            $(this).closest('li').removeClass('on');
            return false;
        }

        else {
            $(this).closest('li').addClass('on');
            return false;
        }

    });

    // tooltip
    // -----------------------------------------------------------------------------
    $("a[rel^='tooltip']").tooltip();
    $("button[rel^='tooltip']").tooltip();

    // Main menu
    // -----------------------------------------------------------------------------
    (function() {
		var $menu = $('.navbar-inner ul.nav'),
			optionsList = '<option value="" selected>...</option>';
		$menu.find('li').each(function() {
			var $this   = $(this),
				$anchor = $this.children('a'),
				depth   = $this.parents('ul').length - 1,
				indent  = '';
			if( depth ) {
				while( depth > 0 ) {
					indent += ' - ';
					depth--;
				}
			}
			optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
		}).end().after('<div class="res-menu-wrap"><select class="res-menu">' + optionsList + '</select><div class="res-menu-title"></div></div>');

		$('.res-menu').on('change', function() {
			window.location = $(this).val();
		});
	})();
    
    // To Top Button
    // -----------------------------------------------------------------------------
    $(function(){
        $().UItoTop({ easingType: 'easeOutQuart' });
    });

    // Placeholder
    // -----------------------------------------------------------------------------
    $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
        }).blur().parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });

});
