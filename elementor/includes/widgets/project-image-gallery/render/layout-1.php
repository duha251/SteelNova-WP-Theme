<?php
$post_id = get_the_ID();
$gallery_image = get_post_meta( $post_id, 'project_gallery', true );

if( !empty( $gallery_image ) ) {
    $gallery_image = explode(',', $gallery_image);
}elseif( is_singular('pxl-template') ) {
    $gallery_image = [0, 0 ,0];
}else {
    $gallery_image = [];
}

$image_id = get_post_thumbnail_id($post_id);
if ( $image_id ) {
    array_unshift($gallery_image, $image_id);
}
$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;

$swiper_settings = steelnova_get_carousel_settings( $settings, [
    'breakpoints' => [
        'xs' => [
            'slidesPerView' => $settings['slides_per_view_xs'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xs'] ?: 1,
            'spaceBetween' => $settings['space_between_xs']['column'] ?: 0
        ],
        'sm' => [
            'slidesPerView' => $settings['slides_per_view_sm'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_sm'] ?: 1,
            'spaceBetween' => $settings['space_between_sm']['column'] ?: 0
        ],
        'md' => [
            'slidesPerView' => $settings['slides_per_view_md'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 0
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 0
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 0
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 0
        ],
    ]
]);

if( $settings['swiper_boxshadow'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' carousel--box-shadow';
}

?>
<div class="carousel cs-project-image-garelly">
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $gallery_image as $gallery ) : ?>
                <div class="carousel__item swiper-slide">
                    <?php steelnova_print_image_by_size( $gallery, $img_w, $img_h, [] ); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>
