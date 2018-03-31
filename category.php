<?php get_header(); ?>
<main id="main" class="site-main">
<div id="category_title" class="title-div">
<h2><?php single_cat_title( '', true );?></h2>
</div>
<div id="random_gallery" class="thumb_gallery">
	<?php
	$paged = isset($_GET['paged']) ? $_GET['paged']  : 1;
	$latest_blog_posts = new WP_Query( array( 'posts_per_page' => 6, 'orderby' => 'date', 'cat' => get_cat_id(single_cat_title('',false)), 'paged' => $paged  ) );

	if ( $latest_blog_posts->have_posts() ) : while ( $latest_blog_posts->have_posts() ) : $latest_blog_posts->the_post(); ?>
	<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array(400,400) );
$url = $thumb['0'];?>
	<a href="<?php the_permalink(); ?>">
	<div id="gallery_cell_<?php echo get_the_ID(); ?>" class="gallery_cell" style="background: url(<?php echo $url ?>) 50% 50% no-repeat;">&nbsp;
	</div>
	</a>
	<?php
	endwhile; endif;
	?>
	<div id="pagination-links" class="pagination-links">
	<span id="older-photos" class="pagination-link">
	<?php
	next_posts_link('Older Photos', $latest_blog_posts->max_num_pages);
	?>
	</span>
	<span id="newer-photos" class="pagination-link">
	<?php
	previous_posts_link('Newer Photos');
	?>
	</span>
	</div>
</div>
</main>
<?php get_footer(); wp_reset_postdata(); ?>
