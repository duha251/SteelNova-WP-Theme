<?php
$wrapper_attrs_tmp = [
    'class' => 'icon-box'
];
$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$has_link = false;
if( !empty( $settings['link']['url'] ) ) {
    $has_link = true;
    $this->add_link_attributes( 'wrapper', $settings['link'] );
} 
$wrapper_tag = $has_link ? 'a ' : 'div';
if( $settings['layout_style'] != '1' ) {
    $wrapper_attrs['data-layout_style'] = $settings['layout_style'];
}
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<<?php echo esc_attr( $wrapper_tag ); ?> <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <div class="icon-box__icon">
        <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
    </div>
    <div class="icon-box__content">
        <<?php echo esc_attr( $settings['title_tag'] ); ?> class="icon-box__title">
            <?php echo esc_html( $settings['title'] ); ?>
        </<?php echo esc_attr( $settings['title_tag'] ); ?>>
        <p class="icon-box__description">
            <?php pxl_print_html( $settings['description'] ); ?>
        </p>
    </div>
</<?php echo esc_attr( $wrapper_tag ); ?>>