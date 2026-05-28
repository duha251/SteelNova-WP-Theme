<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;


if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Posts_Listing extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-posts-listing',
            'title'      => __( 'CS Posts Listing', 'steelnova' ),
            'icon'       => 'eicon-post-list',
            'keywords'   => [ 'posts', 'grid', 'blog', 'news', 'steelnova', 'cs', 'casetheme', 'list', 'recent', 'featured', 'popular' ],
            'script'     => [],
            'style'      => ['steelnova-widget-post-listing'],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_post_listing_item_style_controls();
        $this->register_post_listing_thumbnail_style_controls();
        $this->register_post_listing_date_style_controls();
        $this->register_post_listing_title_style_controls();
        $this->register_post_listing_link_row_style_controls();
        // $this->register_style_controls();
        // Settings Controls
        $this->register_grid_settings_controls();
        $this->register_post_display_settings_controls();
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }


    /**  
     * Register Layout Controls
    */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __('Layout', 'steelnova')
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'steelnova'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Post Listing 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/post-listing-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Post Listing 2', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/post-listing-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $post_types = [
            'post'        => __('Post', 'steelnova'),
            'project'     => __('Project', 'steelnova'),
            'service'     => __('Service', 'steelnova'),
        ];
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Source', 'steelnova' ),
        ]);
        $this->select([
            'name'    => 'post_type',
            'label'   => __('Post Type', 'steelnova'),
            'default' => 'post',
            'options' => $post_types
        ]);
        $this->select([
            'name'    => 'query_type',
            'label'   => __('Query Type', 'steelnova'),
            'default' => '',
            'options' => [
                ''             => __('Default', 'steelnova'),
                'popular'      => __('Popular', 'steelnova'),
                'featured'     => __('Featured', 'steelnova'),
                'random'       => __('Random', 'steelnova'),
                'recent'       => __('Recent', 'steelnova'),
            ],
        ]);
        $this->select([
            'name' => 'source_type',
            'label' => __('Source Type', 'steelnova'),
            'default' => 'id' ,
            'options' => [
                'id'       => __('ID', 'steelnova'),
                'category' => __('Category', 'steelnova'),
            ]
        ]);

        foreach ($post_types as $key => $value) {        
            $this->select2([
                'name' =>$key.'_ids',
                'label_block' => true,
                'label' => __('List ', 'steelnova') . $value,
                'options' => steelnova()->post_manager->get_cpt_post_list( $key ),
                'multiple' => true,
                'condition' => [
                    'source_type' => 'id',
                    'post_type' => $key
                ]
            ]);
            $this->select2([
                'name' =>$key.'_categories',
                'label_block' => true,
                'label' => __('Categories', 'steelnova'),
                'options' => steelnova()->post_manager->get_cpt_category_list( $key === 'post' ? 'category' : $key . '_category' ),
                'multiple' => true,
                'condition' => [
                    'source_type' => 'category',
                    'post_type' => $key
                ]
            ]);
        }
        $this->select([
            'name' => 'orderby',
            'label' => __('Order By', 'steelnova'),
            'separator' => 'before',
            'options' => [
                'date'  => __('Date', 'steelnova'),
                'title' => __('Title', 'steelnova'),
                'author'=> __('Author', 'steelnova'),
                'id'    => __('ID', 'steelnova'),
                'rand'  => __('Random', 'steelnova'),
            ],
            'default' => 'date'
        ]);
        $this->select([
            'name' => 'order',
            'label' => __('Order', 'steelnova'),
            'options' => [
                'ASC'  => __('Ascending', 'steelnova'),
                'DESC' => __('Descending', 'steelnova'),
            ],
            'default' => 'DESC'
        ]);
        $this->number([
            'name' => 'posts_per_page',
            'label' => __('Posts Per Page', 'steelnova'),
            'min'   => -1,
            'default' => 6,
            'method' => 'add_control',
            'description' => __('To get all posts leave the value as -1', 'steelnova')
        ]);
        $this->end_controls_section();
    }

        // -------------------------------------------------------------------------
    // Post Item (shared both layouts)
    // -------------------------------------------------------------------------

    /**
     * Post item wrapper & row gap
     * CSS: .cs-posts-listing[data-layout] .post
     */
    protected function register_post_listing_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_listing_item_style',
            'label' => __( 'Post Item', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'listing_row_gap',
            'label'     => __( 'Row Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing' => '--cs-row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Layout 1 — divider between items
        $this->color([
            'name'      => 'listing_divider_color',
            'label'     => __( 'Divider Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .grid__item + .grid__item' => 'border-top-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => '1' ],
        ]);

        // Layout 1 — gap between thumbnail and content
        $this->size([
            'name'      => 'listing_item_gap',
            'label'     => __( 'Gap (Thumbnail ↔ Content)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post' => 'gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '1' ],
        ]);

        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Layout 1 — Thumbnail
    // -------------------------------------------------------------------------

    /**
     * CSS: .cs-posts-listing[data-layout="1"] .post__thumbnail
     */
    protected function register_post_listing_thumbnail_style_controls() {
        $this->start_style_section([
            'name'      => 'section_listing_thumbnail_style',
            'label'     => __( 'Thumbnail', 'steelnova' ),
            'condition' => [ 'layout' => '1' ],
        ]);

        $this->size([
            'name'      => 'thumbnail_width',
            'label'     => __( 'Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__thumbnail' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'thumbnail_border_radius',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__thumbnail' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->group_css_filter([
            'name'     => 'thumbnail_css_filter',
            'selector' => '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__thumbnail img',
        ]);

        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Layout 1 — Date badge
    // -------------------------------------------------------------------------

    /**
     * CSS: .cs-posts-listing[data-layout="1"] .post__date
     */
    protected function register_post_listing_date_style_controls() {
        $this->start_style_section([
            'name'      => 'section_listing_date_style',
            'label'     => __( 'Date Badge', 'steelnova' ),
            'condition' => [ 'layout' => '1' ],
        ]);

        $this->group_typography([
            'name'     => 'date_typography',
            'selector' => '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date',
        ]);

        $this->dimensions([
            'name'      => 'date_padding',
            'label'     => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'date_border_radius',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'date_margin_bottom',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'date_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'date_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'date_color',
            'label'     => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'date_bg_color',
            'label'     => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'date_border_color',
            'label'     => __( 'Border Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post__date' => 'border-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'date_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'date_color_hover',
            'label'     => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post:hover .post__date' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'date_bg_color_hover',
            'label'     => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="1"] .post:hover .post__date' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Title (both layouts)
    // -------------------------------------------------------------------------

    /**
     * CSS:
     *   layout-1: .cs-posts-listing[data-layout="1"] div.post__title
     *   layout-2: .cs-posts-listing[data-layout="2"] .post div.post__title
     */
    protected function register_post_listing_title_style_controls() {
        $this->start_style_section([
            'name'  => 'section_listing_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'listing_title_typography',
            'selector' => '{{WRAPPER}} .cs-posts-listing .post__title',
        ]);

        $this->_start_controls_tabs([ 'name' => 'listing_title_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'listing_title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'listing_title_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing .post__title,
                 {{WRAPPER}} .cs-posts-listing .post__title > a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'listing_title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'listing_title_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing .post__title > a:hover,
                 {{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a:hover .post__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Layout 2 — Link row (.post > a)
    // -------------------------------------------------------------------------

    /**
     * CSS: .cs-posts-listing[data-layout="2"] .post > a
     */
    protected function register_post_listing_link_row_style_controls() {
        $this->start_style_section([
            'name'      => 'section_listing_link_row_style',
            'label'     => __( 'Link Row', 'steelnova' ),
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->dimensions([
            'name'      => 'link_row_padding',
            'label'     => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'link_row_border_radius',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'link_row_gap',
            'label'     => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'link_row_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'link_row_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'link_row_color',
            'label'     => __( 'Text / Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a' => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name'     => 'link_row_bg',
            'selector' => '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a',
        ]);
        $this->color([
            'name'      => 'link_row_border_color',
            'label'     => __( 'Border Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a' => 'border-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'link_row_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'link_row_color_hover',
            'label'     => __( 'Text / Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a:hover svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name'     => 'link_row_bg_hover',
            'selector' => '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a:hover',
        ]);
        $this->color([
            'name'      => 'link_row_border_color_hover',
            'label'     => __( 'Border Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a:hover' => 'border-color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'      => 'link_row_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-posts-listing[data-layout="2"] .post > a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }


        /**
     * Register Grid Source Content Controls
     */
    protected function register_post_display_settings_controls() {        
        $this->start_settings_section([ 
            'name' => 'settings_archive_display', 
            'label' => __('Display', 'steelnova') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title HTML Tag', 'steelnova'),
            'options' => Static_Options::title_html_tag_options( true ),
            'separator' => 'before',
            'default' => ''
        ]);
        $this->text([
            'name' => 'date_format',
            'label' => __('Date Format', 'steelnova'),
            'description' => '<a href="https://www.php.net/manual/en/function.date.php" target="_blank">Learn More.<a/>',
            'placeholder' => __('d M, Y', 'steelnova'),
        ]);
        $this->end_controls_section();
    }



}