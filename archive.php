<?php
/**
 * The template for displaying archive pages
 *
 * @package Theme_Name
 */

get_header();
?>
<div class="default-page">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			the_title( '<h2>', '</h2>' );

			if ( has_post_thumbnail() ) :
				?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
				<?php
			endif;
			the_content();
		endwhile;
		?>
	<?php endif; ?>
</div>
<?php
get_footer();
