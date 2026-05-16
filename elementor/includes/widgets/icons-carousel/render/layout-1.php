<?php 

if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$swiper_settings = steelnova_get_carousel_settings( $settings, [
    'breakpoints' => [
        'xs' => [
            'slidesPerView' => $settings['slides_per_view_xs'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xs'] ?: 1,
            'spaceBetween' => $settings['space_between_xs']['column'] ?: 30
        ],
        'sm' => [
            'slidesPerView' => $settings['slides_per_view_sm'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_sm'] ?: 1,
            'spaceBetween' => $settings['space_between_sm']['column'] ?: 30
        ],
        'md' => [
            'slidesPerView' => $settings['slides_per_view_md'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 30
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 30
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 30
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 30
        ],
    ]
]);

if( $settings['swiper_boxshadow'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' carousel--box-shadow';
}


?>

<div class="cs-icons-carousel">
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $settings['items'] as $i => $item ) : 
                $tag = 'div';
                if( !empty( $item['link']['url'] ) ) {
                    $tag = 'a';
                }
            ?>
                <div class="carousel__item swiper-slide">
                    <<?php echo esc_attr( $tag ); ?> class="cs-icon-wrapper d-inline-flex-center" <?php steelnova_elementor_print_link_attributes( $item['link'] ); ?>>
                        <?php steelnova_elementor_print_icon( $item['icon'] ); ?>
                    </<?php echo esc_attr( $tag ); ?>>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>
