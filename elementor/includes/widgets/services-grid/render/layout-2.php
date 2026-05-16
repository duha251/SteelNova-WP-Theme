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
    'title_tag'  => $settings['title_tag'] ?: 'h6',
    'show_btn' => $settings['show_button'] === 'yes',
    'btn_text'   => $settings['button_text'] ?: 'Learn Details',
    'show_icon' => $settings['show_icon'] === 'yes',
    'show_excerpt' => $settings['show_excerpt'] === 'yes',
    'num_of_words' => $settings['num_of_words'] ?: 10,
];

$wrapper_attrs = [
    'class' => 'grid cs-services-grid is-post-type-service',
    'data-layout'   => $layout,
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="grid__inner">
        <?php foreach( $posts as $i => $post ) : ?>
            <div class="grid__item">
                <?php steelnova_get_template('/elementor/includes/widgets/services-grid/templates/service-' . $layout, [
                    'display_args' => $display_args,
                    'post' => $post,
                ]); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if( $settings['grid_load_type'] === 'pagination'  ) : ?>
        <?php echo steelnova()->component->get_pagination( $query, false ); ?>
    <?php endif; ?>
    <?php if( $settings['grid_load_type'] === 'load_more' ) : ?>
        <div class="grid__loadmore ajax">
            <button class="cs-button cs-button--primary cs-button--loadmore" data-current-page="1">
                <span class="cs-button__text"><?php echo esc_html__('Load More', 'steelnova'); ?></span>
            </button>
        </div>
    <?php endif; ?>
</div>
