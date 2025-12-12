<?php
/**
 * Template part for displaying posts
 *
 * @package Theme_Name
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
