jQuery(document).ready(function() {
	//prevent clicking on the links in the menu and sub-menus from following the link
	jQuery('body').delegate('#menu-item-41', 'click', function(event) {
		event.preventDefault();
	}).delegate('.sub-menu', 'click', function(event) {
		event.stopPropagation();
	});
	//on resize of the window...
	jQuery(window).resize(function() {
		//if this is a post, run the function to set the post image up
		if(jQuery("#post-image").length) {
			set_post_image_dimensions();
		}	
		//if this is the main page, run the function to set the main page image up
		if(jQuery("#random-image").length) {
			set_main_image_dimensions();
		}
	});
	//if this is the main page, run the function to query and refresh the main image
	if(window.location.href == "http://throughapinhole.com/") {
		large_image_refresh();
		//if the window width is over 1024px, change the display of the footer
		if(window.matchMedia("(min-width: 1024px)").matches) {
			jQuery('#colophon').css('position', 'absolute');
			jQuery('#colophon').css('bottom', '0');
			jQuery('#colophon').css('width', '100%');
			jQuery('#colophon').css('color', '#FFF');
			jQuery('#colophon').css('background-color', 'rgba(0,0,0,0.5)');
		}
	}
	//if we are on a post page, set up the post navigation and set up the post image
	if(jQuery("#post-image").length) {
		setup_post_navigation();	
		set_post_image_dimensions();
	}
	//if we are on the main page, set up the main image dimensions
	if(jQuery("#random-image").length) {
		set_main_image_dimensions();
	}
	//set up an event handler for clicking on the right post navigation arrow
	jQuery('#site').on('click', '#right-arrow', function(event) {
		//prevent following the link
		event.preventDefault();
		//load the next post image and update links and metadata
		next_post_image();
	});
	//set up an event handler for clicking on the left post navigation arrow
	jQuery('#site').on('click', '#left-arrow', function(event) {
		//prevent following the link
		event.preventDefault();
		//load the previous post image and update links and metadata
		previous_post_image();
	});
});
