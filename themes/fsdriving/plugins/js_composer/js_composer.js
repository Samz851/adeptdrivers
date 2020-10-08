/* global jQuery:false */
/* global FSDRIVING_STORAGE:false */

(function() {
	"use strict";

    // Disable init VC prettyPhoto on the gallery images
    window.vc_prettyPhoto = function() {};

	jQuery(document).on('action.ready_fsdriving', fsdriving_js_composer_init);
	jQuery(document).on('action.init_shortcodes', fsdriving_js_composer_init);
	jQuery(document).on('action.init_hidden_elements', fsdriving_js_composer_init);
	
	function fsdriving_js_composer_init(e, container) {
		if (arguments.length < 2) var container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;
	
		container.find('.vc_message_box_closeable:not(.inited)').addClass('inited').on('click', function(e) {
			jQuery(this).fadeOut();
			e.preventDefault();
			return false;
		});
	}
})();