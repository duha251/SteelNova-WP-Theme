<?php
$wrapper_attrs_tmp = [
    'class' => 'steelnova-breadcrumb'
];

$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );

$this->add_render_attribute( 'wrapper', $wrapper_attrs );

$separator = '<svg xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 4 4" fill="none">
                <path d="M2 4C3.10457 4 4 3.10457 4 2C4 0.89543 3.10457 0 2 0C0.89543 0 0 0.89543 0 2C0 3.10457 0.89543 4 2 4Z" fill="white"/>
            </svg>';
if( $settings['separator_type'] == '0' ) {
    $separator = $settings['separator_char'];
}elseif( $settings['separator_type'] == '1' ) {
    $separator = steelnova_elementor_get_icon( $settings['separator_icon'] );
}
?>
<div <?php echo $this->get_render_attribute_string( 'wrapper', $wrapper_attrs ); ?>>
    <?php pxl_print_html( steelnova()->component->get_breadcrumb([
        'separator' => $separator
    ]) ); ?>
</div>