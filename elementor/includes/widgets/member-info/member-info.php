<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Member_Info extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-member-info',
            'title'      => __( 'CS Member Info', 'steelnova' ),
            'icon'       => 'eicon-post-info',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'info', 'team', 'member', 'bio', 'profile', 'contact' ],
            'script'     => [],
            'style'      => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Settings Controls
        $this->register_display_settings_controls();
        // Style Controls
        $this->register_name_style_controls();
        $this->register_role_style_controls();
        $this->register_divider_style_controls();
        $this->register_meta_item_style_controls();
        $this->register_meta_label_style_controls();
        $this->register_meta_value_style_controls();
        $this->register_socials_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name'  => 'content_section',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->text([
            'name'        => 'email_label',
            'label'       => __( 'Email Label', 'steelnova' ),
            'placeholder' => __( 'Ex: Email Address', 'steelnova' ),
            'default'     => __( 'Email Address', 'steelnova' ),
        ]);
        $this->text([
            'name'        => 'phone_number_label',
            'label'       => __( 'Phone Number Label', 'steelnova' ),
            'placeholder' => __( 'Ex: Phone Number', 'steelnova' ),
            'default'     => __( 'Phone Number', 'steelnova' ),
        ]);
        $this->text([
            'name'        => 'address_label',
            'label'       => __( 'Address Label', 'steelnova' ),
            'placeholder' => __( 'Ex: Address', 'steelnova' ),
            'default'     => __( 'Address', 'steelnova' ),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Display Settings Controls.
     */
    protected function register_display_settings_controls() {
        $this->start_settings_section([
            'name'  => 'settings_archive_display',
            'label' => __( 'Display', 'steelnova' ),
        ]);
        $this->image_size([
            'name'        => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->select([
            'name'      => 'title_tag',
            'label'     => __( 'Title HTML Tag', 'steelnova' ),
            'options'   => Static_Options::title_html_tag_options( true ),
            'separator' => 'before',
            'default'   => '',
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Name Style Controls.
     *
     * .cs-member-info__name — member name heading (dynamic tag)
     */
    protected function register_name_style_controls() {
        $this->start_style_section([
            'name'  => 'section_name_style',
            'label' => __( 'Name', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'name_typography',
            'selector' => '{{WRAPPER}} .cs-member-info__name',
        ]);

        $this->_start_controls_tabs([ 'name' => 'name_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'name_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'name_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'name_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'name_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info:hover .cs-member-info__name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'name_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__name' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'name_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Role Style Controls.
     *
     * .cs-member-info__role — role/position text, 18px, margin-bottom 58px
     */
    protected function register_role_style_controls() {
        $this->start_style_section([
            'name'  => 'section_role_style',
            'label' => __( 'Role', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'role_typography',
            'selector' => '{{WRAPPER}} .cs-member-info__role',
        ]);

        $this->_start_controls_tabs([ 'name' => 'role_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'role_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'role_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__role' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'role_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'role_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info:hover .cs-member-info__role' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'role_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__role' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'role_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__role' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Divider Style Controls.
     *
     * .cs-member-info .divider — separator between sections, margin-block 38px 25px
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
                '{{WRAPPER}} .cs-member-info .divider' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->color([
            'name'  => 'divider_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .divider' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'divider_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Meta Item Style Controls.
     *
     * .cs-member-info .list__item — each meta row (email / phone / address)
     * flex column, gap 5px
     */
    protected function register_meta_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_meta_item_style',
            'label' => __( 'Meta Item', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'meta_item_gap',
            'label' => __( 'Gap (label ↔ value)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'meta_item_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'meta_item_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'meta_item_background',
            'selector' => '{{WRAPPER}} .cs-member-info .list__item',
        ]);
        $this->group_box_css([
            'name'     => 'meta_item_box_css',
            'selector' => '{{WRAPPER}} .cs-member-info .list__item',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'meta_item_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'meta_item_background_hover',
            'selector' => '{{WRAPPER}} .cs-member-info .list__item:hover',
        ]);
        $this->group_box_css([
            'name'     => 'meta_item_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-member-info .list__item:hover',
        ]);
        $this->time([
            'name'  => 'meta_item_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->dimensions([
            'name'  => 'meta_item_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Meta Label Style Controls.
     *
     * .cs-member-info .list__item-label — heading font, 600, clamp(1.125rem → 1.25rem)
     */
    protected function register_meta_label_style_controls() {
        $this->start_style_section([
            'name'  => 'section_meta_label_style',
            'label' => __( 'Meta Label', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'meta_label_typography',
            'selector' => '{{WRAPPER}} .cs-member-info .list__item-label',
        ]);

        $this->_start_controls_tabs([ 'name' => 'meta_label_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'meta_label_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'meta_label_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'meta_label_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'meta_label_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item:hover .list__item-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'meta_label_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item-label' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Meta Value Style Controls.
     *
     * .cs-member-info .list__item-link  — link value (email / phone), heading font, large, 600
     * .cs-member-info .list__item-text  — text value (address), same style
     */
    protected function register_meta_value_style_controls() {
        $this->start_style_section([
            'name'  => 'section_meta_value_style',
            'label' => __( 'Meta Value', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'meta_value_typography',
            'selector' => '{{WRAPPER}} .cs-member-info .list__item-link, {{WRAPPER}} .cs-member-info .list__item-text',
        ]);

        $this->_start_controls_tabs([ 'name' => 'meta_value_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'meta_value_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'meta_value_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item-link,
                 {{WRAPPER}} .cs-member-info .list__item-text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'meta_value_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'meta_value_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item:hover .list__item-link,
                 {{WRAPPER}} .cs-member-info .list__item:hover .list__item-text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'meta_value_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info .list__item-link,
                 {{WRAPPER}} .cs-member-info .list__item-text' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Socials Style Controls.
     *
     * .cs-member-info__socials     — flex wrapper, gap 15px
     * .cs-member-info__socials a   — 48px box, border-radius 50%, dark bg (#0A1119), white color
     */
    protected function register_socials_style_controls() {
        $this->start_style_section([
            'name'  => 'section_socials_style',
            'label' => __( 'Socials', 'steelnova' ),
        ]);

        // ── Wrapper ───────────────────────────────────────────────────────────
        $this->heading([
            'name'      => 'socials_wrapper_heading',
            'label'     => __( 'Wrapper', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->gaps([
            'name'  => 'socials_gap',
            'label' => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials' => 'gap: {{COLUMN}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'socials_spacing',
            'label' => __( 'Spacing (Margin)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // ── Icon link ─────────────────────────────────────────────────────────
        $this->heading([
            'name'  => 'social_icon_heading',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->size([
            'name'  => 'social_icon_box_size',
            'label' => __( 'Box Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a' => '--cs-box-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'social_icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-member-info__socials a i'   => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'social_icon_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'social_icon_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'social_icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a'        => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-member-info__socials a svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'social_icon_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'social_icon_border',
            'selector' => '{{WRAPPER}} .cs-member-info__socials a',
        ]);
        $this->dimensions([
            'name'  => 'social_icon_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'social_icon_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'social_icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a:hover'          => 'color: {{VALUE}};',
                '{{WRAPPER}} .cs-member-info__socials a:hover svg path' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'social_icon_bg_color_hover',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->group_border([
            'name'     => 'social_icon_border_hover',
            'selector' => '{{WRAPPER}} .cs-member-info__socials a:hover',
        ]);
        $this->time([
            'name'  => 'social_icon_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-member-info__socials a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
