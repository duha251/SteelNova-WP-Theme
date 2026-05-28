<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Price_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'  => 'steelnova-price-carousel',
            'title' => __( 'CS Price Carousel', 'steelnova' ),
            'icon'  => 'eicon-carousel',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'price carousel', 'price slider', 'product carousel', 'shop carousel', 'price display', 'price comparison', 'price showcase' ],
            'script' => ['steelnova-carousel'],
            'style'  => ['swiper', 'steelnova-swiper', 'steelnova-widget-price']
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
        $this->register_entrance_animation_controls();
        // Style Controls
        $this->register_price_card_style_controls();
        $this->register_box_inner_style_controls();
        $this->register_price_icon_style_controls();
        $this->register_price_title_style_controls();
        $this->register_price_amount_style_controls();
        $this->register_price_features_style_controls();
        $this->register_price_button_style_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    } 

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
                    'title' => esc_attr__( 'Price 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/price-1.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    
        /**
     * Register Box Style Controls
     */
    protected function register_box_inner_style_controls() {
        $this->start_style_section([
            'name' => 'section_box_inner_style',
            'label' => __( 'Box Inner', 'steelnova' ),
        ]);
        $this->_start_controls_tabs([
            'name' => 'box_inner_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'box_inner_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'box_inner_background',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__inner',
        ]);
        $this->group_box_css([
            'name' => 'box_inner_css',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__inner',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'box_inner_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'box_inner_background_hover',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__inner:not(.box-gradient):hover, 
                            {{WRAPPER}} .cs-price-carousel .price__inner.box-gradient:before'
        ]);
        $this->group_box_css([
            'name' => 'box_inner_css_hover',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__inner:hover',
        ]);
        $this->time([
            'name' => 'box_inner_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__inner' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
        /**
     * Price Card Outer (.cs-price-carousel .price)
     * CSS: border-radius, border, background-color, backdrop-filter, padding
     */
    protected function register_price_card_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_card_style',
            'label' => __( 'Card Outer', 'steelnova' ),
        ]);

        $this->group_background([
            'name'     => 'price_card_background',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price',
        ]);

        $this->group_box_css([
            'name'     => 'price_card_',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price',
        ]);

        $this->end_controls_section();
    }

    /**
     * Price Icon (.cs-price-carousel .price__icon--main)
     * CSS: --cs-box-size, border-radius, color, background-color, margin-bottom
     */
    protected function register_price_icon_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'icon_box_size',
            'label'     => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__icon--main' => '--cs-box-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'icon_border_radius',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__icon--main' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'icon_margin_bottom',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__icon--main' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->color([
            'name'      => 'icon_color',
            'label'     => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__icon--main' => 'color: {{VALUE}};',
            ],
        ]);

        $this->color([
            'name'      => 'icon_bg_color',
            'label'     => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__icon--main' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Price Title (.cs-price-carousel .price__title)
     * CSS: margin-bottom, color (changes on hover/active)
     */
    protected function register_price_title_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'price_title_typography',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__title',
        ]);

        $this->size([
            'name'      => 'price_title_margin_bottom',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'price_title_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'price_title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'price_title_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'price_title_tab_hover',
            'label' => __( 'Hover / Active', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'price_title_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__inner:hover .price__title,
                 {{WRAPPER}} .cs-price-carousel .price__inner.is-active .price__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Price Amount (.cs-price-carousel .price__amount + .price__amount-suffix)
     * CSS: font-size, font-weight, letter-spacing, margin-top, color
     */
    protected function register_price_amount_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_amount_style',
            'label' => __( 'Amount', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'price_amount_typography',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__amount',
        ]);

        $this->group_typography([
            'name'     => 'price_amount_suffix_typography',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__amount-suffix',
        ]);

        $this->size([
            'name'      => 'price_amount_margin_top',
            'label'     => __( 'Margin Top', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__amount' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'price_amount_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'price_amount_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'price_amount_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__amount' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'price_amount_tab_hover',
            'label' => __( 'Hover / Active', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'price_amount_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__inner:hover .price__amount,
                 {{WRAPPER}} .cs-price-carousel .price__inner.is-active .price__amount' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Price Features (.cs-price-carousel .price__features li)
     * CSS: gap, font-size, color, icon color
     */
    protected function register_price_features_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_features_style',
            'label' => __( 'Features', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'features_typography',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price__features li',
        ]);

        $this->size([
            'name'      => 'features_gap',
            'label'     => __( 'Gap Between Items', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__features' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'features_icon_gap',
            'label'     => __( 'Icon Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__features li' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'features_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'features_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'features_color',
            'label'     => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__features li' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'features_icon_color',
            'label'     => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__features li > svg' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'features_tab_hover',
            'label' => __( 'Hover / Active', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'features_color_hover',
            'label'     => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__inner:hover .price__features li,
                 {{WRAPPER}} .cs-price-carousel .price__inner.is-active .price__features li' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Price Button (.cs-price-carousel .price .cs-button)
     * CSS: margin-top, background-color, color, ::before gradient
     */
    protected function register_price_button_style_controls() {
        $this->start_style_section([
            'name'  => 'section_price_button_style',
            'label' => __( 'Button', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'price_btn_typography',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price .cs-button',
        ]);

        $this->size([
            'name'      => 'price_btn_margin_top',
            'label'     => __( 'Margin Top', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price .cs-button' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->group_box_css([
            'name'     => 'price_btn_',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price .cs-button',
        ]);

        $this->_start_controls_tabs([ 'name' => 'price_btn_color_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'price_btn_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'price_btn_color',
            'label'     => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price .cs-button' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'price_btn_bg_color',
            'label'     => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price .cs-button' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'price_btn_tab_hover',
            'label' => __( 'Hover / Active', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'price_btn_color_hover',
            'label'     => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price__inner:hover .cs-button,
                 {{WRAPPER}} .cs-price-carousel .price__inner.is-active .cs-button' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name'     => 'price_btn_before_bg',
            'selector' => '{{WRAPPER}} .cs-price-carousel .price .cs-button:before',
        ]);
        $this->time([
            'name'      => 'price_btn_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-price-carousel .price .cs-button' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->number([
            'name' => 'item_active',
            'label' => __('Item Active', 'steelnova'),
            'min' => 1,
            'default' => 1,
        ]);
        $this->text([
            'name' => 'btn_text',
            'label' => __( 'Button Text', 'steelnova' ),
            'default' => __( 'Get Started With Plan', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title Tag HTML', 'steelnova'),
            'options' => Static_Options::title_html_tag_options( true ),
            'default' => ''
        ]);
        $repeater = new \Elementor\Repeater();
        $this->icons([
            'name' => 'icon',
            'label' => __( 'Icon', 'steelnova' ),
        ], $repeater);
        $this->text([
            'name' => 'title',
            'label' => __( 'Title', 'steelnova' ),
        ], $repeater);
        $this->textarea([
            'name' => 'desc',
            'label' => __( 'Description', 'steelnova' ),
            'rows' => 5,
        ], $repeater);
        $this->text([
            'name' => 'price_amount',
            'label' => __( 'Price Amount', 'steelnova' ),
            'separator' => 'before',
        ], $repeater);
        $this->text([
            'name' => 'price_prefix',
            'label' => __( 'Price Prefix', 'steelnova' ),
        ], $repeater);
        $this->text([
            'name' => 'price_suffix',
            'label' => __( 'Price Suffix', 'steelnova' ),
        ], $repeater);
        $this->textarea([
            'name' => 'features',
            'label' => __( 'Features', 'steelnova' ),
            'separator' => 'before',
            'rows' => 10,
            'description' => __( 'Enter each feature on a separate |.', 'steelnova' ),
        ], $repeater);
        $this->url([
            'name' => 'link',
            'label' => __( 'Link', 'steelnova' ),
        ], $repeater);

        $this->repeater([
            'name' => 'items',
            'label' => __( 'Items', 'steelnova' ),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }
}