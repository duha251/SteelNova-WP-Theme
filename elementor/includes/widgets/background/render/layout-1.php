<?php
$wrapper_attrs_tmp = [
    'class' => 'cs-background',
];
$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>
<div <?php pxl_print_html($this->get_render_attribute_string( 'wrapper' )); ?>></div>