<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-icon-wrapper',
    ], 
    $wrapper_attrs
);

$has_link = !empty( $settings['link']['url'] );
$wrapper_tag = $has_link ? 'a ' : 'div ';
if ( $has_link ) {
    $this->add_link_attributes( 'wrapper', $settings['link'] );
}
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<<?php echo esc_attr( $wrapper_tag ); echo $this->get_render_attribute_string( 'wrapper', $wrapper_attrs ); ?>>
    <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
</<?php echo esc_attr( $wrapper_tag ); ?>>