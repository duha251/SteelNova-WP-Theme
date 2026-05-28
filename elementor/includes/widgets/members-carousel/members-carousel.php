<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;


if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Members_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-members-carousel',
            'title'      => __( 'CS Members Carousel', 'steelnova' ),
            'icon'       => 'eicon-posts-carousel',
            'keywords'   => [ 'members', 'member', 'features', 'offerings' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper','steelnova-widget-member']
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
        $this->register_member_item_style_controls();
        $this->register_member_thumbnail_style_controls();
        $this->register_member_title_style_controls();
        $this->register_member_role_style_controls();
        $this->register_member_socials_style_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
        $this->register_post_display_settings_controls();
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __( 'Choose Layout', 'steelnova' ),
            'options' => [
                '1' => [
                    'title' => __('Layout 1', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/members-1.webp'),
                ],
                '2' => [
                    'title' => __('Layout 2', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/members-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Source', 'steelnova' ),
        ]);
        $this->hidden([
            'name' => 'post_type',
            'default' => 'member',
        ]);
        $this->select([
            'name' => 'source_type',
            'label' => __('Source Type', 'steelnova'),
            'default' => 'id' ,
            'options' => [
                'id'       => __('ID', 'steelnova'),
                'category' => __('Category', 'steelnova'),
            ]
        ]);
        $this->select2([
            'name' =>'ids',
            'label_block' => true,
            'label' => __('Service List', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_post_list( 'member' ),
            'multiple' => true,
            'condition' => [
                'source_type' => 'id',
            ]
        ]);
        $this->select([
            'name' => 'orderby',
            'label' => __('Order By', 'steelnova'),
            'separator' => 'before',
            'options' => [
                'date'  => __('Date', 'steelnova'),
                'title' => __('Title', 'steelnova'),
                'author'=> __('Author', 'steelnova'),
                'id'    => __('ID', 'steelnova'),
                'rand'  => __('Random', 'steelnova'),
            ],
            'default' => 'date'
        ]);
        $this->select([
            'name' => 'order',
            'label' => __('Order', 'steelnova'),
            'options' => [
                'ASC'  => __('Ascending', 'steelnova'),
                'DESC' => __('Descending', 'steelnova'),
            ],
            'default' => 'DESC'
        ]);
        $this->number([
            'name' => 'posts_per_page',
            'label' => __('Posts Per Page', 'steelnova'),
            'min'   => -1,
            'default' => 6,
            'method' => 'add_control',
            'description' => __('To get all posts leave the value as -1', 'steelnova')
        ]);
        $this->end_controls_section();
    }


    /**
     * Member Item Card (.member)
     * Layout 1: no card wrapper
     * Layout 2: padding, border-radius, background-color
     */
    protected function register_member_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_member_item_style',
            'label' => __( 'Member Card', 'steelnova' ),
        ]);

        $this->dimensions([
            'name'      => 'member_padding',
            'label'     => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'member_item_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'member_item_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'member_item_bg',
            'selector' => '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member',
        ]);
        $this->group_box_css([
            'name'     => 'member_item_',
            'selector' => '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'member_item_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'member_item_bg_hover',
            'selector' => '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member:hover',
        ]);
        $this->group_box_css([
            'name'     => 'member_item_hover_',
            'selector' => '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member:hover',
        ]);
        $this->time([
            'name'      => 'member_item_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->size([
            'name'      => 'member_divider_margin',
            'label'     => __( 'Divider Margin Block', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member .divider' => 'margin-block: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Member Thumbnail (.member__thumbnail)
     * Layout 1: border-radius, margin-bottom
     * Layout 2: max-width, border color/width
     */
    protected function register_member_thumbnail_style_controls() {
        $this->start_style_section([
            'name'  => 'section_member_thumbnail_style',
            'label' => __( 'Thumbnail', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'thumbnail_border_radius_l1',
            'label'     => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="1"] .member__thumbnail' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '1' ],
        ]);

        $this->size([
            'name'      => 'thumbnail_margin_bottom_l1',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="1"] .member__thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '1' ],
        ]);

        $this->size([
            'name'      => 'thumbnail_max_width_l2',
            'label'     => __( 'Max Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__thumbnail' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->size([
            'name'      => 'thumbnail_border_width_l2',
            'label'     => __( 'Border Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__thumbnail' => 'border-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->color([
            'name'      => 'thumbnail_border_color_l2',
            'label'     => __( 'Border Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__thumbnail' => 'border-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->group_css_filter([
            'name'     => 'thumbnail_img_filter',
            'selector' => '{{WRAPPER}} .cs-members-carousel .member__thumbnail img',
        ]);

        $this->end_controls_section();
    }

    /**
     * Member Title (.member__title)
     */
    protected function register_member_title_style_controls() {
        $this->start_style_section([
            'name'  => 'section_member_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'member_title_typography',
            'selector' => '{{WRAPPER}} .cs-members-carousel .member__title',
        ]);

        $this->size([
            'name'      => 'member_title_margin_bottom',
            'label'     => __( 'Margin Bottom', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel .member__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'member_title_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'member_title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'member_title_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel .member__title,
                 {{WRAPPER}} .cs-members-carousel .member__title > a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'member_title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'member_title_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel .member__title > a:hover,
                 {{WRAPPER}} .cs-members-carousel .member:hover .member__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Member Role (.member__role)
     */
    protected function register_member_role_style_controls() {
        $this->start_style_section([
            'name'  => 'section_member_role_style',
            'label' => __( 'Role', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'member_role_typography',
            'selector' => '{{WRAPPER}} .cs-members-carousel .member__role',
        ]);

        $this->size([
            'name'      => 'member_role_margin_top',
            'label'     => __( 'Margin Top', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel .member__role' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->color([
            'name'      => 'member_role_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel .member__role' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Member Socials (.member__socials a) — Layout 2 only
     */
    protected function register_member_socials_style_controls() {
        $this->start_style_section([
            'name'      => 'section_member_socials_style',
            'label'     => __( 'Socials', 'steelnova' ),
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->size([
            'name'      => 'socials_gap',
            'label'     => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'socials_box_size',
            'label'     => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a' => '--cs-box-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'socials_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'socials_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'socials_color',
            'label'     => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'socials_bg_color',
            'label'     => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_box_css([
            'name'     => 'socials_',
            'selector' => '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'socials_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'socials_color_hover',
            'label'     => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'      => 'socials_bg_before_color',
            'label'     => __( 'Background Color (::before)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a::before' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'      => 'socials_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-members-carousel[data-layout="2"] .member__socials a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

        /**
     * Register Grid Source Content Controls
     */
    protected function register_post_display_settings_controls() {        
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
            'options' => Static_Options::title_html_tag_options( true ),
            'separator' => 'before',
            'default' => ''
        ]);
        $this->switcher([
            'name' => 'show_socials',
            'label' => __('Show Socials', 'steelnova'),
            'separator' => 'before',
            'default' => 'yes',
            'condition' => [
                'layout' => '2'
            ]
        ]);
        $this->end_controls_section();
    }

}