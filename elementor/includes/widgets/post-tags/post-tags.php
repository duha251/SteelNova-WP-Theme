<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Tags extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'     => 'steelnova-post-tags',
            'title'    => __( 'CS Post Tags', 'steelnova' ),
            'icon'     => 'eicon-tags',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'post tags', 'tags', 'taxonomy' ],
            'script'   => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Style Controls
        $this->register_wrapper_style_controls();
        $this->register_tag_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Layout Controls.
     *
     * Flex layout for the .cs-post-tags wrapper.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name'  => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->gaps([
            'name'  => 'tags_gap',
            'label' => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Wrapper Style Controls.
     *
     * .cs-post-tags — flex, gap 10px, flex-wrap wrap
     */
    protected function register_wrapper_style_controls() {
        $this->start_style_section([
            'name'  => 'section_wrapper_style',
            'label' => __( 'Wrapper', 'steelnova' ),
        ]);

        $this->group_background([
            'name'     => 'wrapper_background',
            'selector' => '{{WRAPPER}} .cs-post-tags',
        ]);
        $this->group_box_css([
            'name'     => 'wrapper_box_css',
            'selector' => '{{WRAPPER}} .cs-post-tags',
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Tag Link Style Controls.
     *
     * .cs-tags a / .cs-post-tags a — height 44px, padding-inline 23px,
     *   border-radius 6px, border thin solid #DCDCDC,
     *   font 12px 500 uppercase, letter-spacing 0.72px
     *   → hover: bg #FF5B1B, color rgba(255,255,255,0.8), border transparent
     */
    protected function register_tag_style_controls() {
        $this->start_style_section([
            'name'  => 'section_tag_style',
            'label' => __( 'Tag', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'tag_typography',
            'selector' => '{{WRAPPER}} .cs-post-tags a',
        ]);
        $this->size([
            'name'  => 'tag_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'tag_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'tag_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'tag_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'tag_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'tag_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'tag_border',
            'selector' => '{{WRAPPER}} .cs-post-tags a',
        ]);
        $this->dimensions([
            'name'  => 'tag_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'tag_box_shadow',
            'selector' => '{{WRAPPER}} .cs-post-tags a',
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'tag_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'tag_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'tag_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'tag_border_hover',
            'selector' => '{{WRAPPER}} .cs-post-tags a:hover',
        ]);
        $this->group_box_shadow([
            'name'     => 'tag_box_shadow_hover',
            'selector' => '{{WRAPPER}} .cs-post-tags a:hover',
        ]);
        $this->time([
            'name'  => 'tag_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-tags a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
