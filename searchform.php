<?php
/**
 * Search Form Template
 * 
 * This file renders the search form for the SteelNova theme.
 * It provides a customizable search interface for WordPress sites
 * using the SteelNova theme.
 * 
 * @package SteelNova
 * @subpackage Templates
 * @since 1.0.0
 * @version 1.0.0
 */
$template_file = ( $args['template'] ?? 'default' );
$template_path = "template-parts/searchform/{$template_file}";
if ( locate_template( $template_path.'.php' ) ) {
    steelnova_get_template( $template_path, [] );
} 
?>