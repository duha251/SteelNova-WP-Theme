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
$date_format = $settings['date_format'];

$wrapper_attrs = [
    'class' => 'grid cs-posts-listing is-post-type-post',
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
                    <div class="post__thumbnail">
                        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                            <?php steelnova_print_image_by_size( $thumbnail_id, $img_width, $img_height, [] ); ?>
                        </a>
                    </div>
                    <div class="post__content">
                        <div class="post__date">
                            <?php echo get_the_date( $date_format, $post->ID ); ?>
                        </div>
                        <<?php echo esc_attr( $title_tag ); ?> class="post__title">
                            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $post->ID ) ); ?>
                            </a>
                        </<?php echo esc_attr( $title_tag ); ?>>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
