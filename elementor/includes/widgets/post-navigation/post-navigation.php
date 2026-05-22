<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Navigation extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'     => 'steelnova-post-navigation',
            'title'    => __( 'CS Post Navigation', 'steelnova' ),
            'icon'     => 'eicon-post-navigation',
            'keywords' => [ 'steelnova', 'navigation', 'post', 'prev', 'next' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        $this->register_button_style_controls();
        $this->register_icon_style_controls();
        $this->register_text_style_controls();
        $this->register_divider_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name'  => 'section_content',
            'label' => __( 'Post Navigation', 'steelnova' ),
        ]);
        $this->text([
            'name'    => 'prev_label',
            'label'   => __( 'Previous Label', 'steelnova' ),
            'default' => __( 'Previous Project', 'steelnova' ),
        ]);
        $this->text([
            'name'    => 'next_label',
            'label'   => __( 'Next Label', 'steelnova' ),
            'default' => __( 'Next Project', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Button Style Controls.
     *
     * .cs-post-navigation__button — height 60px, padding-inline 20px 40px,
     *   bg #FFF, border thin solid #FAF5ED, border-radius 100px,
     *   color #0A1119, font Inter 14px 500, gap 40px
     * .cs-button--disable — disabled state (no prev/next post)
     */
    protected function register_button_style_controls() {
        $this->start_style_section([
            'name'  => 'section_button_style',
            'label' => __( 'Button', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'button_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->gaps([
            'name'  => 'button_gap',
            'label' => __( 'Inner Gap (icon ↔ text)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'button_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'button_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'button_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'button_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'button_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'button_border',
            'selector' => '{{WRAPPER}} .cs-post-navigation__button',
        ]);
        $this->dimensions([
            'name'  => 'button_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'button_box_shadow',
            'selector' => '{{WRAPPER}} .cs-post-navigation__button',
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'button_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'button_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'button_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'button_border_hover',
            'selector' => '{{WRAPPER}} .cs-post-navigation__button:hover',
        ]);
        $this->group_box_shadow([
            'name'     => 'button_box_shadow_hover',
            'selector' => '{{WRAPPER}} .cs-post-navigation__button:hover',
        ]);
        $this->time([
            'name'  => 'button_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        // ── Disabled ─────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'button_tab_disabled',
            'label' => __( 'Disabled', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'button_color_disabled',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button.cs-button--disable' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'button_bg_color_disabled',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button.cs-button--disable' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->opacity([
            'name'  => 'button_opacity_disabled',
            'label' => __( 'Opacity', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button.cs-button--disable' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls.
     *
     * .cs-button__icon — 35×32px box, border-right thin solid #DCDCDC
     * .cs-post-navigation__button--next .cs-button__icon — border-left instead
     * svg path fill #0A1119
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name'  => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button__icon' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button__icon' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'icon_svg_size',
            'label' => __( 'SVG Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'icon_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'icon_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button__icon'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-button__icon svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'icon_separator_color',
            'label' => __( 'Separator Color', 'steelnova' ),
            'selectors' => [
                // prev: border-right
                '{{WRAPPER}} .cs-post-navigation__button--prev .cs-button__icon' => 'border-right-color: {{VALUE}};',
                // next: border-left
                '{{WRAPPER}} .cs-post-navigation__button--next .cs-button__icon' => 'border-left-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'icon_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button:hover .cs-button__icon'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-navigation__button:hover .cs-button__icon svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'icon_separator_color_hover',
            'label' => __( 'Separator Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button--prev:hover .cs-button__icon' => 'border-right-color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-navigation__button--next:hover .cs-button__icon' => 'border-left-color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'icon_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button__icon,
                 {{WRAPPER}} .cs-button__icon svg path' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Text Style Controls.
     *
     * .cs-button__text — button label, font Inter 14px 500, letter-spacing 0.7px, uppercase
     */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name'  => 'section_text_style',
            'label' => __( 'Text', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'text_typography',
            'selector' => '{{WRAPPER}} .cs-post-navigation__button .cs-button__text',
        ]);

        $this->_start_controls_tabs([ 'name' => 'text_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'text_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'text_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button .cs-button__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'text_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'text_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button:hover .cs-button__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'text_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation__button .cs-button__text' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Divider Style Controls.
     *
     * .cs-post-navigation .divider — flex-grow 1, bg #DCDCDC, separates prev/next buttons
     */
    protected function register_divider_style_controls() {
        $this->start_style_section([
            'name'  => 'section_divider_style',
            'label' => __( 'Divider', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'divider_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation .divider' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->color([
            'name'  => 'divider_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation .divider' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'divider_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-navigation .divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }
}
