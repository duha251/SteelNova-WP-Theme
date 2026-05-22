<?php
namespace SteelNova\Elementor\Widgets\Traits;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Post Style Controls Trait
 * 
 * Shared style controls for posts-grid and posts-carousel widgets.
 * Selectors match the CSS in elementor/assets/css/widgets/post.min.css
 */
trait Post_Style_Controls {

    /**
     * Register all post style controls
     */
    protected function register_all_post_style_controls() {
        $this->register_post_item_style_controls();
        // $this->register_post_image_style_controls();
        // $this->register_post_content_style_controls();
        // $this->register_post_title_style_controls();
        // $this->register_post_excerpt_style_controls();
        // $this->register_post_date_style_controls();
        // $this->register_post_meta_style_controls();
        // $this->register_post_category_style_controls();
        // $this->register_post_author_style_controls();
        // $this->register_post_button_style_controls();
        // $this->register_post_divider_style_controls();
    }

    /**
     * Post Item Container
     * CSS: .cs-posts-grid[data-layout] .post, .cs-posts-carousel[data-layout] .post
     */
    protected function register_post_item_style_controls() {
        $selector = '{{WRAPPER}} .post';

        $this->start_style_section([
            'name'  => 'section_post_item_style',
            'label' => __( 'Post Item', 'steelnova' ),
        ]);

        $this->_start_controls_tabs([ 'name' => 'post_item_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'post_item_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'post_item_bg',
            'selector' => $selector,
    ]);
        $this->group_box_css([
            'name'     => 'post_item_',
            'selector' => $selector,
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'post_item_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'post_item_bg_hover',
            'selector' => $selector . ':hover',
        ]);
        $this->group_box_css([
            'name'     => 'post_item_hover_',
            'selector' => $selector . ':hover',
        ]);
        $this->time([
            'name'      => 'post_item_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                $selector => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}