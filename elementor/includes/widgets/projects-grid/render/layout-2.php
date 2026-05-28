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

$wrapper_attrs = [
    'class' => 'grid cs-projects-grid is-post-type-project',
    'data-layout'   => $layout,
    'data-settings' => json_encode( array_merge( $query_args, ['grid_load_type' => $settings['grid_load_type']], ['display_args' => $display_args] ),  ),
];

if( $settings['layout2_style'] !== '0' ) {
    $wrapper_attrs['data-layout_style'] = $settings['layout2_style'];
}

$this->add_render_attribute('wrapper', $wrapper_attrs);

$item_active = $settings['item_active'] ?? 1;
?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="grid__inner">
        <?php foreach( $posts as $i => $post ) : 
            $active_class = $item_active === ( $i + 1 ) ? ' is-active' : '';
            if( $settings['layout2_style'] === '0' ) {
                $display_args['content_class'] = ' wow fadeInUp';
            }
            $display_args['active_class'] = $active_class;
            $item_key = 'item-'.$i;

            $item_attrs = [
                'class' => 'grid__item'
            ];

            if( $settings['sticky_on_scroll'] === 'yes' ) {
                $item_attrs['class'] .= ' is-sticky';
            }
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
