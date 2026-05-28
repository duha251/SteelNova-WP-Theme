<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Show_Case extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-show-case',
            'title'      => __( 'CS Show Case', 'steelnova' ),
            'icon'       => 'eicon-show-case',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'logo', 'site logo', 'brand', 'branding', 'header logo', 'website logo', 'company logo', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Site Logo', 'steelnova' ),
        ]);
        // $this->switcher([
        //     'name' => 'is_comming_soon',
        //     'label' => __('Is Comming Soon', 'steelnova'),
        //     'default' => ''
        // ]);
        $this->text([
            'name' => 'title',
            'label' => __('Title', 'steelnova'),
        ]); 
        $this->media([
            'name' => 'image',
            'default' => [
                'id' => 0
            ]
        ]);       
        $repeater = new \Elementor\Repeater();
        $this->text([
            'name' => 'text',
            'label' => __('Button Text', 'steelnova'),
            'default' => __('Click here', 'steelnova')
        ], $repeater); 
        $this->url([
            'name' => 'link',
            'label' => __('Button Link', 'steelnova'),
            'default' => [
                'url' => '#'
            ]
        ], $repeater); 
        $this->_start_controls_tabs([
            'name' => 'btn_tabs',
        ], $repeater);
        $this->_start_controls_tab([
            'name' => 'btn_tab_normal',
            'label' => __('Normal', 'steelnova')
        ], $repeater);
        $this->color([
            'name' => 'btn_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};'
            ]
        ], $repeater);
        $this->group_background([
            'name' => 'btn_bg',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}'
        ], $repeater);
        $this->group_box_css([
            'name' => 'btn',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}'
        ], $repeater);
        $repeater->end_controls_tab();
        $this->_start_controls_tab([
            'name' => 'btn_tab_hover',
            'label' => __('Hover', 'steelnova')
        ], $repeater);
        $this->color([
            'name' => 'btn_color_hover',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};'
            ]
        ], $repeater);
        $this->group_background([
            'name' => 'btn_bg_hover',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover'
        ], $repeater );
        $this->group_box_css([
            'name' => 'btn_hover',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover'
        ], $repeater);
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->repeater([
            'name' => 'btns',
            'label' => __('Buttons', 'steelnova'),
            'fields' => $repeater->get_controls(), 
        ]);
        $this->end_controls_section();
    }
}