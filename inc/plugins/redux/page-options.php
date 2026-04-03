<?php
namespace SteelNova\Inc\Plugins\Redux;

/**
 *
 * This file defines the base class for all other classes in the theme that need to
 * interact with the WordPress hook system (actions and filters).
 *
 * @package    SteelNova
 * @subpackage Inc\Core
 * @author     Case Theme
 */

use \SteelNova\Inc\Core\Option;
use SteelNova\Inc\Helpers\StaticOptions;

// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Page_Options {

    private $option;

    public function __construct( Option $option_instance ) {
        $this->option = $option_instance;
        add_action( 'pxl_post_metabox_register', [$this, 'page_options_register'] );
    }

    function page_options_register( $metabox ) {
        $panels = [
            /** 
             * Template Page 
             */
            'pxl-template' => [
                'opt_name'            => 'pxl_template_options',
                'display_name'        => __( 'Template Options', 'steelnova' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => [
                    'header' => [
                        'title'  => __( 'General', 'steelnova' ),
                        'icon'   => 'el-icon-website',
                        'fields' => array(
                            array(
                                'id'    => 'template_type',
                                'type'  => 'select',
                                'title' => __('Template Type', 'steelnova'),
                                'options' => [
                                    'df'       	   => __('Select Type', 'steelnova'), 
                                    'header'       => __('Header Desktop', 'steelnova'),
                                    'header-mobile'=> __('Header Mobile', 'steelnova'),
                                    'footer'       => __('Footer', 'steelnova'), 
                                    'mega-menu'    => __('Mega Menu', 'steelnova'), 
                                    'hero'         => __('Hero', 'steelnova'), 
                                    'panel'        => __('Panel', 'steelnova'),
                                    'page'         => __('Page', 'steelnova'),
                                    'section'      => __('Section', 'steelnova')
                                ],
                                'select2'  => array(
                                    'allowClear' => false,
                                ),
                                'default' => 'df',
                            ),
                            
                            array(
                                'id'    => 'header_type',
                                'type'  => 'select',
                                'title' => __('Header Type', 'steelnova'),
                                'options' => [
                                    'default'      => __('Default', 'steelnova'), 
                                    'transparent'  => __('Transparent', 'steelnova'),
                                    'sticky'       => __('Sticky', 'steelnova'),
                                ],
                                'select2'  => array(
                                    'allowClear' => false,
                                ),
                                'default' => 'default',
                                'required' => ['template_type', '=', 'header'],
                            ),
                            array(
                                'id'    => 'hero_display_on',
                                'type'  => 'select',
                                'title' => __('Display On', 'steelnova'),
                                'multi' => true,
                                'select2'  => array(
                                    'allowClear' => false,
                                ),
                                'options' => [
                                    'page'         => __('Page', 'steelnova'), 
                                    'single'       => __('Single', 'steelnova'),
                                    'archive'      => __('Archive', 'steelnova'),
                                ],
                                'default' => 'page',
                                'required' => ['template_type', '=', 'hero'],
                            ),
                        ), 
                    ],
                ]
            ],
            'page' => [
                'opt_name'            => 'pxl_page_options',
                'display_name'        => __( 'Page Settings', 'steelnova' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => $this->page_options(),
            ],
            // Team
            'team' => [
                'opt_name'            => 'pxl_team_options',
                'display_name'        => __('Team Settings', 'steelnova' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => $this->single_team_options(),
            ],
        ];

        $metabox->add_meta_data( $panels );
    }

    function page_options() {
        return [
            // Header
            'header' => [
                'title'  => __( 'Header', 'steelnova' ),
                'icon'   => 'eicon-header',
                'fields' => array_merge(
                    StaticOptions::header_options( [ 'scope' => 'private' ] ),
                    StaticOptions::header_sticky_options( [ 'scope' => 'private' ] ),
                ),
            ],
            // Hero Section
            'hero' => [
                'title'  => __( 'Hero Section', 'steelnova' ),
                'icon'   => 'eicon-archive-title',
                'fields' => array_merge(
                    array(
                        // array(
                        //     'id' => 'hero_section_heading',
                        //     'title' => __('Hero Section', 'steelnova'),
                        //     'type'  => 'section',
                        //     'indent' => true,
                        // ),
                    ),
                    // Helpers::get_page_hero_options('page', 'private'),
                ),
            ],
            // Footer
            'footer' => [
                'title'  => __( 'Footer', 'steelnova' ),
                'icon'   => 'eicon-footer',
                'fields' => array_merge(
                    array(
                        array(
                            'id' => 'footer_heading',
                            'title' => __('Footer', 'steelnova'),
                            'type'  => 'section',
                            'indent' => true,
                        ),
                    ),
                    // Helpers::get_footer_options('private'),
                )
            ],
            'breadcrumb' => [
                'title'  => __('Breadcrumb', 'steelnova'),
                'icon'   => 'eicon-animated-headline',
                'fields' => array(
                    array(
                        'id' => 'breadcrumb_heading',
                        'title' => __('Breadcrumb', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'breadcrumb_mode',
                        'type'    => 'button_set',
                        'title'   => __( 'Breadcrumb Mode', 'steelnova' ),
                        'options' => [
                            'default'   => __( 'Default', 'steelnova' ),
                            'custom'    => __( 'Custom', 'steelnova' ),
                        ], 
                        'default' => 'default',
                    ),
                ) 
            ],
            'appearance' => [
                'title'  => __( 'Appearance', 'steelnova' ),
                'icon'   => 'eicon-custom',
                'fields' => array(
                    array(
                        'id' => 'general_heading',
                        'title' => __('General', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => 'body_custom_class',
                        'type' => 'text',
                        'title' => __('Body Custom Class', 'steelnova'),
                    ), 
                    array(
                        'id' => 'color_heading',
                        'title' => __('Colors', 'steelnova'),
                        'type'  => 'section',
                    ),
                    array(
                        'id'        => 'body_bg_color',
                        'type'      => 'color',
                        'title'     => __('Body Background Color', 'steelnova'),
                        'transparent' => false,
                    ),
                    array(
                        'id'          => 'primary_color',
                        'type'        => 'color',
                        'title'       => __('Primary Color', 'steelnova'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id'          => 'secondary_color',
                        'type'        => 'color',
                        'title'       => __('Secondary Color', 'steelnova'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id'          => 'third_color',
                        'type'        => 'color',
                        'title'       => __('Third Color', 'steelnova'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id'          => 'heading_color',
                        'type'        => 'color',
                        'title'       => __('Heading Color', 'steelnova'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id' => 'font_heading',
                        'title' => __('Font Family', 'steelnova'),
                        'type'  => 'section',
                    ),
                    array(
                        'id'          => 'primary_font',
                        'type'        => 'typography',
                        'title'       => __('Primary Font', 'steelnova'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'color'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                    ),
                    array(
                        'id'          => 'secondary_font',
                        'type'        => 'typography',
                        'title'       => __('Secondary Font', 'steelnova'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'color'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                    ),
                    array(
                        'id'          => 'third_font',
                        'type'        => 'typography',
                        'title'       => __('Third Font', 'steelnova'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'color'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                    ),
                    array(
                        'id'          => 'heading_font',
                        'type'        => 'typography',
                        'title'       => __('Heading Font', 'steelnova'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                        'color'       => false,
                    ),
                )
            ],
        ];
    }

    function single_team_options() {
        return [
            'info' => [
                'title'  => __( 'Info', 'steelnova' ),
                'icon'   => 'eicon-text-field',
                'fields' => [
                    array(
                        'id'    => 'team_role',
                        'type'  => 'text',
                        'title' => __('Role', 'steelnova'),
                        'placeholder' => __('CEO', 'steelnova')
                    ),
                    array(
                        'id'    => 'team_email',
                        'type'  => 'text',
                        'title' => __('Email', 'steelnova'),
                        'placeholder' => __('info@gmail.com', 'steelnova')
                    ),
                    array(
                        'id'    => 'team_phone_number',
                        'type'  => 'text',
                        'title' => __('Phone Number', 'steelnova'),
                        'placeholder' => __('+84260325111', 'steelnova')
                    ),
                    array(
                        'id'    => 'team_address',
                        'type'  => 'text',
                        'title' => __('Address', 'steelnova'),
                        'placeholder' => __('25/26 Hai Ba Trung street, Ha Noi, Viet Nam', 'steelnova')
                    ),
                ],
            ],
            'socials' => [
                'title'  => __( 'Socials', 'steelnova' ),
                'icon'   => 'eicon-text-field',
                'fields' => [
                    array(
                        'id'       => 'team_socials',
                        'type'     => 'repeater',
                        'title'    => __('Socials', 'steelnova'),
                        'full_width' => true, 
                        'sortable' => true,
                        'group_values' => true,
                        'bind_title' => 'social_label',
                        'fields'   => array(
                            array(
                                'id'       => 'social_icon',
                                'type'     => 'media', 
                                'url'      => true,
                                'title'    => esc_html__('Social Icon', 'steelnova'),
                            ),
                            array(
                                'id'    => 'social_link',
                                'type'  => 'text',
                                'title' => __('Social Link', 'steelnova'),
                                'default' => '#'
                            ),
                        ),
                    )
                ]
            ]
        ];
    }
}