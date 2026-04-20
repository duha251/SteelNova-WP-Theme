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
?>
<aside id="sidebar" class="sidebar <?php echo esc_attr($sidebar); ?>">
    <?php dynamic_sidebar( $sidebar ); ?>
</aside>
