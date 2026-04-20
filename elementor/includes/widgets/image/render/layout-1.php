<?php
$wrapper_attrs_tmp = [
    'class' => 'image-wrapper',
];


$wrapper_attrs = array_merge( $wrapper_attrs_tmp, $wrapper_attrs );
$this->add_render_attribute( 'wrapper', $wrapper_attrs );
$link_attrs = $this->get_render_attribute_string( 'link' );
$wrapper_tag = !empty( $link_attrs ) ? 'a' : 'div';
$img_width = $settings['img_size']['width'] ?? null;
$img_height = $settings['img_size']['height'] ?? null;
?>

<<?php echo esc_attr( $wrapper_tag ); ?> <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
    <?php steelnova_print_image_by_size( $settings['img']['id'], $img_width, $img_height, [] ); ?>
</<?php echo esc_attr( $wrapper_tag ); ?>>