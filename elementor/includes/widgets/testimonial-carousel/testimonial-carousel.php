<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Testimonial_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-testimonial-carousel',
            'title'      => __( 'CS Testimonial Carousel', 'steelnova' ),
            'icon'       => 'eicon-testimonial-carousel',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'testimonial', 'quote', 'review', 'client', 'feedback', 'comment', 'text', 'typography', 'carousel', 'swiper', 'slider' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper', 'steelnova-widget-testimonial']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_main_content_controls();
        $this->register_author_content_controls();
        $this->register_rating_content_controls();
        $this->register_icon_content_controls();
        $this->register_images_content_controls();
        // Style Controls
        $this->register_card_style_controls();
        $this->register_icon_style_controls();
        $this->register_rating_style_controls();
        $this->register_content_style_controls();
        $this->register_divider_style_controls();
        $this->register_author_style_controls();
        $this->register_image_style_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
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
                    'title' => esc_attr__( 'Testimonial 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Testimonial 2', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-1.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Testimonial 3', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-3.webp'),
                ],
                '4' => [
                    'title' => esc_attr__( 'Testimonial 4', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/testimonial-4.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_main_content_controls() {
        $this->start_content_section([
            'name' => 'section_main_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->textarea([
            'name'  => 'content',
            'label' => __('Content', 'steelnova'),
            'rows' => 10,
            'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc sit amet risus fermentum pharetra non in elit.', 'steelnova'),
        ], $repeater);
        $this->repeater([
            'name' => 'content_items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Rating Content Controls.
     */
    protected function register_rating_content_controls() {
        $this->start_content_section([
            'name' => 'section_rating_content',
            'label' => __( 'Rating', 'steelnova' ),
        ]);
        $this->text([
            'name' => 'rating_label',
            'label' => __('Label', 'steelnova'),
            'default' => __('Rating', 'steelnova'),
            'condition' => [
                'layout' => ['1', '3', '4']
            ]
        ]);
        $repeater = new \Elementor\Repeater();
        $this->number([
            'name'  => 'rating',
            'label' => __('Rating', 'steelnova'),
            'min' => 1,
            'max' => 5,
            'default' => 5,
        ], $repeater);
        $this->repeater([
            'name' => 'rating_items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Icon Controls.
     */
    protected function register_icon_content_controls() {
        $this->start_content_section([
            'name' => 'section_icon_content',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ], $repeater);
        $this->repeater([
            'name' => 'icon_items',
            'label' => __('Own Icons', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Icon Controls.
     */
    protected function register_images_content_controls() {
        $this->start_content_section([
            'name' => 'section_image_content',
            'label' => __( 'Image', 'steelnova' ),
            'condition' => [
                'layout' => ['2', '4']
            ]
        ]);
        $this->switcher([
            'name' => 'show_image',
            'label' => __('Show Image', 'steelnova'),
            'default' => 'yes'
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
            'condition' => [
                'show_image' => 'yes'
            ]
        ]);
        $repeater = new \Elementor\Repeater();
        $this->media([
            'name'  => 'img',
            'label' => __('Image', 'steelnova'),
            'default' => [
                'id' => 0
            ]
        ], $repeater);
        $this->repeater([
            'name' => 'img_items',
            'label' => __('Images', 'steelnova'),
            'fields' => $repeater->get_controls(),
            'condition' => [
                'show_image' => 'yes'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Author Content Controls.
     */
    protected function register_author_content_controls() {
        $this->start_content_section([
            'name' => 'section_author_content',
            'label' => __( 'Author', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->media([
            'name' => 'author_image',
            'label' => __('Image', 'steelnova'),
            'default' => [
                'id' => 0
            ]
        ], $repeater);
        $this->text([
            'name' => 'author_name',
            'label' => __('Name', 'steelnova'),
            'default' => __('John Doe', 'steelnova'),
        ], $repeater);
        $this->text([
            'name' => 'author_title',
            'label' => __('Title', 'steelnova'),
            'default' => __('Web Developer', 'steelnova'),
        ], $repeater);

        $this->repeater([
            'name' => 'author_items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Card Style Controls.
     *
     * Layout 1 & 3: selector is .cs-testimonial (the card itself)
     * Layout 2    : the dark card wrapper is .cs-testimonial-carousel__content (swiper)
     * Layout 4    : card is .cs-testimonial, content pane is .cs-testimonial__holder
     *
     * Hover state targets .cs-testimonial:hover for all layouts.
     */
    protected function register_card_style_controls() {
        $this->start_style_section([
            'name'  => 'section_card_style',
            'label' => __( 'Card', 'steelnova' ),
        ]);

        $this->_start_controls_tabs([ 'name' => 'card_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'card_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);

        // Layout 1 / 3 / 4 — card background via ::before pseudo-element
        $this->color([
            'name'  => 'card_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                // Layout 1 & 4 use ::before for the white fill
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="1"] .cs-testimonial::before,
                 {{WRAPPER}} .cs-testimonial-carousel[data-layout="4"] .cs-testimonial::before' => 'background-color: {{VALUE}};',
                 '{{WRAPPER}} .cs-testimonial-carousel[data-layout="1"] .cs-testimonial .mask' => 'color: {{VALUE}};',
                // Layout 3 — plain background on the card
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="3"] .cs-testimonial' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '1', '3', '4' ] ],
        ]);

        // Layout 2 — dark content pane background
        $this->color([
            'name'  => 'card_bg_color_l2',
            'label' => __( 'Content Pane Background', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="2"] > .swiper.cs-testimonial-carousel__content' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);

        $this->group_border([
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .cs-testimonial',
        ]);
        $this->dimensions([
            'name'  => 'card_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .cs-testimonial',
        ]);
        $this->dimensions([
            'name'  => 'card_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                // Layout 1 / 3 — padding on .cs-testimonial
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="1"] .cs-testimonial,
                 {{WRAPPER}} .cs-testimonial-carousel[data-layout="3"] .cs-testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                // Layout 4 — padding lives on .cs-testimonial__holder
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="4"] .cs-testimonial__holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                // Layout 2 — padding on .cs-testimonial__main
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="2"] .cs-testimonial__main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'card_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'card_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="1"] .cs-testimonial:hover::before,
                 {{WRAPPER}} .cs-testimonial-carousel[data-layout="4"] .cs-testimonial:hover::before' => 'background-color: {{VALUE}};',
                 '{{WRAPPER}} .cs-testimonial-carousel[data-layout="1"] .cs-testimonial:hover .mask' => 'color: {{VALUE}};',
                 
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="3"] .cs-testimonial:hover' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '1', '3', '4' ] ],
        ]);
        $this->group_border([
            'name'     => 'card_border_hover',
            'selector' => '{{WRAPPER}} .cs-testimonial:hover',
        ]);
        $this->group_box_shadow([
            'name'     => 'card_box_shadow_hover',
            'selector' => '{{WRAPPER}} .cs-testimonial:hover',
        ]);
        $this->time([
            'name'  => 'card_transition_duration',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls.
     *
     * Layout 1 & 4 : icon box at top-right corner, dark bg, orange color, 66px
     * Layout 2      : icon inline in header, white color, 57px, no bg
     * Layout 3      : icon at bottom-right, decorative, 48px svg, no bg
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name'  => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'icon_box_size',
            'label' => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                // Layout 1 & 4 use --cs-box-size custom property
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="1"] .cs-testimonial__icon,
                 {{WRAPPER}} .cs-testimonial-carousel[data-layout="4"] .cs-testimonial__icon' => '--cs-box-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                // Layout 2
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="2"] .cs-testimonial__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                // Layout 3 — svg width only
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="3"] .cs-testimonial__icon svg' => 'width: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .cs-testimonial__icon'        => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-testimonial__icon svg path' => 'fill: {{VALUE}};',
                '{{WRAPPER}} .cs-testimonial__icon i'        => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'icon_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__icon' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '1', '4' ] ],
        ]);
        $this->group_border([
            'name'     => 'icon_border',
            'selector' => '{{WRAPPER}} .cs-testimonial__icon',
        ]);
        $this->dimensions([
            'name'  => 'icon_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__icon'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__icon svg path' => 'fill: {{VALUE}};',
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__icon i'        => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'icon_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__icon' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '1', '4' ] ],
        ]);
        $this->time([
            'name'  => 'icon_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'icon_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Rating Style Controls.
     *
     * Layout 1 & 4 : rating-label + stars inline, label uses heading font
     * Layout 2      : rating is a pill (border-radius 100px), orange bg, white text, no label
     * Layout 3      : rating-label + stars, label heading color
     */
    protected function register_rating_style_controls() {
        $this->start_style_section([
            'name'  => 'section_rating_style',
            'label' => __( 'Rating', 'steelnova' ),
        ]);

        // ── Rating wrapper ───────────────────────────────────────────────────
        $this->heading([
            'name'  => 'rating_wrapper_heading',
            'label' => __( 'Wrapper', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->color([
            'name'  => 'rating_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__rating' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);
        $this->dimensions([
            'name'  => 'rating_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);
        $this->dimensions([
            'name'  => 'rating_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // ── Rating label (Layout 1, 3, 4) ────────────────────────────────────
        $this->heading([
            'name'  => 'rating_label_heading',
            'label' => __( 'Label', 'steelnova' ),
        ]);
        $this->group_typography([
            'name'     => 'rating_label_typography',
            'selector' => '{{WRAPPER}} .cs-testimonial__rating-label',
        ]);
        $this->_start_controls_tabs([ 'name' => 'rating_label_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'rating_label_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'rating_label_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__rating-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'rating_label_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'rating_label_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__rating-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        // ── Stars ─────────────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'stars_heading',
            'label' => __( 'Stars', 'steelnova' ),
        ]);
        $this->size([
            'name'  => 'star_size',
            'label' => __( 'Star Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-stars svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->gaps([
            'name'  => 'stars_gap',
            'label' => __( 'Stars Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-stars' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([ 'name' => 'stars_color_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'stars_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'star_color_fill',
            'label' => __( 'Filled Star Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-stars svg.fill path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'star_color_empty',
            'label' => __( 'Empty Star Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-stars svg.normal path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'stars_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'star_color_fill_hover',
            'label' => __( 'Filled Star Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-stars svg.fill path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'star_color_empty_hover',
            'label' => __( 'Empty Star Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-stars svg.normal path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register Content Style Controls.
     *
     * Layout 2 : white text on dark bg
     * Layout 4 : #4B535D text color
     * Layout 1 & 3 : default text color
     */
    protected function register_content_style_controls() {
        $this->start_style_section([
            'name'  => 'section_content_style',
            'label' => __( 'Content', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'content_typography',
            'selector' => '{{WRAPPER}} .cs-testimonial__content',
        ]);

        $this->_start_controls_tabs([ 'name' => 'content_color_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'content_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'content_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__content' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'content_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'content_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__content' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'content_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Divider Style Controls.
     *
     * Layout 1 & 4 : #DCDCDC, margin-top: auto (pushes to bottom), margin-bottom: 18/24px
     * Layout 2      : #4B535D (dark theme)
     * Layout 3      : margin-block: 30px 25px (no explicit color in CSS)
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
                '{{WRAPPER}} .cs-testimonial .divider' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'divider_color_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'divider_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'divider_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial .divider' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'divider_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'divider_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .divider' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'divider_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial .divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Author Style Controls.
     *
     * All layouts share .cs-testimonial__author, __author-image, __author-name, __author-title.
     * Layout 2      : white text, semi-transparent title bg, author section has padding (not margin)
     * Layout 1 & 4  : heading color name, badge-style title (#FAF5ED bg)
     * Layout 3      : heading color name, plain title text
     */
    protected function register_author_style_controls() {
        $this->start_style_section([
            'name'  => 'section_author_style',
            'label' => __( 'Author', 'steelnova' ),
        ]);

        // ── Avatar ────────────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'author_image_heading',
            'label' => __( 'Avatar', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->size([
            'name'  => 'author_image_size',
            'label' => __( 'Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author-image' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->group_box_css([
            'name'     => 'author_image_box_css',
            'selector' => '{{WRAPPER}} .cs-testimonial__author-image',
        ]);

        // ── Name ──────────────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'author_name_heading',
            'label' => __( 'Name', 'steelnova' ),
        ]);
        $this->group_typography([
            'name'     => 'author_name_typography',
            'selector' => '{{WRAPPER}} .cs-testimonial__author-name',
        ]);
        $this->_start_controls_tabs([ 'name' => 'author_name_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'author_name_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'author_name_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author-name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'author_name_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'author_name_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__author-name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        // ── Title / Position ──────────────────────────────────────────────────
        $this->heading([
            'name'  => 'author_title_heading',
            'label' => __( 'Title / Position', 'steelnova' ),
        ]);
        $this->group_typography([
            'name'     => 'author_title_typography',
            'selector' => '{{WRAPPER}} .cs-testimonial__author-title',
        ]);
        $this->_start_controls_tabs([ 'name' => 'author_title_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'author_title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'author_title_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author-title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'author_title_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author-title' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'author_title_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'author_title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'author_title_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__author-title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'author_title_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__author-title' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        // ── Wrapper ───────────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'author_wrapper_heading',
            'label' => __( 'Wrapper', 'steelnova' ),
        ]);
        $this->gaps([
            'name'  => 'author_gap',
            'label' => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        // Layout 2 uses padding on the author wrapper; others use margin
        $this->dimensions([
            'name'  => 'author_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="2"] .cs-testimonial__author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);
        $this->dimensions([
            'name'  => 'author_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Image Style Controls (Layout 2 & 4).
     *
     * Layout 2 : .cs-testimonial-carousel__images (left swiper pane), img height: 100%
     * Layout 4 : .cs-testimonial__thumbnail (flex-basis 48.5%), img fills 100% w/h
     */
    protected function register_image_style_controls() {
        $this->start_style_section([
            'name'      => 'section_image_style',
            'label'     => __( 'Image', 'steelnova' ),
            'condition' => [ 'layout' => [ '2', '4' ] ],
        ]);

        // Layout 2 — image pane flex basis
        $this->size([
            'name'  => 'img_pane_flex_basis_l2',
            'label' => __( 'Pane Width (flex-basis)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="2"] > .swiper.cs-testimonial-carousel__images' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => [ '2' ] ],
        ]);

        // Layout 4 — thumbnail flex basis
        $this->size([
            'name'  => 'img_thumbnail_flex_basis_l4',
            'label' => __( 'Thumbnail Width (flex-basis)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial-carousel[data-layout="4"] .cs-testimonial__thumbnail' => 'flex-basis: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => [ '4' ] ],
        ]);

        $this->group_css_filter([
            'name'     => 'testimonial_image_css_filter',
            'selector' => '{{WRAPPER}} .cs-testimonial__image',
        ]);

        $this->_start_controls_tabs([ 'name' => 'image_hover_tabs' ]);
        $this->_start_controls_tab([
            'name'  => 'image_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_box_css([
            'name'     => 'testimonial_image_box_css',
            'selector' => '{{WRAPPER}} .cs-testimonial__image',
        ]);
        $this->end_controls_tab();
        $this->_start_controls_tab([
            'name'  => 'image_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_css_filter([
            'name'     => 'testimonial_image_css_filter_hover',
            'selector' => '{{WRAPPER}} .cs-testimonial:hover .cs-testimonial__image',
        ]);
        $this->time([
            'name'  => 'image_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-testimonial__image' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

}