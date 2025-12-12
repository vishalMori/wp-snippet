<?php
/**
 * The template for displaying the single post
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    WordPress
 * @subpackage Theme_Name
 * @since      1.0
 */

get_header();
?>
<div class="default-page">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	<?php endif; ?>
</div>
<?php
get_footer();

