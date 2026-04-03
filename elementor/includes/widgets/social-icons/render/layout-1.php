<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}
?>

<div class="socials-icon">
    <?php foreach ( $settings['items'] as $i => $social ) : ?>
        <?php
        $item_key = 'item-' . $i;
        $this->add_render_attribute( $item_key, 'class', 'social-icon__link' );
        if ( ! empty( $social['link']['url'] ) ) {
            $this->add_link_attributes( $item_key, $social['link'] );
        }
        ?>
        <a <?php echo $this->get_render_attribute_string( $item_key ); ?>>
            <?php steelnova_print_elementor_icon( $social['icon'] ); ?>
        </a>
    <?php endforeach; ?>
</div>