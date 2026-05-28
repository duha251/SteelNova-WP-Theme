<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$wrapper_attrs = array_merge( 
    [
        'class' => 'icon-text',
    ], 
    $wrapper_attrs
);

?>

<div class="cs-social-icons">
    <?php foreach ( $settings['items'] as $i => $social ) : ?>
        <?php
            $item_key = 'item-' . $i;
            $item_attrs = [
                'class' => 'cs-social-icons__link elementor-repeater-item-'.$social['_id']
            ];
            if( !empty( $settings['icon_hover_style'] ) ) {
                $item_attrs['data-hover'] = $settings['icon_hover_style'];
            }
            $this->add_render_attribute( $item_key, $item_attrs);
            if ( ! empty( $social['link']['url'] ) ) {
                $this->add_link_attributes( $item_key, $social['link'] );
            }
        ?>
        <a <?php pxl_print_html( $this->get_render_attribute_string( $item_key ) ); ?>>
            <?php steelnova_elementor_print_icon( $social['icon'] ); ?>
        </a>
    <?php endforeach; ?>
</div>