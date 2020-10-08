/* global jQuery:false */
/* global FSDRIVING_STORAGE:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {
	"use strict";
	
	jQuery(document).on('action.add_googlemap_styles', fsdriving_trx_addons_add_googlemap_styles);
	jQuery(document).on('action.init_shortcodes', fsdriving_trx_addons_init);
	jQuery(document).on('action.init_hidden_elements', fsdriving_trx_addons_init);
	
	// Add theme specific styles to the Google map
	function fsdriving_trx_addons_add_googlemap_styles(e) {
		TRX_ADDONS_STORAGE['googlemap_styles']['dark'] = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46a2ec"},{"visibility":"on"}]}];
	}
	
	
	function fsdriving_trx_addons_init(e, container) {
		if (arguments.length < 2) var container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;
		container.find('.sc_countdown_item canvas:not(.inited)').addClass('inited').attr('data-color', FSDRIVING_STORAGE['alter_link_color']);
	}

})();