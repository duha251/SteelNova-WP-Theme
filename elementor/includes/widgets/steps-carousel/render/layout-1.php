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
            'spaceBetween' => $settings['space_between_xs']['column'] ?: 20
        ],
        'sm' => [
            'slidesPerView' => $settings['slides_per_view_sm'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_sm'] ?: 1,
            'spaceBetween' => $settings['space_between_sm']['column'] ?: 20
        ],
        'md' => [
            'slidesPerView' => $settings['slides_per_view_md'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 20
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 20
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 21
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 21
        ],
    ]
]);

if( $settings['swiper_boxshadow'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' carousel--box-shadow';
}


?>

<div class="cs-steps-carousel">
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $settings['items'] as $i => $item ) : ?>
                <div class="carousel__item swiper-slide">
                    <div class="cs-step">
                        <div class="cs-step__header">
                            <div class="cs-step__index">
                                <?php echo esc_html( $i < 9 ? '0'.( $i + 1 ) : ( $i + 1 ) ); ?>
                            </div>
                            <?php if( !empty( $settings['icon']['value'] ) ) : ?>
                                <div class="cs-step__icon d-inline-flex-center">
                                    <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="cs-step__content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?> class="cs-step__title">
                                <?php echo esc_html( $item['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p class="cs-step__description">
                                <?php echo esc_html( $item['description'] ); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>
