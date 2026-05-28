<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Steps_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-steps-carousel',
            'title'      => __( 'CS Steps Carousel', 'steelnova' ),
            'icon'       => 'eicon-post-info',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'logo', 'site logo', 'brand', 'branding', 'header logo', 'website logo', 'company logo', 'info', 'team', 'member', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper', 'steelnova-widget-steps-carousel']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_step_card_style_controls();
        $this->register_step_header_style_controls();
        $this->register_step_content_style_controls();
        $this->register_step_title_style_controls();
        $this->register_step_description_style_controls();
        // Settings Controls
        $this->register_display_settings_controls();
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'steelnova') 
        ]);
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->text([
            'name'    => 'title',
            'label'   => __('Title', 'steelnova'),
            'separator' => 'before',
            'default' => __('Your Title', 'steelnova'),
        ], $repeater);
        $this->textarea([
            'name'  => 'description',
            'label' => __('Description', 'steelnova'),
            'separator' => 'before',
            'rows'  => 10,
            'default' => __('Lorem ipsum dolor sit amet', 'steelnova')
        ], $repeater);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Step Card (.cs-steps-carousel .cs-step)
     * CSS: padding, border-radius, background-color
     */
    protected function register_step_card_style_controls() {
        $this->start_style_section([
            'name'  => 'section_step_card_style',
            'label' => __( 'Step Card', 'steelnova' ),
        ]);

        $this->dimensions([
            'name'      => 'step_padding',
            'label'     => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'step_card_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'step_card_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'step_card_bg',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step',
        ]);
        $this->group_box_css([
            'name'     => 'step_card_',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'step_card_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'step_card_bg_hover',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step:hover',
        ]);
        $this->group_box_css([
            'name'     => 'step_card_hover_',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step:hover',
        ]);
        $this->time([
            'name'      => 'step_card_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Step Header (.cs-steps-carousel .cs-step__header)
     * CSS: gap, margin-bottom, max-width
     * Index (.cs-step__index): typography, color
     * Icon (.cs-step__icon): color
     */
    protected function register_step_header_style_controls() {
        $this->start_style_section([
            'name'  => 'section_step_header_style',
            'label' => __( 'Header (Index & Icon)', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'step_header_gap',
            'label'     => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__header' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'step_header_margin_bottom',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Index
        $this->heading([
            'name'  => 'step_index_heading',
            'label' => __( 'Index', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'step_index_typography',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step__index',
        ]);

        $this->color([
            'name'      => 'step_index_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__index' => 'color: {{VALUE}};',
            ],
        ]);

        // Icon
        $this->heading([
            'name'  => 'step_icon_heading',
            'label' => __( 'Icon', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'step_icon_size',
            'label'     => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-steps-carousel .cs-step__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->color([
            'name'      => 'step_icon_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__icon' => 'color: {{VALUE}};',
            ],
        ]);

        $this->color([
            'name'      => 'step_icon_color_hover',
            'label'     => __( 'Color (Hover)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step:hover .cs-step__icon' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Step Content Box (.cs-steps-carousel .cs-step__content)
     * CSS: padding, border-top, border-radius, background-color
     */
    protected function register_step_content_style_controls() {
        $this->start_style_section([
            'name'  => 'section_step_content_style',
            'label' => __( 'Content Box', 'steelnova' ),
        ]);

        $this->_start_controls_tabs([ 'name' => 'step_content_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'step_content_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'step_content_bg',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step__content',
        ]);
        $this->group_box_css([
            'name'     => 'step_content_',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step__content',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'step_content_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'step_content_bg_hover',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step:hover .cs-step__content',
        ]);
        $this->group_box_css([
            'name'     => 'step_content_hover_',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step:hover .cs-step__content',
        ]);
        $this->time([
            'name'      => 'step_content_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__content' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Step Title (.cs-steps-carousel .cs-step__title)
     * CSS: color, margin-bottom, typography
     */
    protected function register_step_title_style_controls() {
        $this->start_style_section([
            'name'  => 'section_step_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'step_title_typography',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step__title',
        ]);

        $this->size([
            'name'      => 'step_title_margin_bottom',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'step_title_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'step_title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'step_title_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'step_title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'step_title_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step:hover .cs-step__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Step Description (.cs-steps-carousel .cs-step__description)
     * CSS: font-family, font-size, line-height, color
     */
    protected function register_step_description_style_controls() {
        $this->start_style_section([
            'name'  => 'section_step_description_style',
            'label' => __( 'Description', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'step_desc_typography',
            'selector' => '{{WRAPPER}} .cs-steps-carousel .cs-step__description',
        ]);

        $this->_start_controls_tabs([ 'name' => 'step_desc_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'step_desc_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'step_desc_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step__description' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'step_desc_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'step_desc_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-steps-carousel .cs-step:hover .cs-step__description' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Grid Source Content Controls
     */
    protected function register_display_settings_controls() {        
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
            'options' => Static_Options::title_html_tag_options(),
            'separator' => 'before',
            'default' => 'div'
        ]);
        $this->end_controls_section();
    }
}