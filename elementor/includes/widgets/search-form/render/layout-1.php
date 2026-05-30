<?php
$wrapper_attrs_tmp = [
    'class' => 'cs-search-form',
];
$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>
<div <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    <?php steelnova()->component->get_search_form( 'default', [
        'placeholder' => $settings['placeholder'],
        'btn_text' => $settings['btn_text'],
        'btn_icon' => steelnova_elementor_get_icon( $settings['btn_icon'] ),
        'post_type' => $settings['post_type'],
    ] ); ?>
</div>