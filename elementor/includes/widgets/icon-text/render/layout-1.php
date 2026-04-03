<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'icon-text',
    ], 
    $wrapper_attrs
);

if( $settings['layout_style'] != '0' ) {
    $wrapper_attrs['data-layout_style'] = $settings['layout_style'];
}

$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$link_attrs = steelnove_get_elementor_link_attributes( $settings['link'] );
$wrapper_tag = empty( $link_attrs ) ? 'div ' : 'a ';
?>

<<?php echo esc_attr( $wrapper_tag ); 
    pxl_print_html( $link_attrs );
    echo $this->get_render_attribute_string( 'wrapper', $wrapper_attrs ); ?>>
    <?php if( !empty( $settings['icon'] ) ): ?>
        <div class="icon-text__icon box-icon">
            <?php steelnova_print_elementor_icon( $settings['icon'] ); ?>
        </div>
    <?php endif; ?>
    <div class="icon-text__text">
        <?php echo esc_html( $settings['text'] ); ?>
    </div>
</<?php echo esc_attr( $wrapper_tag ); ?>>