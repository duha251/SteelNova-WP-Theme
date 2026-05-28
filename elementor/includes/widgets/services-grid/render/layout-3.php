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
    'show_icon' => $settings['show_icon'] === 'yes',
];

$wrapper_attrs = [
    'class' => 'grid cs-services-grid is-post-type-service',
    'data-layout'   => $layout,
    'data-settings' => json_encode( array_merge( $query_args, ['grid_load_type' => $settings['grid_load_type']], ['display_args' => $display_args] ),  ),
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="grid__inner">
        <?php foreach( $posts as $i => $post ) : 
                $item_key = 'item-'.$i;
                $item_attrs = [
                    'class' => 'grid__item'
                ];
                if( !empty( $settings['items_animation'] ) && isset($settings['items_animation'][$i]['item_entrance_anim']) && !empty( $settings['items_animation'][$i]['item_entrance_anim'] ) ) {
                    $item_attrs['class'] .= ' wow elementor-repeater-item-'.$settings['items_animation'][$i]['_id'].' '.$settings['items_animation'][$i]['item_entrance_anim'];
                }
                $this->add_render_attribute( $item_key , $item_attrs);    
        ?>
            <div <?php pxl_print_html( $this->get_render_attribute_string($item_key) ); ?>>
                <?php steelnova_get_template('/elementor/includes/widgets/services-grid/templates/service-' . $layout, [
                    'display_args' => $display_args,
                    'post' => $post,
                ]); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if( $settings['grid_load_type'] === 'pagination'  ) : ?>
        <?php echo steelnova()->component->get_pagination( $query, true ); ?>
    <?php endif; ?>
    <?php if( $settings['grid_load_type'] === 'load_more' ) : ?>
        <div class="grid__loadmore ajax">
            <button class="cs-button cs-button--primary cs-button--loadmore" data-current-page="1">
                <span class="cs-button__text"><?php echo esc_html__('Load More', 'steelnova'); ?></span>
            </button>
        </div>
    <?php endif; ?>
</div>