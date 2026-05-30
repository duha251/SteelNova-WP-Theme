<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Tags extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-tags',
            'title'      => __( 'CS Tags', 'steelnova' ),
            'icon'       => 'eicon-filter',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'woocommerce', 'shop', 'product', 'product grid', 'product list', 'shop layout', 'grid layout', 'list layout', 'toggle layout', 'product archive', 'shop archive', 'product loop', 'product card', 'product item', 'product category', 'product categories', 'woocommerce category', 'shop filter', 'product filter', 'catalog', 'ecommerce', 'store', 'shop UI', 'product display' ],            'script'     => [],
            'style'      => []
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_style_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    } 

    /**
     * Register Layout Controls.
     */
    protected function register_layout_style_controls() {
        $this->start_layout_section([
            'name' => 'section_layout_style',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .cs-tags',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $post_types = [
                'post' => __('Post', 'steelnova'),
                'service' => __('Service', 'steelnova'),
                'project' => __('Project', 'steelnova'),
                'product' => __('Product', 'steelnova'),
        ];
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'post_type',
            'label' => __('Post Type', 'steelnova'),
            'options' => $post_types,
            'default' => 'post'
        ]);
        foreach( $post_types as $key => $value ) {
            $taxonomy = $key.'_tag';
            $this->select2([
                'name' => $key.'_tags',
                'label_block' => true,
                'label' => $value . __(' Tags', 'steelnova'),
                'options' => steelnova()->post_manager->get_cpt_tag_list( $taxonomy ),
                'multiple' => true,
                'condition' => [
                    'post_type' => $key,
                ]
            ]);
        }
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->group_typography([
            'name'     => 'link_typography',
            'selector' => '{{WRAPPER}} .cs-tags a',
        ]);
        $this->size([
            'name' => 'btn_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-tags a' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'btn_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tags a' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([
            'name' => 'btn_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'btn_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'btn_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tags a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background',
            'selector' => '{{WRAPPER}} .cs-tags a',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css',
            'selector' => '{{WRAPPER}} .cs-tags a',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'btn_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'btn_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tags a:hover, {{WRAPPER}} .cs-tags a[aria-current="page"]' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background_hover',
            'selector' => '{{WRAPPER}} .cs-tags a:hover, {{WRAPPER}} .cs-tags a[aria-current="page"]',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-tags a:hover, {{WRAPPER}} .cs-tags a[aria-current="page"]',
        ]);
        $this->time([
            'name' => 'btn_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-tags a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}