<?php 
// Title 
?>

<<?php echo esc_attr( $settings['title_tag'] ); ?> class="hero-title">
    <?php pxl_print_html( steelnova()->component->get_hero_title() ); ?>
</<?php echo esc_attr( $settings['title_tag'] ); ?>>
