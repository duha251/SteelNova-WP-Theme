<?php
if ( empty( $settings['content_items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$wrapper_attrs_tmp = [
    'class' => 'cs-testimonial-carousel',
    'data-layout' => '3'
];

if( $settings['swiper_boxshadow'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' carousel--box-shadow';
}


$this->add_render_attribute( 'wrapper', $wrapper_attrs_tmp );

$ratings = $settings['rating_items'] ?? [];
$authors = $settings['author_items'] ?? [];
$own_icons = $settings['icon_items'] ?? [];

$swiper_settings = steelnova_get_carousel_settings( $settings, [
    'breakpoints' => [
        'xs' => [
            'slidesPerView' => $settings['slides_per_view_xs'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xs'] ?: 1,
            'spaceBetween' => $settings['space_between_xs']['column'] ?: 30
        ],
        'sm' => [
            'slidesPerView' => $settings['slides_per_view_sm'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_sm'] ?: 1,
            'spaceBetween' => $settings['space_between_sm']['column'] ?: 30
        ],
        'md' => [
            'slidesPerView' => $settings['slides_per_view_md'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 30
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 30
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 38
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 38
        ],
    ]
]);
?>

<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $settings['content_items'] as $i => $content ) : 
                $content  = $content['content'] ?? '';
                $rating   = $ratings[$i]['rating'] ?? '';
                $author_name  = $authors[$i]['author_name'] ?? '';
                $author_title = $authors[$i]['author_title'] ?? '';
                $icon     = $own_icons[$i]['icon'] ?? $settings['icon'];
            ?>
                <div class="carousel__item swiper-slide">
                    <div class="cs-testimonial">
                        <?php if( !empty( $icon['value'] ) ) : ?>
                            <div class="cs-testimonial__icon d-inline-flex-center">
                                <?php steelnova_elementor_print_icon( $icon ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="cs-testimonial__rating">
                            <?php if( !empty( $settings['rating_label'] ) ) : ?>
                                <div class="cs-testimonial__rating-label">
                                    <?php echo esc_html( $settings['rating_label'] ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $rating )) : ?>
                                <div class="cs-stars">
                                    <?php for($i=1; $i<=5; $i++) : 
                                        $star_icon_class = $rating <= $i ? 'fill' : 'normal';
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M6.30627 0.480684C6.51427 -0.160228 7.42067 -0.160228 7.62947 0.480684L8.79667 4.07525C8.89027 4.36188 9.15747 4.55593 9.45827 4.55593H13.2383C13.9119 4.55593 14.1927 5.41828 13.6471 5.81438L10.5895 8.03592C10.3455 8.21312 10.2439 8.52712 10.3367 8.81368L11.5047 12.4082C11.7127 13.0492 10.9791 13.5822 10.4343 13.186L7.37667 10.9645C7.13267 10.7874 6.80227 10.7874 6.55827 10.9645L3.50067 13.186C2.95587 13.5822 2.22227 13.0492 2.43027 12.4082L3.59827 8.81368C3.69107 8.52712 3.58947 8.21312 3.34547 8.03592L0.287872 5.81438C-0.256928 5.41828 0.023073 4.55593 0.696673 4.55593H4.47667C4.77747 4.55593 5.04467 4.36188 5.13827 4.07525L6.30627 0.480684Z" fill="#FF5B1B"/>
                                    </svg>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="cs-testimonial__content">
                            <?php echo esc_html( $content ); ?>
                        </p>
                        <div class="divider"></div>
                        <div class="cs-testimonial__author">
                            <?php if( !empty( $author_image['id'] ) ) : ?>
                                <?php steelnova_print_image_by_size($author_image['id'], null, null, ['class' => 'cs-testimonial__author-image']); ?>
                            <?php endif; ?>
                            <div class="cs-testimonial__author-content">
                                <div class="cs-testimonial__author-name">
                                    <?php echo esc_html( $author_name ); ?>
                                </div>
                                <span class="cs-testimonial__author-title">
                                    <?php echo esc_html( $author_title ); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>