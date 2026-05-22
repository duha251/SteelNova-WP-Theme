<?php
if ( empty( $settings['imgs'] ) ) {
    printf( '<div style="color:red;">Images not found.</div>' );
    return;
}

$wrapper_attrs = array_merge( 
    [
        'class' => 'icon-text',
    ], 
    $wrapper_attrs
);

$img_width = $settings['img_size']['width'] ?: null;
$img_height = $settings['img_size']['height'] ?: null;
?>

<div class="grid cs-image-gallery">
    <div class="grid__inner">
        <?php foreach( $settings['imgs'] as $i => $img ) : 
            $item_tag = 'span';
            $item_class = '';
            $link_attrs = '';
            if( $settings['action'] === 'link' ) {
                $item_tag = 'a';
                $item_class = 'cs-image-gallery__item--link';
                $link_attrs = steelnova_elementor_get_link_attributes([
                    'url' => $img['url'],
                    'target'    => '_blank',
                    'is_external' => '',
                    'nofollow' => ''
                ]);
            }elseif( $settings['action'] === 'lightbox' ) {
                $item_tag = 'a';
                $item_class = ' cs-image-gallery__item--lightbox';
                $link_attrs = steelnova_elementor_get_link_attributes([
                    'url' => $img['url'],
                    'is_external' => '',
                    'nofollow' => ''
                ]);
            }
        ?>
            <div class="grid__item">
                <<?php echo esc_attr($item_tag); ?> <?php pxl_print_html( $link_attrs ); ?> class="cs-image-gallery__item<?php echo esc_attr($item_class); ?>">
                    <?php steelnova_print_image_by_size( $img['id'], $img_width, $img_height, [
                        'class' => 'cs-image-gallery__image'
                    ]); ?>
                </<?php echo esc_attr($item_tag); ?>>
            </div>
        <?php endforeach; ?>
    </div>
</div>