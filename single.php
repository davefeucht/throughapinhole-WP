<?php get_header(); ?>
	<main id="main" class="site-main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
			
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array(800,800) );
			$url = trim($thumb['0']); 
			$categories = get_the_category();
			?>
			<div id="post-content" class="post-content">
			<input type="hidden" id="post-id" value="<?php echo get_the_ID(); ?>">
			<input type="hidden" id="category-id" value="<?php echo $categories[0]->term_id; ?>">
			<div id="post-image" class="large-image" style="background-image: url('<?php echo $url; ?>')"><a id="left-arrow-link" class="post-nav-arrow-link"><span id="left-arrow" class="post-nav-arrow"></span></a><a id="right-arrow-link" class="post-nav-arrow-link"><span id="right-arrow" class="post-nav-arrow"></span></a></div>
			</div>
<div id="post_title" class="title-div">
<h2><?php single_post_title( '', true );?></h2>
<div id="post-category-link" class="post-category-link">Return to 
<?php
$num_categories = count($categories);
for($i = 0; $i < $num_categories; $i++) {
	$url = site_url("/?cat=") . $categories[$i]->term_id;
	echo("<a href='" . $url . "'>");
	echo $categories[$i]->name;
	echo('</a> ');
	if($num_categories > 1 && $i < ($num_categories - 1)) {
		echo(' | ');
	}
}
?></div>

</div>
			<?php
			


			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			// Previous/next post navigation.
			/*
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );
			*/
		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->

<?php get_footer(); ?>
