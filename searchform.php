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
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

extract( $args );

$template_file = ( ( $template ?? 'default' ) ?: 'default' );

steelnova_get_template( 'template-parts/searchform/'.$template_file, [
    'placeholder' => $placeholder ?? '',
    'btn_text' => $btn_text ?? '',
    'btn_icon' => $btn_icon ?? '',
]);
?>