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

$display_args = [
    'img_width'  => $settings['img_size']['width'] ?: 767,
    'img_height' => $settings['img_size']['height'] ?: 582,
    'title_tag'  => $settings['title_tag'] ?: 'h5',
    'show_btn' => $settings['show_btn'] === 'yes',
    'btn_text'   => $settings['btn_text'] ?: 'Read The Article',
    'show_date'  => $settings['show_date'] === 'yes',
    'show_excerpt' => $settings['show_excerpt'] === 'yes',
    'num_of_words' => $settings['num_of_words'] ?: 15,
    'show_category' => $settings['show_category'] === 'yes'
];

$wrapper_attrs = [
    'class' => 'carousel cs-posts-carousel is-post-type-post',
    'data-layout' => $layout,
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $posts as $i => $post ) : 
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
                    <?php steelnova_get_template('/elementor/includes/widgets/posts-grid/templates/post-' . $layout, [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>