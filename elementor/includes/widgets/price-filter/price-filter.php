<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Price_Filter extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'     => 'steelnova-price-filter',
            'title'    => __( 'CS Price Filter', 'steelnova' ),
            'icon'     => 'eicon-filter',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'price filter', 'price range', 'price slider', 'woocommerce', 'shop filter' ],
            'script'   => ['steelnova-price-filter'],
            'style'    => ['steelnova-widget-price-filter'],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_slider_style_controls();
        $this->register_button_style_controls();
        $this->register_price_style_controls();
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
            'label' => __( 'Price Filter', 'steelnova' ),
        ]);
        $this->text([
            'name'    => 'button_label',
            'label'   => __( 'Button Label', 'steelnova' ),
            'default' => __( 'FILTER', 'steelnova' ),
        ]);
        $this->text([
            'name'    => 'price_label',
            'label'   => __( 'Price Label', 'steelnova' ),
            'default' => __( 'Price:', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Slider Style Controls.
     *
     * Uses CSS custom properties on .cs-price-filter:
     *   --track-color  : #dcdcdc  (track background)
     *   --thumb-color  : #07100d  (thumb handle)
     *   --accent-color : #ff5b1b  (active progress fill)
     *
     * .cs-price-filter__range     — container, height 14px, margin-bottom 28px
     * .cs-price-filter__track     — full-width bar, height 3px
     * .cs-price-filter__progress  — active range fill
     * __input thumb               — 11px circle
     */
    protected function register_slider_style_controls() {
        $this->start_style_section([
            'name'  => 'section_slider_style',
            'label' => __( 'Slider', 'steelnova' ),
        ]);

        // ── CSS variable colours ─────────────────────────────────────────────
        $this->heading([
            'name'      => 'slider_colors_heading',
            'label'     => __( 'Colors', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->color([
            'name'  => 'track_color',
            'label' => __( 'Track Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter' => '--track-color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'accent_color',
            'label' => __( 'Active Range Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter' => '--accent-color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'thumb_color',
            'label' => __( 'Thumb Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter' => '--thumb-color: {{VALUE}};',
            ],
        ]);

        // ── Track dimensions ─────────────────────────────────────────────────
        $this->heading([
            'name'  => 'slider_track_heading',
            'label' => __( 'Track', 'steelnova' ),
        ]);
        $this->size([
            'name'  => 'track_height',
            'label' => __( 'Track Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__track,
                 {{WRAPPER}} .cs-price-filter__progress' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'track_border_radius',
            'label' => __( 'Track Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__track,
                 {{WRAPPER}} .cs-price-filter__progress' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // ── Thumb dimensions ─────────────────────────────────────────────────
        $this->heading([
            'name'  => 'slider_thumb_heading',
            'label' => __( 'Thumb', 'steelnova' ),
        ]);
        $this->size([
            'name'  => 'thumb_size',
            'label' => __( 'Thumb Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__input::-webkit-slider-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-price-filter__input::-moz-range-thumb'     => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'thumb_border_radius',
            'label' => __( 'Thumb Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__input::-webkit-slider-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .cs-price-filter__input::-moz-range-thumb'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // ── Range container spacing ──────────────────────────────────────────
        $this->heading([
            'name'  => 'slider_spacing_heading',
            'label' => __( 'Spacing', 'steelnova' ),
        ]);
        $this->size([
            'name'  => 'range_height',
            'label' => __( 'Range Container Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__range' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'range_spacing',
            'label' => __( 'Range Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__range' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Button Style Controls.
     *
     * .cs-price-filter__button — height 27px, bg #07100d, white,
     *   font "Public Sans" 14px 600, padding-inline 22px
     */
    protected function register_button_style_controls() {
        $this->start_style_section([
            'name'  => 'section_button_style',
            'label' => __( 'Button', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'button_typography',
            'selector' => '{{WRAPPER}} .cs-price-filter__button',
        ]);
        $this->size([
            'name'  => 'button_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__button' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'button_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                '{{WRAPPER}} .cs-price-filter__button' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'button_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__button' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'button_border',
            'selector' => '{{WRAPPER}} .cs-price-filter__button',
        ]);
        $this->dimensions([
            'name'  => 'button_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'button_box_shadow',
            'selector' => '{{WRAPPER}} .cs-price-filter__button',
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
                '{{WRAPPER}} .cs-price-filter__button:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'button_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__button:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'button_border_hover',
            'selector' => '{{WRAPPER}} .cs-price-filter__button:hover',
        ]);
        $this->group_box_shadow([
            'name'     => 'button_box_shadow_hover',
            'selector' => '{{WRAPPER}} .cs-price-filter__button:hover',
        ]);
        $this->time([
            'name'  => 'button_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__button' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Price Display Style Controls.
     *
     * .cs-price-filter__bottom  — flex space-between, gap 24px
     * .cs-price-filter__price   — price text, line-height 1.625
     * .cs-price-filter__price-min / __price-max — individual price values
     */
    protected function register_price_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_style',
            'label' => __( 'Price Display', 'steelnova' ),
        ]);

        // ── Bottom row layout ────────────────────────────────────────────────
        $this->heading([
            'name'      => 'bottom_heading',
            'label'     => __( 'Bottom Row', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->gaps([
            'name'  => 'bottom_gap',
            'label' => __( 'Gap (button ↔ price)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__bottom' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);

        // ── Price text ───────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'price_text_heading',
            'label' => __( 'Price Text', 'steelnova' ),
        ]);
        $this->group_typography([
            'name'     => 'price_typography',
            'selector' => '{{WRAPPER}} .cs-price-filter__price',
        ]);

        $this->_start_controls_tabs([ 'name' => 'price_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'price_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'price_color',
            'label' => __( 'Label Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__price' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'price_value_color',
            'label' => __( 'Value Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter__price-min,
                 {{WRAPPER}} .cs-price-filter__price-max' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'price_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'price_color_hover',
            'label' => __( 'Label Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter:hover .cs-price-filter__price' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'price_value_color_hover',
            'label' => __( 'Value Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-filter:hover .cs-price-filter__price-min,
                 {{WRAPPER}} .cs-price-filter:hover .cs-price-filter__price-max' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
