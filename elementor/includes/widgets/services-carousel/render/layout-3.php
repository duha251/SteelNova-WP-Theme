<?php
$layout = $settings['layout'];
$post_ids = $settings['ids'];
$cat_ids = $settings['categories'] ?? [];

$query_args = [
    'post_type'      => 'service',
    'posts_per_page' => $settings['posts_per_page'] ?: 6, 
    'orderby'        => $settings['orderby'],   
    'order'          => $settings['order'], 
];   

if( !empty( $post_ids ) ) {
    $query_args['post__in'] = $post_ids;
}

if( !empty( $cat_ids ) ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field'    => 'id',
            'terms'    => $cat_ids,
            'operator' => 'IN',
        ]
    ];
}

extract( steelnova()->post_manager->get_posts( $query_args ) );  // Return $posts and $query

if( count( $posts ) === 0 ) {
    echo '<div class="message">'.esc_html__('No Posts Found.', 'steelnova').'</div>';
    return;
}

$display_args = [
    'img_width'  => $settings['img_size']['width'] ?: null,
    'img_height' => $settings['img_size']['height'] ?: null,
    'title_tag'  => $settings['title_tag'] ?: 'div',
    'show_icon' => $settings['show_icon'] === 'yes'
];

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
            'slidesPerView' => $settings['slides_per_view'] ?: 4,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 30
        ],
    ]
]);

$wrapper_attrs = [
    'class' => 'carousel cs-services-carousel is-post-type-service',
    'data-layout'   => $layout,
];

if( $settings['swiper_boxshadow'] === 'yes' ) {
    $wrapper_attrs['class'] .= ' carousel--box-shadow';
}

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $posts as $i => $post ) : ?>
                <div class="carousel__item swiper-slide">
                    <?php steelnova_get_template('/elementor/includes/widgets/services-grid/templates/service-' . $layout, [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>
