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
        $this->register_box_inner_style_controls();
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