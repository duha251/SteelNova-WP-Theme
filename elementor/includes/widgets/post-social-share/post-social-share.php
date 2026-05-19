<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Social_Share extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'     => 'steelnova_post_social_share',
            'title'    => __( 'CS Post Social Share', 'steelnova' ),
            'icon'     => 'eicon-share',
            'keywords' => [ 'steelnova', 'social share', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        $this->register_wrapper_style_controls();
        $this->register_label_style_controls();
        $this->register_link_style_controls();
        // Steelnova
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name'  => 'section_content',
            'label' => __( 'Post Social Share', 'steelnova' ),
        ]);
        $this->text([
            'name'    => 'share_label',
            'label'   => __( 'Share Label', 'steelnova' ),
            'default' => __( 'Share:', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();
        $this->icons([
            'name'  => 'icon',
            'label' => __( 'Social Icon', 'steelnova' ),
        ], $repeater);
        $this->select([
            'name'      => 'social',
            'label'     => __( 'Social Network', 'steelnova' ),
            'separator' => 'before',
            'options'   => [
                'facebook'  => __( 'Facebook', 'steelnova' ),
                'X'         => __( 'X', 'steelnova' ),
                'linkedin'  => __( 'LinkedIn', 'steelnova' ),
                'pinterest' => __( 'Pinterest', 'steelnova' ),
                'reddit'    => __( 'Reddit', 'steelnova' ),
                'tumblr'    => __( 'Tumblr', 'steelnova' ),
                'whatsapp'  => __( 'WhatsApp', 'steelnova' ),
                'telegram'  => __( 'Telegram', 'steelnova' ),
                'email'     => __( 'Email', 'steelnova' ),
                'instagram' => __( 'Instagram', 'steelnova' ),
                'youtube'   => __( 'YouTube', 'steelnova' ),
            ],
            'default' => [ 'facebook' ],
        ], $repeater);
        $this->url([
            'name'        => 'instagram_url',
            'label'       => __( 'Instagram Profile URL', 'steelnova' ),
            'placeholder' => __( 'https://www.instagram.com/yourprofile', 'steelnova' ),
            'default'     => [ 'url' => 'https://www.instagram.com/' ],
            'condition'   => [ 'social' => 'instagram' ],
        ], $repeater);
        $this->url([
            'name'        => 'youtube_url',
            'label'       => __( 'YouTube Channel URL', 'steelnova' ),
            'placeholder' => __( 'https://www.youtube.com/yourchannel', 'steelnova' ),
            'default'     => [ 'url' => 'https://www.youtube.com/' ],
            'condition'   => [ 'social' => 'youtube' ],
        ], $repeater);
        $this->repeater([
            'name'   => 'items',
            'label'  => __( 'Social Share', 'steelnova' ),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Wrapper Style Controls.
     *
     * .cs-post-social-share — flex, gap 15px, align-items center
     * .cs-post-social-share__list — inline-flex, gap 8px
     */
    protected function register_wrapper_style_controls() {
        $this->start_style_section([
            'name'  => 'section_wrapper_style',
            'label' => __( 'Wrapper', 'steelnova' ),
        ]);

        $this->heading([
            'name'      => 'wrapper_heading',
            'label'     => __( 'Outer Wrapper', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->gaps([
            'name'  => 'wrapper_gap',
            'label' => __( 'Gap (label ↔ list)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'wrapper_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->heading([
            'name'  => 'list_heading',
            'label' => __( 'Icon List', 'steelnova' ),
        ]);
        $this->gaps([
            'name'  => 'list_gap',
            'label' => __( 'Gap between icons', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__list' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Label Style Controls.
     *
     * .cs-post-social-share__label — heading font, 16px, 600, heading color
     */
    protected function register_label_style_controls() {
        $this->start_style_section([
            'name'  => 'section_label_style',
            'label' => __( 'Label', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'label_typography',
            'selector' => '{{WRAPPER}} .cs-post-social-share__label',
        ]);

        $this->_start_controls_tabs([ 'name' => 'label_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'label_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'label_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'label_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'label_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share:hover .cs-post-social-share__label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'label_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__label' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'label_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Link (icon button) Style Controls.
     *
     * .cs-post-social-share__link — 46px box, border-radius 50%,
     *   bg #0A1119, white color → hover bg #FF5B1B
     */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name'  => 'section_link_style',
            'label' => __( 'Icon Link', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'link_box_size',
            'label' => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link' => '--cs-box-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'link_icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-post-social-share__link i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'link_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'link_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'link_icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-social-share__link svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'link_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'link_border',
            'selector' => '{{WRAPPER}} .cs-post-social-share__link',
        ]);
        $this->dimensions([
            'name'  => 'link_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'link_box_shadow',
            'selector' => '{{WRAPPER}} .cs-post-social-share__link',
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'link_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'link_icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link:hover'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-post-social-share__link:hover svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'link_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'link_border_hover',
            'selector' => '{{WRAPPER}} .cs-post-social-share__link:hover',
        ]);
        $this->group_box_shadow([
            'name'     => 'link_box_shadow_hover',
            'selector' => '{{WRAPPER}} .cs-post-social-share__link:hover',
        ]);
        $this->time([
            'name'  => 'link_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-social-share__link' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
