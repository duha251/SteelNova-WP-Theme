<?php
/**
 * The template for displaying all pages
 *
 * @package SteelNova
 * @author Case-Themes
 * @link https://steelnova.casethemes.net
 * @since 1.0.0
 */

$sidebar_mode = isset( $_GET['sidebar'] ) ? $_GET['sidebar'] : 'none';

?>

<?php get_header(); ?>

<main id="main" class="main">
    <div class="container">
        <div class="inner">
            <!-- Open Content Area -->
            <?php if( $sidebar_mode !== 'none' ) : ?>
                <div class="content-area">
            <?php endif; ?>

            <?php while ( have_posts() ) :
                the_post();

                the_content();

                wp_link_pages([
                    'before'      => '<div class="page-links">',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ]);

            endwhile; 
            
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            } ?>
            <!-- Close Content Area -->
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
