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
                            if ( have_posts() ) { ?>
                                <div class="grid post-grid is-post-type-post">
                                    <div class="grid-inner">
                                        <?php
                                            while ( have_posts() ) {
                                                the_post(); 
                                                get_template_part('template-parts/content/archive');
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php
                            } else {
                                get_template_part('template-parts/content/none');
                            }
                        }
                        // steelnova()->layout->get_pagination();
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
