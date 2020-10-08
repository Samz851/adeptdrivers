/* global jQuery:false */

jQuery(document).on('action.ready_trx_addons', function() {
	"use strict";
	
	// Init Superfish menu - global declaration to use in other scripts
	window.trx_addons_init_sfmenu = function(selector) {
		jQuery(selector).show().each(function() {
			var animation_in = jQuery(this).parent().data('animation-in');
			if (animation_in == undefined) animation_in = "none";
			var animation_out = jQuery(this).parent().data('animation-out');
			if (animation_out == undefined) animation_out = "none";
			jQuery(this).addClass('inited').superfish({
				delay: 500,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: 		animation_in!='none' ? 500 : 200,
				speedOut:	animation_out!='none' ? 500 : 200,
				autoArrows: false,
				dropShadows: false,
				onBeforeShow: function(ul) {
					if (jQuery(this).parents("ul").length > 1){
						var w = jQuery(window).width();  
						var par_offset = jQuery(this).parents("ul").offset().left;
						var par_width  = jQuery(this).parents("ul").outerWidth();
						var ul_width   = jQuery(this).outerWidth();
						if (par_offset+par_width+ul_width > w-20 && par_offset-ul_width > 0)
							jQuery(this).addClass('submenu_left');
						else
							jQuery(this).removeClass('submenu_left');
					}
					if (jQuery(this).parents('[class*="columns-"]').length == 0 && animation_in!='none') {
						jQuery(this).removeClass('animated fast '+animation_out);
						jQuery(this).addClass('animated fast '+animation_in);
					}
				},
				onBeforeHide: function(ul) {
					if (jQuery(this).parents('[class*="columns-"]').length == 0 && animation_out!='none') {
						jQuery(this).removeClass('animated fast '+animation_in);
						jQuery(this).addClass('animated fast '+animation_out);
					}
				}
			});
		});
	};

	// Init superfish menus
	trx_addons_init_sfmenu('.sc_layouts_menu > ul:not(.inited)');

	jQuery('.sc_layouts_menu').each(function() {
		if (jQuery(this).find('>ul.inited').length == 1) jQuery(this).addClass('menu_show');
	});

	// Slide effect for menu
	jQuery('.menu_hover_slide_line:not(.slide_inited),.menu_hover_slide_box:not(.slide_inited)').each(function() {
		var menu = jQuery(this).addClass('slide_inited');
		var style = menu.hasClass('menu_hover_slide_line') ? 'line' : 'box';
		setTimeout(function() {
			menu.find('>ul').spasticNav({
				style: style,
				//color: '',
				colorOverride: false
			});
		}, 500);
	});

	// Burger with popup
	jQuery('.sc_layouts_menu_mobile_button_burger:not(.inited)').each(function() {
		var burger = jQuery(this);
		var popup = burger.find('.sc_layouts_menu_popup');
		if (popup.length == 1) {
			burger.addClass('inited').on('click', '>a', function(e) {
				popup.toggleClass('opened').slideToggle();
				e.preventDefault();
				return false;
			});
			jQuery(document).on('click', function(e) {
				jQuery('.sc_layouts_menu_popup.opened').removeClass('opened').slideUp();
			});
		}
	});

});
