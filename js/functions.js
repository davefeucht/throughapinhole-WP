/*
	This file provides helper functions that do many of the complex tasks for the function of the user interface

*/

/* Gets the page url and then splits it a few times to find whether the parameter that was passed to the function exists in the URL parameters that were passed to the page, and return its value if there is one. */
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

/* Ajax request to WordPress to get a random post image, display it on the page, and then set a
recurring call to this function so that the image keeps refreshing. */
function large_image_refresh() {
	jQuery.ajax({
		type: 'POST',
		url: throughapinhole_js_functions.ajax_url,
		dataType: 'json',
		data: {
			action: 'throughapinhole-get-random-post'
		},
		success: function(response) {
			change_image_div(response);	
		}, 
		error: function(error, status, errortext) {
			return false;
		}
	});
	setTimeout(large_image_refresh, 10000);
}

/* Grabs the category id and post id from the hidden variables on the page, does an ajax call 
to get an array of all the posts in that category, then determines if the current post is
the first post in the category, only display the right arrow, if it is the last post, only
display the left arrow, and otherwise, display both arrows. */
function setup_post_navigation() {
	var cat_id = jQuery('#category-id').val();
	var post_id = jQuery('#post-id').val();
	jQuery.ajax({
		type: 'POST',
		url: throughapinhole_js_functions.ajax_url,
		dataType: 'json',
		data: {
			action: 'throughapinhole-get-category-posts',
			category: cat_id
		},
		success: function(response) {
			if(post_id == response[0]) {
				jQuery('#left-arrow-link').css('display', 'none');
				jQuery('#right-arrow-link').css('display', 'inline');
			}
			else if(post_id == response[(response.length - 1)]) {
				jQuery('#left-arrow-link').css('display', 'inline');
				jQuery('#right-arrow-link').css('display', 'none');
			}
			else {
				jQuery('#left-arrow-link').css('display', 'inline');
				jQuery('#right-arrow-link').css('display', 'inline');

			}
		},
		error: function(error, status, errortext) {
			return false;
		}
	});

}

/* Does an ajax call to get the previous post's image, then fades the main image out, replaces the
image with the previous image, fades it back in, then sets up the image links, title, and other
metadata based on data returned from the ajax query. */
function previous_post_image() {
	var post_id = jQuery('#post-id').val();
	jQuery.ajax({
		type: 'post',
		url: throughapinhole_js_functions.ajax_url,
		dataType: 'json',
		data: {
			action: 'throughapinhole-get-previous-post',
			post_id: post_id
		},
		success: function(response) {
			var url = "http://throughapinhole.com?p=" + response.id;
			window.history.pushState({"html": response.linkUrl, "pageTitle": response.title}, "", url);
			jQuery('.large-image').fadeOut(400, function() {
				jQuery('.large-image').css('background-image', "url('" + response.image_url + "')");
				jQuery('#random-image-link').attr('href', response.linkUrl);
				set_post_image_dimensions();
			});
			jQuery('.large-image').fadeIn(400);
			set_post_image_dimensions();
			jQuery('.title-div h2').html(response.title);
			var category_string = 'Return to ';
			if(response.categories.length > 1) {
				var j = response.categories.length;
				for(var i = 0; i < j; i++) {
					category_string += '<a href="?cat=' + response.categories[i].id + '">' + response.categories[i].name + '</a>';
					if(i < (j-1)) {
						category_string += ' | ';	
					}
				}
				jQuery('#post-category-link').html(category_string);
			}
			if(response.categories.length == 1) {
				category_string += '<a href="?cat=' + response.categories[0].id + '">' + response.categories[0].name + '</a>';
				jQuery('#post-category-link').html(category_string);
			}
			jQuery('#post-id').val(response.id);
			if(response.id == response.category_posts[0]) {
				jQuery('#left-arrow-link').css('display', 'none');
				jQuery('#right-arrow-link').css('display', 'inline');
			}
			else {
				jQuery('#left-arrow-link').css('display', 'inline');
				jQuery('#right-arrow-link').css('display', 'inline');
			}
		},
		error: function(error, status, errortext) {
			return false;
		}
	});	
}

