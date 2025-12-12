<?php
/**
 * The template for displaying the Header
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    WordPress
 * @subpackage Theme_Name
 * @since      1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
	<meta name="theme-color" content="#fff">

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>
	<!-- html starts -->
