<?php
if ( empty( $settings['content_items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$wrapper_attrs_tmp = [
    'class' => 'cs-testimonial-carousel',
    'data-layout' => '2'
];

if( $settings['swiper_boxshadow'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' carousel--box-shadow';
}


$this->add_render_attribute( 'wrapper', $wrapper_attrs_tmp );

$ratings = $settings['rating_items'] ?? [];
$authors = $settings['author_items'] ?? [];
$own_icons = $settings['icon_items'] ?? [];
$images = $settings['img_items'] ?? [];

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

$swipper_thumb_settings = [
    'allowTouchMove' => false,
    'effect'         => 'fade'
];

?>

<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <?php if( !empty( $settings['img_items'] && $settings['show_image'] === 'yes' ) ) : 
        $img_width = $settings['img_size']['width'] ?: null;
        $img_height = $settings['img_size']['height'] ?: null;
    
    ?>
        <div class="carousel__container swiper cs-testimonial-carousel__images" data-swiper="<?php echo esc_attr( json_encode( $swipper_thumb_settings ) ); ?>">
            <div class="carousel__inner swiper-wrapper">
                <?php foreach( $settings['img_items'] as $i => $img ) :
                ?>
                    <div class="carousel__item swiper-slide">
                        <?php steelnova_print_image_by_size($img['img']['id'], $img_width, $img_height, ['class' => 'cs-testimonial__image']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="carousel__container swiper cs-testimonial-carousel__content" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $settings['content_items'] as $i => $content ) : 
                $content  = $content['content'] ?? '';
                $rating   = $ratings[$i]['rating'] ?? '';
                $author_image = $authors[$i]['author_image'] ?? ['id' => ''];
                $author_name  = $authors[$i]['author_name'] ?? '';
                $author_title = $authors[$i]['author_title'] ?? '';
                $icon     = $own_icons[$i]['icon'] ?? $settings['icon'];
                $image      = $images[$i]['img'] ?? [];
            ?>
                <div class="carousel__item swiper-slide">
                    <div class="cs-testimonial">
                        <div class="cs-testimonial__main">
                            <div class="cs-testimonial__header">
                                <?php if( !empty( $icon['value'] ) ) : ?>
                                    <div class="cs-testimonial__icon d-inline-flex-center">
                                        <?php steelnova_elementor_print_icon( $icon ); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if( !empty( $rating )) : ?>
                                    <div class="cs-testimonial__rating">
                                        <div class="cs-stars">
                                            <?php for($i=1; $i<=5; $i++) : 
                                                $star_icon_class = $rating <= $i ? 'fill' : 'normal';
                                            ?>
                                                <svg class="<?php echo esc_attr( $star_icon_class ); ?>" xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                                                    <path d="M7.88265 0.600855C8.14295 -0.200285 9.27635 -0.200285 9.53665 0.600855L10.9966 5.09406C11.113 5.45234 11.4469 5.69491 11.8236 5.69491H16.548C17.3904 5.69491 17.7406 6.77285 17.0592 7.26798L13.237 10.0449C12.9322 10.2664 12.8047 10.6589 12.9211 11.0171L14.381 15.5103C14.6414 16.3115 13.7244 16.9777 13.0429 16.4825L9.22075 13.7056C8.91595 13.4842 8.50325 13.4842 8.19845 13.7056L4.37634 16.4825C3.69485 16.9777 2.77791 16.3115 3.03822 15.5103L4.49815 11.0171C4.61456 10.6589 4.48703 10.2664 4.18226 10.0449L0.360114 7.26798C-0.321376 6.77285 0.0288642 5.69491 0.871234 5.69491H5.59567C5.97238 5.69491 6.30626 5.45234 6.42267 5.09406L7.88265 0.600855Z" fill="#0A1119"/>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                        
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="cs-testimonial__content">
                                <?php echo esc_html( $content ); ?>
                            </p>
                        </div>
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