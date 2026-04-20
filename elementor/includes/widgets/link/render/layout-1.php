<?php
$wrapper_attrs_tmp = [
    'class' => 'link',
];
$template_file = 'default';
if( !empty( $settings['link_style'] ) ) {
    $wrapper_attrs_tmp['class'] .= ' link--'.$settings['link_style'];
    $template_file = $settings['link_style'];
}

if( !empty( $settings['link_type'] ) ) {
    $wrapper_attrs_tmp['data-type'] = $settings['link_type'];
}

$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );

$this->add_link_attributes( 'wrapper', $settings['link'] );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<a <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <?php if( !empty( $settings['text'] ) ) : ?>
        <span class="link-text">
            <?php echo esc_html( $settings['text'] ); ?>
        </span>
    <?php endif; ?>

    <?php if( !empty( $settings['icon']['value'] ) ) : ?>
        <span class="link-icon">
            <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
        </span>
    <?php endif; ?>
</a>