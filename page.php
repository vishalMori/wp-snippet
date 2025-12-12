<?php
/**
 * The template for displaying all pages
 *
 * This is the default page template in a WordPress theme.
 *
 * @package Theme_Name
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile; // End of the loop.
	?>
</main><!-- #primary -->

<?php
get_footer();
?>