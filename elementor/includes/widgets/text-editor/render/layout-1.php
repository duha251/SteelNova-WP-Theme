<?php
$wrapper_attrs = array_merge( 
    [
        'class' => 'text-editor',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
    <?php pxl_print_html( $settings['text'] ); ?>
</div>