<?php
if( !class_exists('WPCF7') || $settings['wpcf7_form_id'] == '0' ) {
    printf( '<div style="color:red;">Form not found.</div>' );
    return;
}
add_filter('wpcf7_autop_or_not', '__return_false'); 


$wrapper_attrs_tmp = [
    'class' => 'cs-wpcf7',
];
$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>
<div <?php echo esc_attr( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php pxl_print_shortcode('[contact-form-7 id="'.esc_attr($settings['wpcf7_form_id']).'" html_class="'.esc_attr('grid wpcf7-form wpcf7-form-'.$settings['wpcf7_form_id']).'"]'); ?>
</div>
