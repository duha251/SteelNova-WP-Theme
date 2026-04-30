<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Categories extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-categories',
            'title'      => __( 'CS Categories', 'steelnova' ),
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
        // $this->register_layout_controls();
        // $this->register_layout_style_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        // $this->register_icon_style_controls();
        // $this->register_title_style_controls();
        // $this->register_desc_style_controls();
    } 

    // protected function register_layout_controls() {
    //     $this->start_layout_section([ 
    //         'name' => 'section_layout', 
    //         'label' => __('Layout', 'steelnova')
    //     ]);
    //     $this->visual_choice([
    //         'name' => 'layout',
    //         'label' => __('Layout', 'steelnova'),
    //         'columns' => '1',
    //         'options' => [
    //             '1' => [
    //                 'title' => esc_attr__( 'Post Meta 1', 'steelnova' ),
    //                 'image' => content_url('/uploads/widget-layout/post-meta-1.webp'),
    //             ],
    //         ],
    //         'default' => '1',
    //     ]);
    //     $this->end_controls_section();
    // }

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
            'selector' => '{{WRAPPER}} .cs-post-meta',
        ]);
        $this->heading([
            'name' => 'item_layout_heading',
            'label' => __('Item Layout', 'steelnova'),
        ]);
        $this->group_flex_css([
            'name' => 'item_',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item',
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
        $this->switcher([
            'name' => 'show_divider',
            'label' => __('Show Divider', 'steelnova'),
            'default' => 'yes',
        ]);
        $this->select([
            'name' => 'post_type',
            'label' => __('Post Type', 'steelnova'),
            'options' => $post_types,
            'default' => 'post'
        ]);
        foreach( $post_types as $key => $value ) {
            if( $key === 'post' ) {
                $taxonomy = 'category';
            }elseif( $key === 'product' ) {
                $taxonomy = 'product_cat';
            }else {
                $taxonomy = $key.'_category';
            }
            $this->select2([
                'name' => $key.'_categories',
                'label_block' => true,
                'label' => $value . __(' Categories', 'steelnova'),
                'options' => steelnova()->post_manager->get_cpt_category_list( $taxonomy ),
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
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([
            'name' => 'icon_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'icon_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'icon_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta:hover .cs-post-meta__item-icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background_hover',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Label Style Controls
     */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __( 'Label', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-label',
        ]);

        $this->_start_controls_tabs([
            'name' => 'title_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'title_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'title_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item:hover .cs-post-meta__item-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-label' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Description Style Controls
     */
    protected function register_desc_style_controls() {
        $this->start_style_section([
            'name' => 'section_desc_style',
            'label' => __( 'Description', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__text',
        ]);

        $this->_start_controls_tabs([
            'name' => 'desc_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'desc_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'desc_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'desc_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'desc_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item:hover .cs-post-meta__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'desc_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__text' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}