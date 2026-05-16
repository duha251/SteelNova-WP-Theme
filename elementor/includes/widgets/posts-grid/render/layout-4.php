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
    <?php if( !empty( $posts ) ) : ?>
        <div class="grid__inner">
            <?php foreach( $posts as $post ) : ?>
                <div class="grid__item">
                    <?php steelnova_get_template('/elementor/includes/widgets/posts-grid/templates/post-' . $layout, [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if( $settings['grid_load_type'] === 'pagination'  ) : ?>
        <?php echo steelnova()->component->get_pagination( $query, false ); ?>
    <?php endif; ?>
    <?php if( $settings['grid_load_type'] === 'load_more' ) : ?>
        <div class="grid__loadmore ajax">
            <button class="cs-button cs-button--primary cs-button--loadmore" data-current-page="1">
                <span class="button-text"><?php echo esc_html__('Load More', 'steelnova'); ?></span>
            </button>
        </div>
    <?php endif; ?>
</div>
