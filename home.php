<?php
/**
 * The template for displaying the blog posts index
 *
 * Used when showing latest posts on homepage
 *
 * @package SteelNova
 * @author Case-Themes
 * @link https://steelnova.casethemes.net
 * @since 1.0.0
 */
$archive_template_id = (int) steelnova()->get_theme_option('archive_standard_template_id', 0);
$sidebar_mode = steelnova()->get_theme_option('blog_sidebar_mode', 'right');
if( isset( $_GET['sidebar'] ) ) {
    $sidebar_mode = $_GET['sidebar'];
}
$display_args = [
    'img_width'  => null,
    'img_height' => null,
    'title_tag'  =>'h4',
    'show_btn' => true,
    'btn_text'   => 'Read The Article',
    'show_excerpt' => true,
    'num_of_words' => 100,
    'show_author'  => true,
    'show_category' => true,
    'show_date' => true,
];
?>

<?php get_header(); ?>
    <main id="main">
        <div class="container">
            <div class="inner">
                <?php if( $sidebar_mode !== 'none' ) : ?>                    
                    <div class="content-area">
                <?php endif; ?>
                    <?php
                        if( $archive_template_id !== 0 ) {
                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $archive_template_id );
                        }else {
                            global $post;
                            wp_enqueue_style('steelnova-post-standard', get_template_directory_uri() . '/elementor/assets/css/widgets/post.min.css', [], '1.0');
                            if ( have_posts() ) { ?>
                                <div class="grid cs-posts-grid is-post-type-post" data-layout="1">
                                    <div class="grid__inner">
                                        <?php
                                            while ( have_posts() ) {
                                                the_post(); ?> 
                                                <div class="grid__item">
                                                <?php steelnova_get_template('/elementor/includes/widgets/posts-grid/templates/post-1', [
                                                    'display_args' => $display_args,
                                                    'post' => $post,
                                                ]); ?>
                                                </div> 
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <?php echo steelnova()->component->get_pagination(); ?>
                                </div>
                            <?php
                            } else {
                                get_template_part('template-parts/content/none');
                            }
                        }
                    ?>
                <?php if( $sidebar_mode !== 'none' ) : ?>                    
                    </div>
                <?php endif; ?>
                <?php if( $sidebar_mode !== 'none' ) : ?>
                    <div class="sidebar-area">
                        <?php get_sidebar(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?php get_footer(); ?>
