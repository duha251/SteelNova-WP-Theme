<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Author extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'     => 'steelnova-post-author',
            'title'    => __( 'CS Post Author', 'steelnova' ),
            'icon'     => 'eicon-user-circle-o',
            'keywords' => [ 'steelnova', 'author', 'post' ],
            'style'    => ['steelnova-widget-post-author'],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Layout
        $this->register_layout_controls();
        // Content
        $this->register_content_controls();
        // Style
        $this->register_avatar_style_controls();
        $this->register_name_style_controls();
        $this->register_position_style_controls();
        $this->register_bio_style_controls();
        $this->register_divider_style_controls();
        $this->register_socials_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name'  => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->visual_choice([
            'name'    => 'layout',
            'label'   => __( 'Layout', 'steelnova' ),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Post Author 1', 'steelnova' ),
                    'image' => content_url( '/uploads/widget-layout/testimonial-1.webp' ),
                ],
                '2' => [
                    'title' => esc_attr__( 'Post Author 2', 'steelnova' ),
                    'image' => content_url( '/uploads/widget-layout/testimonial-1.webp' ),
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
        $this->start_content_section([
            'name'  => 'section_content',
            'label' => __( 'Post Author', 'steelnova' ),
        ]);
        $this->number([
            'name'        => 'avatar_size',
            'label'       => __( 'Avatar Size', 'steelnova' ),
            'default'     => 133,
            'min'         => 16,
            'max'         => 512,
            'step'        => 1,
            'description' => __( 'Set the size of the author avatar in pixels.', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Avatar Style Controls.
     *
     * Layout 1 : 133px circle, flex-shrink 0
     * Layout 2 : 207px circle, margin-bottom 22px
     */
    protected function register_avatar_style_controls() {
        $this->start_style_section([
            'name'  => 'section_avatar_style',
            'label' => __( 'Avatar', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'avatar_box_size',
            'label' => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__avatar' => '--cs-box-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'avatar_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'avatar_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_css_filter([
            'name'     => 'avatar_css_filter',
            'selector' => '{{WRAPPER}} .cs-post-author__avatar img',
        ]);
        $this->group_box_css([
            'name'     => 'avatar_box_css',
            'selector' => '{{WRAPPER}} .cs-post-author__avatar',
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'avatar_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_css_filter([
            'name'     => 'avatar_css_filter_hover',
            'selector' => '{{WRAPPER}} .cs-post-author__avatar:hover img',
        ]);
        $this->group_box_css([
            'name'     => 'avatar_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-post-author__avatar:hover',
        ]);
        $this->time([
            'name'  => 'avatar_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__avatar img' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'avatar_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Name Style Controls.
     *
     * Layout 1 : heading font, clamp(1.25→1.5rem), 600, heading color, margin-bottom 13px
     * Layout 2 : h5, margin-bottom 3px
     * Both     : inner <a> inherits color
     */
    protected function register_name_style_controls() {
        $this->start_style_section([
            'name'  => 'section_name_style',
            'label' => __( 'Name', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'name_typography',
            'selector' => '{{WRAPPER}} .cs-post-author__name',
        ]);

        $this->_start_controls_tabs([ 'name' => 'name_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'name_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'name_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__name,
                 {{WRAPPER}} .cs-post-author__name a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'name_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'name_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__name a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'name_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__name a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'name_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Position Style Controls.
     *
     * Layout 2 only : .cs-post-author__position — color #706F6F, font-size 15px
     */
    protected function register_position_style_controls() {
        $this->start_style_section([
            'name'      => 'section_position_style',
            'label'     => __( 'Position', 'steelnova' ),
            'condition' => [ 'layout' => [ '2' ] ],
        ]);

        $this->group_typography([
            'name'     => 'position_typography',
            'selector' => '{{WRAPPER}} .cs-post-author__position',
        ]);

        $this->_start_controls_tabs([ 'name' => 'position_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'position_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'position_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__position' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'position_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'position_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author:hover .cs-post-author__position' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'position_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__position' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'position_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Bio Style Controls.
     *
     * Layout 1 : text font, 14px, margin-bottom 13px
     * Layout 2 : 15px, margin-bottom 30px
     */
    protected function register_bio_style_controls() {
        $this->start_style_section([
            'name'  => 'section_bio_style',
            'label' => __( 'Bio', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'bio_typography',
            'selector' => '{{WRAPPER}} .cs-post-author__bio',
        ]);

        $this->_start_controls_tabs([ 'name' => 'bio_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'bio_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'bio_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__bio' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'bio_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'bio_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author:hover .cs-post-author__bio' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'bio_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__bio' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'bio_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Divider Style Controls.
     *
     * Layout 2 only : .cs-post-author .divider — margin-block 19px
     */
    protected function register_divider_style_controls() {
        $this->start_style_section([
            'name'      => 'section_divider_style',
            'label'     => __( 'Divider', 'steelnova' ),
            'condition' => [ 'layout' => [ '2' ] ],
        ]);

        $this->size([
            'name'  => 'divider_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author .divider' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->color([
            'name'  => 'divider_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author .divider' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'divider_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author .divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Socials Style Controls.
     *
     * Layout 1 : inline-flex, gap 33px; link color #121512 → hover #FF5B1B (text/icon link, no box)
     * Layout 2 : inline-flex, gap 8px; link is 46px box, border-radius 50%, dark bg → hover #FF5B1B bg
     */
    protected function register_socials_style_controls() {
        $this->start_style_section([
            'name'  => 'section_socials_style',
            'label' => __( 'Socials', 'steelnova' ),
        ]);

        // ── Wrapper ───────────────────────────────────────────────────────────
        $this->heading([
            'name'      => 'socials_wrapper_heading',
            'label'     => __( 'Wrapper', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->gaps([
            'name'  => 'socials_gap',
            'label' => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'socials_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // ── Icon link ─────────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'social_icon_heading',
            'label' => __( 'Icon Link', 'steelnova' ),
        ]);

        // Box size — layout 2 only (layout 1 has no box)
        $this->size([
            'name'  => 'social_icon_box_size',
            'label' => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials > a' => '--cs-box-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);
        $this->size([
            'name'  => 'social_icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials > a svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-post-author__socials > a i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'social_icon_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'social_icon_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'social_icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials > a'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-author__socials > a svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        // Background — layout 2 only
        $this->color([
            'name'  => 'social_icon_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials > a' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);
        $this->group_border([
            'name'     => 'social_icon_border',
            'selector' => '{{WRAPPER}} .cs-post-author__socials > a',
        ]);
        $this->dimensions([
            'name'  => 'social_icon_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'social_icon_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'social_icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                // Layout 1: hover changes text/icon color
                '{{WRAPPER}} .cs-post-author[data-layout="1"] .cs-post-author__socials > a:hover'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-author[data-layout="1"] .cs-post-author__socials > a:hover svg path' => 'fill: {{VALUE}};',
                // Layout 2: hover changes icon color inside box
                '{{WRAPPER}} .cs-post-author[data-layout="2"] .cs-post-author__socials > a:hover'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-author[data-layout="2"] .cs-post-author__socials > a:hover svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        // Background hover — layout 2 only
        $this->color([
            'name'  => 'social_icon_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author[data-layout="2"] .cs-post-author__socials > a:hover' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);
        $this->group_border([
            'name'     => 'social_icon_border_hover',
            'selector' => '{{WRAPPER}} .cs-post-author__socials > a:hover',
        ]);
        $this->time([
            'name'  => 'social_icon_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-author__socials > a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
