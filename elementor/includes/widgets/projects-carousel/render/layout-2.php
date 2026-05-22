<?php
$layout = $settings['layout'];
$post_ids = $settings['ids'];
$cat_ids = $settings['categories'] ?? [];

$query_args = [
    'post_type'      => 'project',
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
    'img_width'  => $settings['img_size']['width'] ?: 1356,
    'img_height' => $settings['img_size']['height'] ?: 748,
    'title_tag'  => $settings['title_tag'] ?: 'h6',
    'show_btn' => $settings['show_btn'] === 'yes',
    'show_excerpt' => $settings['show_excerpt'] === 'yes',
    'num_of_words' => $settings['num_of_words'] ?: 18,
    'show_category' => $settings['show_category'] === 'yes',
    'show_meta' => $settings['show_meta'] === 'yes',
    'num_of_meta' => $settings['num_of_meta'] ?: 2,
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
            'slidesPerView' => $settings['slides_per_view_md'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 30
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 30
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 60
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 90
        ],
    ]
]);

$wrapper_attrs = [
    'class' => 'carousel cs-projects-carousel is-post-type-project',
    'data-layout'   => $layout,
];

if( $settings['layout2_style'] !== '0' ) {
    $wrapper_attrs['data-layout_style'] = $settings['layout2_style'];
}

$this->add_render_attribute('wrapper', $wrapper_attrs);

$item_active = $settings['item_active'] ?: 1;
?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $posts as $i => $post ) : 
                $display_args['active_class'] = '';    
                $item_key = 'item-'.$i;
                $item_attrs = [
                    'class' => 'carousel__item swiper-slide'
                ];
                if( !empty( $settings['items_animation'] ) && isset($settings['items_animation'][$i]['item_entrance_anim']) && !empty( $settings['items_animation'][$i]['item_entrance_anim'] ) ) {
                    $item_attrs['class'] .= ' wow elementor-repeater-item-'.$settings['items_animation'][$i]['_id'].' '.$settings['items_animation'][$i]['item_entrance_anim'];
                }
                $this->add_render_attribute( $item_key , $item_attrs);
            ?>
                <div <?php pxl_print_html( $this->get_render_attribute_string($item_key) ); ?>>
                    <?php steelnova_get_template('/elementor/includes/widgets/projects-grid/templates/project-' . $layout, [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>