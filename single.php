<?php
/**
 * The template for displaying all single posts
 *
 * @package Theme_Name
 */

get_header();
?>
<div class="default-page" role="main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>
</div>
<?php
get_footer();
