<?php
$wrapper_attrs_tmp = [
    'class' => 'cs-button',
];
$template_file = 'default';

if( $settings['btn_style'] != '0' ) {
    $wrapper_attrs_tmp['class'] .= ' cs-button--'.$settings['btn_style'];
    $template_file = $settings['btn_style'];
}

if( !empty( $settings['btn_type'] ) ) {
    $wrapper_attrs_tmp['data-type'] = $settings['btn_type'];
}

if( !empty( $settings['link']['url'] ) ) {
    $this->add_link_attributes( 'wrapper', $settings['link'] );
}

if( $settings['btn_type'] === 'submit' &&  $settings['wpcf7_form_id'] != 0) {
    $wrapper_attrs_tmp['data-form-id'] = $settings['wpcf7_form_id'];
}

$box_gradient_class = !empty( $settings['btn_background_color_b'] ) || 
                    !empty( $settings['btn_background_image'] ) ||  
                    !empty( $settings['btn_background_hover_color_b'] ) || 
                    !empty( $settings['btn_background_hover_image'] ) ? ' box-gradient' : '';

$wrapper_attrs_tmp['class'] .= $box_gradient_class;

$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );


$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<a <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <?php 
        steelnova_get_template(
            'elementor/includes/widgets/button/templates/'.$template_file, 
            [
                'settings' => $settings
            ]
        ); 
    ?>
</a>