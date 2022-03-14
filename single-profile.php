<?php
/**
 * The template for displaying single profile posts
 *
 *
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	
?>
	<main id="site-content">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1 class="entry-title default-max-width">', '</h1>' ); ?>
		<?php else : ?>
			<?php the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">


<div id="inner-wrap" class="wrap hfeed kt-clear">
<div id="primary" class="content-area">
	<div class="content-container site-container">
		<main id="main" class="site-main" role="main">
						<div class="content-wrap">
				<article id="post-26" class="entry content-bg single-entry post-26 page type-page status-publish hentry">
	<div class="entry-content-wrap">
		
<div class="entry-content single-content">
<?php
		the_content();
		?>
</div>



</article><!-- #post-26 -->

			</div>
					</main><!-- #main -->
			</div>
</div><!-- #primary -->
	</div>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

</main><!-- #site-content -->

<?php

	echo "<div>TEST</div>";
	
endwhile; // End of the loop.

get_footer();
?>