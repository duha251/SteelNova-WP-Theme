<?php
$wrapper_attrs_tmp = [
    'class' => 'site-logo'
];

$this->add_link_attributes( 'wrapper', $settings['link'] );

$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );

$this->add_render_attribute( 'wrapper', $wrapper_attrs );
?>

<a <?php echo $this->get_render_attribute_string( 'wrapper', $wrapper_attrs ); ?>>
    <?php steelnova_print_image_by_size( $settings['image']['id'], null, null, ['class' => 'site-logo__image']); ?>
</a>