<?php
$post_type = $settings['post_type'] ?? 'post';
$post_ids = $settings[$post_type.'_ids'];
$cat_ids = $settings[$post_type.'_categories'] ?? [];

$query_args = [
    'post_type'      => $post_type,
    'posts_per_page' => $settings['posts_per_page'] ?: 6, 
    'orderby'        => $settings['orderby'],   
    'order'          => $settings['order'], 
    'query_type'     => $settings['query_type'], 
];   

if( !empty( $post_ids ) ) {
    $query_args['post__in'] = $post_ids;
}

if( !empty( $cat_ids ) ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => $post_type === 'post' ? 'category' : $post_type . '_category',
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

$img_width  = $settings['img_size']['width'] ?: 500;
$img_height = $settings['img_size']['height'] ?: 500;
$title_tag  = $settings['title_tag'] ?: 'div';

$wrapper_attrs = [
    'class' => 'grid cs-posts-listing is-post-type-'.$post_type,
    'data-layout' => '2'
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="grid__inner">
        <?php foreach( $posts as $post ) : 
            $thumbnail_id = get_post_thumbnail_id( $post->ID );
        ?>
            <div class="grid__item">
                <div class="post">
                    <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="post__link">
                        <<?php echo esc_attr( $title_tag ); ?> class="post__title">
                                <?php echo esc_html( get_the_title( $post->ID ) ); ?>
                        </<?php echo esc_attr( $title_tag ); ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M5.01697 0.233506C5.32831 -0.0778354 5.83296 -0.0778354 6.1443 0.233506L10.9277 5.01694C11.239 5.32828 11.239 5.83295 10.9277 6.14429L6.1443 10.9277C5.83297 11.239 5.3283 11.239 5.01697 10.9277C4.70564 10.6163 4.70565 10.1118 5.01697 9.80037L8.43947 6.37785H0.797234C0.356954 6.37785 3.25362e-05 6.02089 0 5.58062C2.56813e-08 5.14031 0.356934 4.78337 0.797234 4.78337H8.43947L5.01697 1.36085C4.70564 1.04952 4.70565 0.54485 5.01697 0.233506Z" fill="white"/>
                        </svg>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
