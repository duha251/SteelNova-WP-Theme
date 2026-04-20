<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'icon-text',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$link_attrs = steelnova_elementor_get_link_attributes( $settings['link'] );
$wrapper_tag = empty( $link_attrs ) ? 'div ' : 'a ';
?>

<<?php echo esc_attr( $wrapper_tag ); 
    pxl_print_html( $link_attrs );
    echo $this->get_render_attribute_string( 'wrapper', $wrapper_attrs ); ?>>
    <?php if( !empty( $settings['icon'] ) ): ?>
        <div class="icon-text__icon boicon-x">
            <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
        </div>
    <?php endif; ?>
    <div class="icon-text__text">
        <?php echo esc_html( $settings['text'] ); ?>
    </div>
</<?php echo esc_attr( $wrapper_tag ); ?>>