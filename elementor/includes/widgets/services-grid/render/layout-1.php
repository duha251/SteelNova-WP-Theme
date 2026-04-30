<?php
use Steelnova\Inc\Integrations\Elementor\Elementor_Helpers;

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
            'taxonomy' => 'service_category',
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
    'post_type' => 'service',
    'img_width'  => $settings['img_size']['width'] ?: null,
    'img_height' => $settings['img_size']['height'] ?: null,
    'title_tag'  => $settings['title_tag'] ?: 'div',
];

$custom_settings = json_encode([ $query_args, $display_args ]);

$wrapper_attrs = [
    'class' => 'is-post-type-service',
    'data-settings' => $custom_settings,
    'data-layout'   => $layout,
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<?php if( $settings['layout_type'] === 'grid' ) : 
    $this->add_render_attribute('wrapper', 'class', ['grid', 'service-grid'] );
?>
    <div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
        <div class="grid__inner">
            <?php foreach( $posts as $post ) : ?>
                <div class="grid__item">
                    <?php steelnova_get_template('/elementor/includes/widgets/services/templates/service-1', [
                        'display_args' => $display_args,
                        'post' => $post,
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else : 
    wp_enqueue_script('swiper'); // Enqueue Swiper script for carousel functionality
    $this->add_render_attribute('wrapper', 'class', ['carousel', 'service-carousel'] );    
?>
    <div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
        <div class="carousel__container swiper">
            <div class="carousel__inner swiper-wrapper">
                <?php foreach( $posts as $post ) : ?>
                    <div class="carousel__item swiper-slide">
                        <?php steelnova_get_template('/elementor/includes/widgets/services/templates/service-1', [
                            'display_args' => $display_args,
                            'post' => $post,
                        ]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>