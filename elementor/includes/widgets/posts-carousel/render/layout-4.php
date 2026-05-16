<?php
$layout = $settings['layout'];
$post_ids = $settings['ids'];
$cat_ids = $settings['categories'] ?? [];

$query_args = [
    'post_type'      => 'post',
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

$swiper_settings = steelnova_get_carousel_settings( $settings, [
    'breakpoints' => [
        'xs' => [
            'slidesPerView' => $settings['slides_per_view_xs'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xs'] ?: 1,
            'spaceBetween' => $settings['space_between_xs']['column'] ?: 25
        ],
        'sm' => [
            'slidesPerView' => $settings['slides_per_view_sm'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_sm'] ?: 1,
            'spaceBetween' => $settings['space_between_sm']['column'] ?: 25
        ],
        'md' => [
            'slidesPerView' => $settings['slides_per_view_md'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 25
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 25
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 25
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 25
        ],
    ]
]);

$display_args = [
    'title_tag'  => $settings['title_tag'] ?: 'div',
    'show_category' => $settings['show_category'] === 'yes',
    'show_date'  => $settings['show_date'] === 'yes',
    'show_author'  => $settings['show_author'] === 'yes',
];

$wrapper_attrs = [
    'class' => 'grid cs-posts-grid is-post-type-post',
    'data-layout' => $layout,
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $posts as $i => $post ) : ?>
                <div class="carousel__item swiper-slide">
                    <?php steelnova_get_template('/elementor/includes/widgets/posts-grid/templates/post-' . $layout, [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>

