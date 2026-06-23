<?php
/**
 * The template for displaying all pages
 *
 * @package Theme_Name
 */

get_header();
?>
<main>
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>
</main>
<?php
get_footer();
