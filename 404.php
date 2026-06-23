<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Theme_Name
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="error-404 not-found">
		<h1><?php esc_html_e( 'Oops! That page can’t be found.', 'theme-textdomain' ); ?></h1>
		<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'theme-textdomain' ); ?></p>
	</section>
</main>

<?php
get_footer();
