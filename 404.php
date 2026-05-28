<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package SteelNova
 * @author Case-Themes
 * @link https://steelnova.casethemes.net
 * @since 1.0.0
 */
?>

<?php get_header(); 

$template_id = steelnova()->get_theme_option('404_template', '');
?>

<div id="main">
    <?php if( empty( $template_id ) ) : ?>
        <div class="container">
            <div class="inner">
                <h1 class="error404__title">
                    <?php esc_html_e( '404', 'steelnova' ); ?>
                </h1>
                <div class="error404__subtitle">
                    <?php esc_html_e( 'Oops! page not found', 'steelnova' ); ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <?php steelnova_elementor_print_builder_content( $template_id ); ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>