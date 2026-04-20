<?php 
/**
 * Front page template file
 * 
 * @package SteelNova
 */

$post_type = get_query_var('post_type');

if (is_array($post_type)) {
    $post_type = reset($post_type);
}

if (empty($post_type)) {
    $post_type = get_post_type();
}

$archive_template_id = (int) steelnova()->get_theme_option($post_type . '_archive_template_id', 0);

$sidebar_mode = steelnova()->get_theme_option('blog_sidebar_mode', 'none');
if( isset( $_GET['sidebar'] ) ) {
    $sidebar_mode = $_GET['sidebar'];
}
?>

<?php get_header(); ?>
<main id="main">
    <div class="inner">
        <div class="content-area">
            <?php
                if( is_numeric($layout) && $layout > 0 && class_exists('Pxltheme_Core') && class_exists('\Elementor\Plugin') ) {
                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $archive_template_id );
                }else {
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post(); 
                            get_template_part('template-parts/content/archive');
                        }
                        if ( get_next_posts_link() ) {
                            next_posts_link();
                        }
                        if ( get_previous_posts_link() ) {
                            previous_posts_link();
                        }
                    } else {
                        get_template_part('template-parts/content/none');
                    }
                }
                // steelnova()->layout->the_pagination();
            ?>
        </div>
        <?php if( $sidebar_mode !== 'none' ) : ?>
            <div class="sidebar-area">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
