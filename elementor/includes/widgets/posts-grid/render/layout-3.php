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
    'img_height' => $settings['img_size']['height'] ?: 658,
    'title_tag'  => $settings['title_tag'] ?: 'h5',
    'show_btn' => $settings['show_btn'] === 'yes',
    'btn_text'   => $settings['btn_text'] ?: 'Learn Details',
    'show_category' => $settings['show_category'] === 'yes',
];

$wrapper_attrs = [
    'class' => 'grid posts-grid is-post-type-post',
    'data-layout' => $layout,
];

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <?php if( $settings['show_layout_feature'] === 'yes' && !empty($posts) ) : 
        $firstFourPosts = array_splice($posts, 0, 4);
        
        $mainPost = $firstFourPosts[0];
        
        $sidePosts = array_slice($firstFourPosts, 1);
    ?>
        <div class="grid__inner posts-grid__feature">
            <div class="grid__item posts-grid__feature-main">
                <?php 
                    $thumbnail_url = get_the_post_thumbnail_url($mainPost->ID, 'full'); 
                    $author_id = get_post_field( 'post_author', $mainPost->ID );
                ?>
                <article class="post post-<?php echo esc_attr( $mainPost->ID ); ?>" style="background-image: url('<?php echo esc_url( $thumbnail_url ); ?>')">
                    <div class="post__category categories">
                        <?php the_terms($mainPost->ID, 'category', '', ''); ?>
                    </div>
                    <h4 class="post__title">
                        <a href="<?php echo get_permalink( $mainPost->ID ); ?>">
                            <?php echo get_the_title( $mainPost->ID ); ?>
                        </a>
                    </h4>
                    <div class="divider"></div>
                    <div class="post__meta">
                        <?php echo get_the_date( 'M d,Y', $mainPost->ID ); ?> / by 
                        <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"><?php the_author_meta('display_name', $author_id); ?></a>
                    </div>
                </article>
            </div>

            <div class="grid__item posts-grid__feature-list">
                <?php foreach( $sidePosts as $i => $s_post ) : 
                    $s_thumb_id = get_post_thumbnail_id($s_post->ID);
                    $s_author_id = get_post_field( 'post_author', $s_post->ID );
                ?>
                    <?php if( $i > 0 ) : ?>
                        <span class="divider"></span>
                    <?php endif; ?>
                    <article class="post post-<?php echo esc_attr( $s_post->ID ); ?>">
                        <div class="post__featured-image">
                            <a href="<?php echo get_permalink($s_post->ID); ?>">
                                <?php steelnova_print_image_by_size( $s_thumb_id, 500, 500, [] ); ?>
                            </a>
                        </div>
                        <div class="post__content">
                            <div class="post__category categories"><?php the_terms($s_post->ID, 'category', '', ''); ?></div>
                            <h5 class="post__title">
                                <a href="<?php echo get_permalink($s_post->ID); ?>"><?php echo get_the_title($s_post->ID); ?></a>
                            </h5>
                            <div class="post__meta">
                                <?php echo get_the_date( 'M d,Y', $mainPost->ID ); ?> / by 
                                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"><?php the_author_meta('display_name', $author_id); ?></a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

        </div>
    <?php endif; 
    ?>

    <?php if( !empty( $posts ) ) : ?>
        <div class="grid__inner posts-grid__more">
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