/* Does an ajax call to get the next post's image, then fades the main image out, replaces the
image with the next image, fades it back in, then sets up the image links, title, and other
metadata based on data returned from the ajax query. */
function next_post_image() {
	var post_id = jQuery('#post-id').val();
	jQuery.ajax({
		type: 'post',
		url: throughapinhole_js_functions.ajax_url,
		dataType: 'json',
		data: {
			action: 'throughapinhole-get-next-post',
			post_id: post_id
		},
		success: function(response) {
			var url = "http://throughapinhole.com?p=" + response.id;
			window.history.pushState({"html": response.linkUrl, "pageTitle": response.title}, "", url);
			jQuery('.large-image').fadeOut(400, function() {
				jQuery('.large-image').css('background-image', "url('" + response.image_url + "')");
				jQuery('#random-image-link').attr('href', response.linkUrl);
				set_post_image_dimensions();
			});
			jQuery('.large-image').fadeIn(400);
			jQuery('.title-div h2').html(response.title);
			var category_string = 'Return to ';
			if(response.categories.length > 1) {
				var j = response.categories.length;
				for(var i = 0; i < j; i++) {
					category_string += '<a href="?cat=' + response.categories[i].id + '">' + response.categories[i].name + '</a>';
					if(i < (j-1)) {
						category_string += ' | ';	
					}
				}
				jQuery('#post-category-link').html(category_string);
			}
			if(response.categories.length == 1) {
				category_string += '<a href="?cat=' + response.categories[0].id + '">' + response.categories[0].name + '</a>';
				jQuery('#post-category-link').html(category_string);
			}
			jQuery('#post-id').val(response.id);
			if(response.id == response.category_posts[(response.category_posts.length - 1)]) {
				jQuery('#right-arrow-link').css('display', 'none');
				jQuery('#left-arrow-link').css('display', 'inline');
			}
			else {
				jQuery('#left-arrow-link').css('display', 'inline');
				jQuery('#right-arrow-link').css('display', 'inline');
			}
		},
		complete: function() {

		},
		error: function(error, status, errortext) {
			return false;
		}
	});	
}

/* Fades out image on index page, replaces the image and the link with data from the response
passed in, and then fades the image back in */
function change_image_div(response) {
	var url_string = "url('" + response.imageUrl + "')";
	jQuery('.large-image').fadeOut(800, function() {
		jQuery('.large-image').css('background-image', url_string);
		jQuery('#random-image-link').attr('href', response.linkUrl);
	});
	jQuery('.large-image').fadeIn(800);
}

/* Sets dimensions of the main index page image depending on the window size and whether the window
is in portrait or landscape */
function set_main_image_dimensions() {
	var window_height = jQuery(window).height();
	var window_width = jQuery(window).width();
	if(window.matchMedia("(max-width: 710px)").matches) {
		if(window_height > window_width) {
			jQuery(".large-image").css('height', window_height - 70 );
		}
		else {
			jQuery(".large-image").css('height', window_height ); 
		}
	}
	else {
		jQuery(".large-image").css('height', window_height - 75);
	}
}

/* Sets dimensions of the post image depending on the window size and whether the screen is in
portrait or landscape */
function set_post_image_dimensions() {
	var window_height = jQuery(window).height(),
	window_width = jQuery(window).width(), image_height, image_width;
	var temp_image = new Image();
	temp_image.src = jQuery('.large-image').css('background-image').replace('url(', '').replace(')', '').replace('\'', '').replace(/"/g, '');
	jQuery(temp_image).load(function() {
		image_width = temp_image.width;
		image_height = temp_image.height;
		ratio = image_width / image_height;
		if(window.matchMedia("(max-width: 710px)").matches) {
			if(window_height > window_width) {
				jQuery(".large-image").css('height', window_height - 200 );
			}
			else {
				jQuery(".large-image").css('height', window_width/ratio); 
			}
		}
		else {
			jQuery(".large-image").css('height', window_width/ratio);
		}
	});
}
