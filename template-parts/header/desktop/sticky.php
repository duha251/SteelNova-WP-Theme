<?php
/**
 * Template part for displaying header builder by Elementor.
 *
 * @package SteelNova
 */
// HTML

if($layout_id <= 0) {
    return '';
}
?>
<header id="headerSticky" class="header header-sticky" data-layout="builder" data-scroll="<?php echo esc_attr( $direction ); ?>">
    <?php steelnova_elementor_print_builder_content( $layout_id ); ?>
</header>