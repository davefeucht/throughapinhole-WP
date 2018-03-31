<?php

//setup all the jQuery/javascript stuff
function throughapinhole_enqueue_scripts() {
    	wp_register_script('functions', get_stylesheet_directory_uri(). '/js/functions.js', array( 'jquery' ), null );
	wp_register_script('site', get_stylesheet_directory_uri(). '/js/site.js', array( 'functions' ), null);
	wp_enqueue_script('site');
    	wp_localize_script( 'functions', 'throughapinhole_js_functions', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));
}
add_action( 'wp_enqueue_scripts', 'throughapinhole_enqueue_scripts' );

//function to get the image and link for a random post
function throughapinhole_get_random_post() {
	$latest_blog_posts = new WP_Query( array( 'posts_per_page' => 1, 'orderby' => 'rand' ) );
	$latest_blog_posts->the_post();
	$link_url = get_permalink();
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array(1200,1200) );
	$image_url = $thumb['0'];
	$response_data = array('linkUrl' => $link_url, 'imageUrl' => $image_url);
	echo json_encode($response_data);
	die();
}
add_action( 'wp_ajax_nopriv_throughapinhole-get-random-post', 'throughapinhole_get_random_post' );
add_action( 'wp_ajax_throughapinhole-get-random-post', 'throughapinhole_get_random_post' );

//function to get all the related information about the previous post in the category
function throughapinhole_get_previous_post() {
	global $post;
	$oldglobal = $post;
	//set the global $post variable so get_next_post knows what post to get
	$post = get_post($_POST['post_id']);
	$next_post = get_next_post(true);
	$post = $oldGlobal;
	//get the featured image, category, and all the posts in the category of the next post
	$post_image = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'single-post-thumbnail');
	$post_categories = wp_get_post_categories($next_post->ID);
	$cat_posts = get_posts(array('category' => $post_categories[0], 'posts_per_page' => -1));
	$num_cat_posts = sizeof($cat_posts);
	//loop through the posts in the category and store the IDs in an array
	$cat_post_ids = array();
	for($i = 0; $i < $num_cat_posts; $i++) {
		$cat_post_ids[$i] = $cat_posts[$i]->ID;	
	}
	//get the id, name and slug of the category the next post is in
	$numCats = sizeof($post_categories);
	for($i = 0; $i < $numCats; $i++) {
		$cat = get_category($post_categories[$i]);
		$cats[$i] = array('id' => $cat->term_id, 'name' => $cat->name, 'slug' => $cat->slug);
	}
	//put all the relevant data into an array, encode it as JSON, and pass it back to the caller
	$post_data = array('id' => $next_post->ID, 'title' => apply_filters('the_title', $next_post->post_title), 'image_url' => $post_image[0], 'categories' => $cats, 'category_posts' => $cat_post_ids);
	echo json_encode($post_data);
	die();
}
add_action( 'wp_ajax_nopriv_throughapinhole-get-previous-post', 'throughapinhole_get_previous_post' );
add_action( 'wp_ajax_throughapinhole-get-previous-post', 'throughapinhole_get_previous_post' );

//function to get all the related information about the next post in the category
function throughapinhole_get_next_post() {
	global $post;
	$oldglobal = $post;
	//set the global $post variable so get_previous_post knows what post to get
	$post = get_post($_POST['post_id']);
	$next_post = get_previous_post(true);
	$post = $oldGlobal;
	//get the featured image, category, and all the posts in the category of the previous post
	$post_image = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'single-post-thumbnail');
	$post_categories = wp_get_post_categories($next_post->ID);
	$cat_posts = get_posts(array('category' => $post_categories[0], 'posts_per_page' => -1));
	$num_cat_posts = sizeof($cat_posts);
	//loop through the posts in the category and store the IDs in an array
	$cat_post_ids = array();
	for($i = 0; $i < $num_cat_posts; $i++) {
		$cat_post_ids[$i] = $cat_posts[$i]->ID;	
	}
	//get the id, name and slug of the category the previous post is in
	$numCats = sizeof($post_categories);
	for($i = 0; $i < $numCats; $i++) {
		$cat = get_category($post_categories[$i]);
		$cats[$i] = array('id' => $cat->term_id, 'name' => $cat->name, 'slug' => $cat->slug);
	}
	//put all the relevant data into an array, encode it as JSON, and pass it back to the caller
	$post_data = array('id' => $next_post->ID, 'title' => apply_filters('the_title', $next_post->post_title), 'image_url' => $post_image[0], 'categories' => $cats, 'category_posts' => $cat_post_ids);
	echo json_encode($post_data);
	die();
}
add_action( 'wp_ajax_nopriv_throughapinhole-get-next-post', 'throughapinhole_get_next_post' );
add_action( 'wp_ajax_throughapinhole-get-next-post', 'throughapinhole_get_next_post' );

//function to get all the post ids of posts in a particular category
function throughapinhole_get_category_posts() {
	$category = ($_POST['category']);
	$cat_posts = get_posts(array('category' => $category, 'posts_per_page' => -1));
	$num_cat_posts = sizeof($cat_posts);
	$cat_post_ids = array();
	for($i = 0; $i < $num_cat_posts; $i++) {
		$cat_post_ids[$i] = $cat_posts[$i]->ID;	
	}
	echo json_encode($cat_post_ids);
	die();
}
add_action( 'wp_ajax_nopriv_throughapinhole-get-category-posts', 'throughapinhole_get_category_posts' );
add_action( 'wp_ajax_throughapinhole-get-category-posts', 'throughapinhole_get_category_posts' );

//setup menus and post thumbnails in the theme
function throughapinhole_custom_theme_setup() {
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'throughapinhole_custom_theme_setup' );

//register the main nav menu in the header
function throughapinhole_register_my_menu() {
	register_nav_menu('header-nav-menu',__( 'Header Nav Menu' ));
}
add_action( 'init', 'throughapinhole_register_my_menu' );
?>
