<?php
/**
 * Sidebar template file
 * 
 * @package SteelNova
 */
$sidebar = 'sidebar-' . get_post_type();
$sidebar_class = 'sidebar--' . get_post_type();
if ( class_exists( 'WooCommerce' ) && ( is_product_category() || is_shop() || is_product() ) ) {
    $sidebar = 'sidebar-shop';
}

$sidebar_template_id = steelnova()->get_theme_option('single_'.get_post_type().'_sidebar_template_id', 0);
?>
<aside id="sidebar" class="sidebar <?php echo esc_attr($sidebar); ?>">
    <?php 
    if( $sidebar_template_id !== 0 ) {
        steelnova_elementor_print_builder_content( $sidebar_template_id );
    }else {
        dynamic_sidebar( $sidebar );
    }
    ?>
</aside>
