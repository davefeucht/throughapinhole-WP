<?php get_header(); ?>

	<div id="primary" class="content-area">	
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			echo("<div id='page-content' class='page-content'>");
			echo("<h2>" . get_the_title() . "</h2>");
			the_content();
			echo("</div>");
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
