<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 * Name displayed in copyright is the Display Name of the author of the page
 * being used as the static 'Front' page. This is filled out in your user
 * profile in WordPress.
 *
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
	<div id="copyright" class="footer-copyright-div">
	All Photographs &copy;<?php echo get_the_author_meta('display_name', get_post_field('post_author', get_option('page_on_front'))); ?>. All Rights Reserved.
	</div>
	<div id="social-icons" class="footer-social-div">
	<a id="flickr-icon" href="http://www.flickr.com/photos/poetas/" target="_blank" title="See my photos on Flickr!"><img src="https://s.yimg.com/pw/images/goodies/white-small-circle.png"></a>
	<a id="tumblr-icon" href="http://pin-hole.tumblr.com/" target="_blank"><img src="https://secure.assets.tumblr.com/images/logo_page/img_logo_bluebg_2x.png"></a>
	</div>
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
