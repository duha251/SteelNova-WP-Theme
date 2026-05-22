<?php
$thumbnail_url = get_the_post_thumbnail_url($post->ID);    
extract( $display_args ); 
?>
<article class="post post-<?php echo esc_attr( $post->ID ); ?>" style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>);">
    <div class="post__content">
        <div class="post__content-top">
            <?php if( $show_category == true ) : ?>
                <div class="post__category categories">
                        <?php the_terms($post->ID, 'category', '', ''); ?>
            
                </div>
            <?php endif; ?>
            <<?php echo esc_attr( $title_tag ); ?> class="post__title" data-hover="text-underline-slide">
                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                    <?php echo esc_html( get_the_title( $post->ID ) ); ?>
                </a>
            </<?php echo esc_attr( $title_tag ); ?>>
        </div>
        <div class="divider"></div>
        <div class="post__content-bottom">
            <?php if( $show_author == true ) : ?>
                <span class="post__date">
                    <?php echo esc_html( get_the_date( 'M d, Y', $post->ID ) ); ?>
                </span>
                <span class="separator">/</span>
            <?php endif; ?>
            <?php if( $show_author == true ) : 
                $author_id = get_post_field( 'post_author', $post->ID );
                $author_name = get_the_author_meta('display_name', $author_id);
                $author_url  = get_author_posts_url($author_id);    
            ?>
                <a href="<?php echo esc_url( $author_url ); ?>">
                    <?php echo esc_html( $author_name ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</article>
