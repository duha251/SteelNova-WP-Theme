<?php
/**
 * Theme functions and definitions
 *
 * Sets up the theme and provides some helper functions
 *
 * @package SteelNova
 * @author Case-Themes
 * @link https://steelnova.casethemes.net
 * @since 1.0.0
 */

require_once get_template_directory() . '/inc/steelnova.php';

if ( is_admin() ){ 
	require_once get_template_directory() . '/inc/admin/admin-init.php'; 
}