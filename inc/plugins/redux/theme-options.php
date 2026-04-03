<?php
/**
 *
 * This file defines the base class for all other classes in the theme that need to
 * interact with the WordPress hook system (actions and filters).
 *
 * @package    SteelNova
 * @subpackage Inc\Core
 * @author     Case Theme
 */
namespace SteelNova\Inc\Plugins\Redux;

use \SteelNova\Inc\Core\Option;
use SteelNova\Inc\Helpers\StaticOptions;


// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Theme_Options {
    private $option;
    public function __construct( Option $option_instance ) {
        $this->option = $option_instance;
        add_action('after_setup_theme', [$this, 'theme_options_register']);
    }
    
    public function theme_options_register() {
        $opt_name = $this->option->get_option_name();
        // $version = Helpers::get_theme_version();
        $version = '1';
        $args = array(
            // TYPICAL -> Change these values as you need/desire
            'opt_name'             => $opt_name,
            // This is where your data is stored in the database and also becomes your global variable name.
            'display_name'         => '', //$theme->get('Name'),
            // Name that appears at the top of your panel
            'display_version'      => $version,
            // Version that appears at the top of your panel
            'menu_type'            => 'submenu', //class_exists('Pxltheme_Core') ? 'submenu' : '',
            //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
            'allow_sub_menu'       => true,
            // Show the sections below the admin menu item or not
            'menu_title'           => esc_html__('Theme Options', 'steelnova'),
            'page_title'           => esc_html__('Theme Options', 'steelnova'),
            // You will need to generate a Google API key to use this feature.
            // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
            'google_api_key'       => '',
            // Set it you want google fonts to update weekly. A google_api_key value is required.
            'google_update_weekly' => false,
            // Must be defined to add google fonts to the typography module
            'async_typography'     => false,
            // Use a asynchronous font on the front end or font string
            //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
            'admin_bar'            => false,
            // Show the panel pages on the admin bar
            'admin_bar_icon'       => 'dashicons-admin-generic',
            // Choose an icon for the admin bar menu
            'admin_bar_priority'   => 50,
            // Choose an priority for the admin bar menu
            'global_variable'      => '',
            // Set a different name for your global variable other than the opt_name
            'dev_mode'             => true,
            // Show the time the page took to load, etc
            'update_notice'        => true,
            // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
            'customizer'           => true,
            // Enable basic customizer support
            //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
            //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
            'show_options_object' => false,
            // OPTIONAL -> Give you extra features
            'page_priority'        => 80,
            // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
            'page_parent'          => 'pxlart', //class_exists('Agron_Admin_Page') ? 'case' : '',
            // For a full list of options, visit: //codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'page_permissions'     => 'manage_options',
            // Permissions needed to access the options panel.
            'menu_icon'            => '',
            // Specify a custom URL to an icon
            'last_tab'             => '',
            // Force your panel to always open to a specific tab (by id)
            'page_icon'            => 'icon-themes',
            // Icon displayed in the admin panel next to your menu_title
            'page_slug'            => 'pxlart-theme-options',
            // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
            'save_defaults'        => true,
            // On load save the defaults to DB before user clicks save or not
            'default_show'         => false,
            // If true, shows the default value next to each field that is not the default value.
            'default_mark'         => '',
            // What to print by the field's title if the value shown is default. Suggested: *
            'show_import_export'   => true,
            // Shows the Import/Export panel when not used as a field.
        
            // CAREFUL -> These options are for advanced use only
            'transient_time'       => 60 * MINUTE_IN_SECONDS,
            'output'               => true,
            // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
            'output_tag'           => true,
            // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
            // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
        
            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
            'database'             => '',
            // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
            'use_cdn'              => true,
            // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
        
            // HINTS
            // 'hints'                => array(
            //     'icon'          => 'el el-question-sign',
            //     'icon_position' => 'right',
            //     'icon_color'    => 'lightgray',
            //     'icon_size'     => 'normal',
            //     'tip_style'     => array(
            //         'color'   => 'red',
            //         'shadow'  => true,
            //         'rounded' => false,
            //         'style'   => '',
            //     ),
            //     'tip_position'  => array(
            //         'my' => 'top left',
            //         'at' => 'bottom right',
            //     ),
            //     'tip_effect'    => array(
            //         'show' => array(
            //             'effect'   => 'slide',
            //             'duration' => '500',
            //             'event'    => 'mouseover',
            //         ),
            //         'hide' => array(
            //             'effect'   => 'slide',
            //             'duration' => '500',
            //             'event'    => 'click mouseleave',
            //         ),
            //     ),
            // ),
        );
        
        \Redux::SetArgs($opt_name, $args);
        
        /**
         * Site Setting
         */
        \Redux::setSection($opt_name, array(
            'title'  => esc_html__('Globals', 'steelnova'),
            'icon'       => 'eicon-global-settings',
            'fields' => array(),
        ));
        // Site
        \Redux::setSection($opt_name, array(
            'title'  => __('Site', 'steelnova'),
            'icon'   => 'eicon-globe',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'site_loader',
                    'type'     => 'button_set',
                    'title'    => __('Site Loader', 'steelnova'),
                    'options'  => [
                        '1'    => __('On' , 'steelnova'),
                        '0'    => __('Off', 'steelnova'),
                    ],
                    'default'  => '0',
                ),
                array(
                    'id'       => 'loader_logo',
                    'type'     => 'media',
                    'title'    => esc_html__('Loader Logo', 'steelnova'),
                    'default'  => [
                        'url' => get_template_directory_uri() . '/assets/imgs/logo-icon.webp',
                    ],
                    'url'      => false,
                    'required' => ['site_loader', '=', '1'],
                ),
                // array(
                //     'id'       => 'mouse_move_animation',
                //     'type'     => 'button_set',
                //     'title'    => __('Mouse Move Animation', 'steelnova'),
                //     'options'  => [
                //         '1'    => __('On' , 'steelnova'),
                //         '0'    => __('Off', 'steelnova'),
                //     ],
                //     'default'  => '0',
                // ),
                array(
                    'id'       => 'smooth_scroll',
                    'type'     => 'button_set',
                    'title'    => __('Smooth Scroll', 'steelnova'),
                    'options'  => [
                        '1'    => __('On' , 'steelnova'),
                        '0'    => __('Off', 'steelnova'),
                    ],
                    'default'  => '0',
                ),
                array(
                    'id'       => 'back_to_top',
                    'type'     => 'button_set',
                    'title'    => __('Back to Top', 'steelnova'),
                    'options'  => [
                        '1'    => __('On' , 'steelnova'),
                        '0'    => __('Off', 'steelnova'),
                    ],
                    'default'  => '0',
                ),
                array(
                    'id'       => 'blur_bottom_site',
                    'type'     => 'button_set',
                    'title'    => __('Blur Bottom Site', 'steelnova'),
                    'options'  => [
                        '1'    => __('On' , 'steelnova'),
                        '0'    => __('Off', 'steelnova'),
                    ],
                    'default'  => '0',
                ),
            )
        ));
        // Color
        \Redux::setSection($opt_name, array(
            'title'  => __('Colors', 'steelnova'),
            'icon'       => 'eicon-global-colors',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'          => 'primary_color',
                    'type'        => 'color',
                    'title'       => __('Primary Color', 'steelnova'),
                    'transparent' => false,
                ),
                array(
                    'id'          => 'secondary_color',
                    'type'        => 'color',
                    'title'       => __('Secondary Color', 'steelnova'),
                    'transparent' => false,
                ),
                array(
                    'id'          => 'third_color',
                    'type'        => 'color',
                    'title'       => __('Third Color', 'steelnova'),
                    'transparent' => false,
                ),
                array(
                    'id'          => 'heading_color',
                    'type'        => 'color',
                    'title'       => __('Heading Color', 'steelnova'),
                    'transparent' => false,
                    'default'     => ''
                ),
                array(
                    'id'        => 'body_bg_color',
                    'type'      => 'color',
                    'title'     => esc_html__('Body Background Color', 'steelnova'),
                    'transparent' => false,
                ),
                array(
                    'id'      => 'link_color',
                    'type'    => 'link_color',
                    'title'   => __('Link Colors', 'steelnova'),
                    'active' => false,
                ),
                array(
                    'id'          => 'linear_gradient_color',
                    'type'        => 'color_gradient',
                    'title'       => __('Linear Gradient Colors', 'steelnova'),
                    'transparent' => false,
                    'validate' => 'color',
                    // 'preview' => true,
                    'gradient-angle' => false,
                    'default' => [
                        'from' => '',
                        'to' => '',
                    ]
                ),
            )
        ));
        // Typography
        \Redux::setSection($opt_name, array(
            'title'  => __('Typography', 'steelnova'),
            'icon'   => 'eicon-typography',
            'subsection' => true,
            'fields' => array(
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
                    'google'      => false,
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
                    'google'      => false,
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
                    'google'      => false,
                    'font-backup' => false,
                    'all_styles'  => false,
                    'line-height' => false,
                    'font-size'   => false,
                    'font-style'  => false,
                    'font-weight' => true,
                    'text-align'  => false,
                    'color'       => false,
                    'output'      => array('h1', '.h1', 'h2', '.h2', 'h3', '.h3', 'h4', '.h4', 'h5', '.h5', 'h6', '.h6'),
                ),
                array(
                    'id'          => 'font_heading_h1',
                    'type'        => 'typography',
                    'title'       => __('Heading H1', 'steelnova'),
                    'google'      => false,
                    'font-backup' => false,
                    'all_styles'  => true,
                    'text-align'  => false,
                    'line-height' => true,
                    'font-size'   => true,
                    'font-backup' => false,
                    'font-style'  => false,
                    'output'      => array('h1', '.h1'),
                    'units'       => 'px',
                    'font-family' => false,
                    'color' => false
                ),
        
                array(
                    'id'          => 'font_heading_h2',
                    'type'        => 'typography',
                    'title'       => __('Heading H2', 'steelnova'),
                    'google'      => true,
                    'font-backup' => true,
                    'all_styles'  => true,
                    'text-align'  => false,
                    'line-height' => true,
                    'font-size'   => true,
                    'font-backup' => false,
                    'font-style'  => false,
                    'output'      => array('h2', '.h2'),
                    'units'       => 'px',
                    'font-family' => false,
                    'color' => false
                ),
        
                array(
                    'id'          => 'font_heading_h3',
                    'type'        => 'typography',
                    'title'       => __('Heading H3', 'steelnova'),
                    'google'      => true,
                    'font-backup' => true,
                    'all_styles'  => true,
                    'text-align'  => false,
                    'line-height' => true,
                    'font-size'   => true,
                    'font-backup' => false,
                    'font-style'  => false,
                    'output'      => array('h3', '.h3'),
                    'units'       => 'px',
                    'font-family' => false,
                    'color' => false
                ),
        
                array(
                    'id'          => 'font_heading_h4',
                    'type'        => 'typography',
                    'title'       => __('Heading H4', 'steelnova'),
                    'google'      => true,
                    'font-backup' => true,
                    'all_styles'  => true,
                    'text-align'  => false,
                    'line-height' => true,
                    'font-size'   => true,
                    'font-backup' => false,
                    'font-style'  => false,
                    'output'      => array('h4', '.h4'),
                    'units'       => 'px',            
                    'font-family' => false,
                    'color' => false
                ),
        
                array(
                    'id'          => 'font_heading_h5',
                    'type'        => 'typography',
                    'title'       => __('Heading H5', 'steelnova'),
                    'google'      => true,
                    'font-backup' => true,
                    'all_styles'  => true,
                    'text-align'  => false,
                    'line-height' => true,
                    'font-size'   => true,
                    'font-backup' => false,
                    'font-style'  => false,
                    'output'      => array('h5', '.h5'),
                    'units'       => 'px',
                    'font-family' => false,
                    'color' => false
                ),
        
                array(
                    'id'          => 'font_heading_h6',
                    'type'        => 'typography',
                    'title'       => __('Heading H6', 'steelnova'),
                    'google'      => true,
                    'font-backup' => true,
                    'all_styles'  => true,
                    'text-align'  => false,
                    'line-height' => true,
                    'font-size'   => true,
                    'font-backup' => false,
                    'font-style'  => false,
                    'output'      => array('h6', '.h6'),
                    'units'       => 'px',
                    'font-family' => false,
                    'color' => false
                ),
            )
        ));
        // Layout
        \Redux::setSection($opt_name, array(
            'title'  => __('Layout', 'steelnova'),
            'icon'   => 'eicon-layout-settings',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'             => 'container_width',
                    'type'           => 'dimensions',
                    'units'          => array('px', '%'), 
                    'units_extended' => 'false',
                    'title'          => __( 'Container Width', 'steelnova' ),
                    'height'         => false,
                    'width'          => true, 
                ),
                array(
                    'name'           => 'spacing_block_heading',
                    'title'          => __('Spacing Block', 'steelnova'),
                    'type'  => 'section',
                    'indent' => true,
                ),
                array(
                    'id'             => 'spacing_block',
                    'title'          => esc_html__('Spacing Block', 'steelnova'),
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'left'           => false,
                    'right'          => false,
                ),
                array(
                    'id'             => 'spacing_block_xl',
                    'title'          => esc_html__('Spacing Block ( < 1400px )', 'steelnova'),
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'left'           => false,
                    'right'          => false,
                ),
                array(
                    'id'             => 'spacing_block_lg',
                    'title'          => esc_html__('Spacing Block ( < 1200px )', 'steelnova'),
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'left'           => false,
                    'right'          => false,
                ),
                array(
                    'id'             => 'spacing_block_md',
                    'title'          => esc_html__('Spacing Block ( < 992px )', 'steelnova'),
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'left'           => false,
                    'right'          => false,
                ),
                array(
                    'id'             => 'spacing_block_sm',
                    'title'          => esc_html__('Spacing Block ( < 768px )', 'steelnova'),
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'left'           => false,
                    'right'          => false,
                ),
                array(
                    'id'             => 'spacing_block_xs',
                    'title'          => esc_html__('Spacing Block ( < 576px )', 'steelnova'),
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'left'           => false,
                    'right'          => false,
                )
            )
        ));

        /**
         * Sections
         */
        \Redux::setSection($opt_name, array(
            'title'  => __('Sections', 'steelnova'),
            'icon'   => 'eicon-layout-settings',
            'fields' => array()
        ));

        // Header
        \Redux::setSection($opt_name, array(
            'title'  => __('Header', 'steelnova'),
            'icon'   => 'eicon-header',
            'subsection' => true,
            'fields' => array_merge(
                StaticOptions::header_options(), 
                StaticOptions::header_sticky_options(),
                StaticOptions::header_mobile_options(),
            ),
        ));

        // Hero
        \Redux::setSection($opt_name, array(
            'title' => __('Hero', 'steelnova'),
            'icon'  => 'eicon-site-title',
            'subsection' => true,
            'fields'     => array_merge(
                StaticOptions::hero_options(),
            )
        ));
        
        // Footer
        \Redux::setSection($opt_name, array(
            'title'  => __('Footer', 'steelnova'),
            'icon'   => 'eicon-footer',
            'subsection' => true,
            'fields' => array_merge(
                StaticOptions::footer_options(),
            )
        ));

        // // Pages Settings
        // \Redux::setSection($opt_name, array(
        //     'title' => __('Pages', 'steelnova'),
        //     'icon'  => 'eicon-progress-tracker',
        //     'fields'     => array(
        //     )
        // ));
        // \Redux::setSection($opt_name, array(
        //     'title'  => __('404 Error', 'steelnova'),
        //     'icon'   => 'eicon-error-404',
        //     'subsection' => true,
        //     'fields' => array_merge(
        //         array(

        //             array(
        //                 'id'       => '404_page_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Template', 'steelnova'),
        //                 // 'options'  => Helpers::get_templates_by_type('page'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id' => '404_header_heading',
        //                 'title' => __('Header', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'       => '404_page_show_header',
        //                 'type'     => 'switch',
        //                 'title'    => __('Show Header', 'steelnova'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'      => '404_page_header_layout',
        //                 'type'    => 'select',
        //                 'title'   => __('Header Layout', 'steelnova'),
        //                 'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
        //                 // 'options' => Helpers::get_templates_by_type('header'),
        //                 'select2'  => [ 'allowClear' => true ],
        //                 'required' => ['404_page_show_header', '=', '1'],
        //             ),
        //             array(
        //                 'id' => '404_header_mobile_heading',
        //                 'title' => __('Header Mobile', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'       => '404_page_show_header_mobile',
        //                 'type'     => 'switch',
        //                 'title'    => __('Show Header', 'steelnova'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'      => '404_page_header_mobile_layout',
        //                 'type'    => 'select',
        //                 'title'   => __('Header Layout', 'steelnova'),
        //                 'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
        //                 // 'options' => Helpers::get_templates_by_type('header-mobile'),
        //                 'select2'  => [ 'allowClear' => true ],
        //                 'required' => ['404_page_show_header_mobile', '=', '1'],
        //             ),      
        //             array(
        //                 'id' => '404_footer_heading',
        //                 'title' => __('Footer', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'       => '404_page_show_footer',
        //                 'type'     => 'switch',
        //                 'title'    => __('Show Footer', 'steelnova'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'      => '404_page_footer_layout',
        //                 'type'    => 'select',
        //                 'title'   => __('Footer Layout', 'steelnova'),
        //                 'desc'    => sprintf(__('Please create your layout before choosing. %sClick Here%s','steelnova'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=pxl-template' ) ) . '">','</a>'),
        //                 // 'options' => Helpers::get_templates_by_type('footer'),
        //                 'select2'  => [ 'allowClear' => true ],
        //                 'required' => ['404_page_show_footer', '=', '1'],
        //             ),
        //             // array(
        //             //     'id' => '404_hero_heading',
        //             //     'title' => __('Hero Section', 'steelnova'),
        //             //     'type'  => 'section',
        //             //     'indent' => true,
        //             // ),
        //         ),
        //         // Helpers::get_page_hero_options('404_page'),
        //     )
        // ));
            
        // // Blog
        // \Redux::setSection($opt_name, array(
        //     'title' => __('Blog', 'steelnova'),
        //     'icon'  => 'eicon-post',
        // ));
        // \Redux::setSection($opt_name, array(
        //     'title' => __('Archive', 'steelnova'),
        //     'icon'  => 'eicon-archive-posts',
        //     'subsection' => true,
        //     'fields'     => array_merge(
        //         array(
        //             array(
        //                 'id'       => 'archive_standard_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Archive Template', 'steelnova'),
        //                 // 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'archive_standard_before_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page Before Template', 'steelnova'),
        //                 // 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'archive_standard_after_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page After Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //         ),
        //         Helpers::get_page_hero_options('blog'),
        //         Helpers::get_breadcrumb_option('blog'),
        //         array(
        //             array(
        //                 'id' => 'blog_sidebar_mode_heading',
        //                 'title' => esc_html__('Sidebar', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'      => 'blog_sidebar_mode',
        //                 'type'    => 'button_set',
        //                 'title'   => __( 'Sidebar Mode', 'steelnova' ),
        //                 'options' => [
        //                     'none' => __('None', 'steelnova'),
        //                     'left' => __('Left', 'steelnova'),
        //                     'right' => __('Right', 'steelnova'),
        //                 ], 
        //                 'default' => 'none',
        //             ),
        //             array(
        //                 'id' => 'blog_css_heading',
        //                 'title' => esc_html__('Custom Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'             => 'blog_content_spacing',
        //                 'type'           => 'spacing',
        //                 'right'          => false,
        //                 'left'           => false,
        //                 'mode'           => 'padding',
        //                 'units'          => array( 'px' ),
        //                 'units_extended' => 'false',
        //                 'title'          => esc_html__( 'Spacing Top/Bottom', 'steelnova' ),
        //                 'default'        => array(
        //                     'padding-top'    => '',
        //                     'padding-bottom' => '',
        //                     'units'          => 'px',
        //                 )
        //             ), 
        //             array(
        //                 'id'             => 'blog_container_width',
        //                 'type'           => 'dimensions',
        //                 'units'          => array('px'), 
        //                 'units_extended' => 'false',
        //                 'title'          => __('Container Width', 'steelnova'),
        //                 'width'          => true, 
        //                 'height'         => false,
        //             ),
        //         )
        //     )
        // ));

        // \Redux::setSection($opt_name, array(
        //     'title' => __('Single Post', 'steelnova'),
        //     'icon'  => 'eicon-single-posts',
        //     'subsection' => true,
        //     'fields'     => array_merge(
        //         array(
        //             array(
        //                 'id' => 'single_post_layout_heading',
        //                 'title' => esc_html__('Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'       => 'single_post_header_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Post Header Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'single_post_footer_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Post Footer Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'single_post_before_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page Before Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'single_post_after_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page After Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //         ),
        //         Helpers::get_page_hero_options('post'),
        //         Helpers::get_breadcrumb_option('single_post'),
        //         array(
        //             array(
        //                 'id' => 'single_post_sidebar_mode_heading',
        //                 'title' => esc_html__('Sidebar', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'      => 'single_post_sidebar_mode',
        //                 'type'    => 'button_set',
        //                 'title'   => __( 'Sidebar Mode', 'steelnova' ),
        //                 'options' => [
        //                     'none' => __('None', 'steelnova'),
        //                     'left' => __('Left', 'steelnova'),
        //                     'right' => __('Right', 'steelnova'),
        //                 ], 
        //                 'default' => 'none',
        //             ),
        //             array(
        //                 'id' => 'single_post_css_heading',
        //                 'title' => esc_html__('Custom Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'             => 'single_post_content_spacing',
        //                 'type'           => 'spacing',
        //                 'right'          => false,
        //                 'left'           => false,
        //                 'mode'           => 'padding',
        //                 'units'          => array( 'px' ),
        //                 'units_extended' => 'false',
        //                 'title'          => esc_html__( 'Spacing Top/Bottom', 'steelnova' ),
        //                 'default'        => array(
        //                     'padding-top'    => '',
        //                     'padding-bottom' => '',
        //                     'units'          => 'px',
        //                 )
        //             ), 
        //             array(
        //                 'id'             => 'single_post_container_width',
        //                 'type'           => 'dimensions',
        //                 'units'          => array('px'), 
        //                 'units_extended' => 'false',
        //                 'title'          => __('Container Width', 'steelnova'),
        //                 'width'          => true, 
        //                 'height'         => false,
        //             ),
        //         )
        //     )
        // ));

        // // Team Settings
        // \Redux::setSection($opt_name, array(
        //     'title'      => __('Team', 'steelnova'),
        //     'icon'       => 'eicon-posts-ticker',
        //     'subsection' => false,
        //     'fields'     => array(),
        // ));

        // \Redux::setSection($opt_name, array(
        //     'title'      => __('Archive Team', 'steelnova'),
        //     'icon'       => 'eicon-posts-ticker',
        //     'subsection' => true,
        //     'fields'     => array(
        //         array(
        //             'id'    => 'team_status',
        //             'type'  => 'switch',
        //             'title' => __('Status', 'steelnova'),
        //             'default' => true,
        //         ),
        //         array(
        //             'id'    => 'team_label',
        //             'type'  => 'text',
        //             'title' => __('Label', 'steelnova'),
        //             'default' => __('Team', 'steelnova')
        //         ),
        //     ),
        // ));

        // \Redux::setSection($opt_name, array(
        //     'title'      => __('Team Details', 'steelnova'),
        //     'icon'       => 'eicon-posts-ticker',
        //     'subsection' => true,
        //     'fields'     => array_merge(
        //         array(
        //             // array(
        //             //     'id' => 'single_team_hero_heading',
        //             //     'title' => esc_html__('Hero Section', 'steelnova'),
        //             //     'type'  => 'section',
        //             //     'indent' => true,
        //             // ),
        //         ),
        //         Helpers::get_page_hero_options('team'),
        //         array(
        //             array(
        //                 'id' => 'single_team_breadcrumb_heading',
        //                 'title' => esc_html__('Breadcrumb', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'      => 'team_breadcrumb_mode',
        //                 'type'    => 'button_set',
        //                 'title'   => __( 'Breadcrumb Mode', 'steelnova' ),
        //                 'options' => [
        //                     'default'   => __( 'Default', 'steelnova' ),
        //                     'custom'    => __( 'Custom', 'steelnova' ),
        //                 ], 
        //                 'default' => 'default',
        //             ),
        //             array(
        //                 'id'    => 'single_team_breadcrumb_label',
        //                 'type'  => 'text',
        //                 'title' => __( 'Breadcrumb Label', 'steelnova' ),
        //                 'placeholder' => __('Ex: Something', 'steelnova'),
        //                 'required' => [ 'team_breadcrumb_mode', '=', 'custom' ]
        //             ),
        //             array(
        //                 'id'    => 'single_team_breadcrumb_highight',
        //                 'type'  => 'text',
        //                 'title' => __( 'Breadcrumb Highight', 'steelnova' ),
        //                 'placeholder' => __('Ex: Something', 'steelnova'),
        //             ),
        //         )
        //     ),
        // ));

        // // Team Settings
        // \Redux::setSection($opt_name, array(
        //     'title'      => __('Career', 'steelnova'),
        //     'icon'       => 'eicon-posts-ticker',
        //     'subsection' => false,
        //     'fields'     => array(),
        // ));

        // \Redux::setSection($opt_name, array(
        //     'title'      => __('Archive Career', 'steelnova'),
        //     'icon'       => 'eicon-posts-ticker',
        //     'subsection' => true,
        //     'fields'     => array(
        //         array(
        //             'id'    => 'career_status',
        //             'type'  => 'switch',
        //             'title' => __('Status', 'steelnova'),
        //             'default' => true,
        //         ),
        //         array(
        //             'id'    => 'career_label',
        //             'type'  => 'text',
        //             'title' => __('Label', 'steelnova'),
        //             'default' => __('Career', 'steelnova')
        //         ),
        //     ),
        // ));

        // \Redux::setSection($opt_name, array(
        //     'title' => __('Single Career', 'steelnova'),
        //     'icon'  => 'eicon-single-posts',
        //     'subsection' => true,
        //     'fields'     => array_merge(
        //         array(
        //             array(
        //                 'id' => 'single_career_layout_heading',
        //                 'title' => esc_html__('Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'       => 'single_career_header_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Post Header Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'single_career_footer_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Post Footer Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'single_career_before_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page Before Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'single_career_after_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page After Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //         ),
        //         Helpers::get_page_hero_options('career'),
        //         Helpers::get_breadcrumb_option('single_career'),
        //         array(
        //             array(
        //                 'id' => 'single_career_css_heading',
        //                 'title' => esc_html__('Custom Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'             => 'single_career_content_spacing',
        //                 'type'           => 'spacing',
        //                 'right'          => false,
        //                 'left'           => false,
        //                 'mode'           => 'padding',
        //                 'units'          => array( 'px' ),
        //                 'units_extended' => 'false',
        //                 'title'          => esc_html__( 'Spacing Top/Bottom', 'steelnova' ),
        //                 'default'        => array(
        //                     'padding-top'    => '',
        //                     'padding-bottom' => '',
        //                     'units'          => 'px',
        //                 )
        //             ), 
        //             array(
        //                 'id'             => 'single_career_container_width',
        //                 'type'           => 'dimensions',
        //                 'units'          => array('px'), 
        //                 'units_extended' => 'false',
        //                 'title'          => __('Container Width', 'steelnova'),
        //                 'width'          => true, 
        //                 'height'         => false,
        //             ),
        //         )
        //     )
        // ));

        // // Shop
        // \Redux::setSection($opt_name, array(
        //     'title' => __('Shop', 'steelnova'),
        //     'icon'  => 'eicon-shop',
        // ));
        // \Redux::setSection($opt_name, array(
        //     'title' => __('Archive', 'steelnova'),
        //     'icon'  => 'eicon-archive-posts',
        //     'subsection' => true,
        //     'fields'     => array_merge(
        //         array(
        //             array(
        //                 'id'       => 'shop_before_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page Before Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //             array(
        //                 'id'       => 'shop_after_template_id',
        //                 'type'     => 'select',
        //                 'title'    => __('Page After Template', 'steelnova'),
        //                 'options'  => Helpers::get_templates_by_type('section'),
        //                 'default'  => '',
        //             ),
        //         ),
        //         Helpers::get_page_hero_options('shop'),
        //         Helpers::get_breadcrumb_option('shop'),
        //         array(
        //             array(
        //                 'id' => 'shop_sidebar_mode_heading',
        //                 'title' => esc_html__('Sidebar', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'      => 'shop_sidebar_mode',
        //                 'type'    => 'button_set',
        //                 'title'   => __( 'Sidebar Mode', 'steelnova' ),
        //                 'options' => [
        //                     'none' => __('None', 'steelnova'),
        //                     'left' => __('Left', 'steelnova'),
        //                     'right' => __('Right', 'steelnova'),
        //                 ], 
        //                 'default' => 'none',
        //             ),
        //             array(
        //                 'id' => 'shop_css_heading',
        //                 'title' => esc_html__('Custom Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'             => 'shop_content_spacing',
        //                 'type'           => 'spacing',
        //                 'right'          => false,
        //                 'left'           => false,
        //                 'mode'           => 'padding',
        //                 'units'          => array( 'px' ),
        //                 'units_extended' => 'false',
        //                 'title'          => esc_html__( 'Spacing Top/Bottom', 'steelnova' ),
        //                 'default'        => array(
        //                     'padding-top'    => '',
        //                     'padding-bottom' => '',
        //                     'units'          => 'px',
        //                 )
        //             ), 
        //             array(
        //                 'id'             => 'shop_container_width',
        //                 'type'           => 'dimensions',
        //                 'units'          => array('px'), 
        //                 'units_extended' => 'false',
        //                 'title'          => __('Container Width', 'steelnova'),
        //                 'width'          => true, 
        //                 'height'         => false,
        //             ),
        //             array(
        //                 'id'       => 'product_columns',
        //                 'type'     => 'select',
        //                 'title'    => esc_html__('Shop Column', 'steelnova'), 
        //                 'options'  => array(
        //                     '1'    => __('1 Column', 'steelnova'),
        //                     '2'    => __('2 Column', 'steelnova'),
        //                     '3'    => __('3 Column', 'steelnova'),
        //                     '4'    => __('4 Column', 'steelnova'),
        //                     '5'    => __('5 Column', 'steelnova'),
        //                 ),
        // 				'select2'  => [ 'allowClear' => false ],
        //                 'default'  => '3',
        //             ),
        //             array(
        //                 'id'       => 'product_thumb_size',
        //                 'type'     => 'dimensions',
        //                 'units'    => array(''),
        //                 'title'    => esc_html__('Thumbnail Size (Width/Height)', 'steelnova'),
        //                 'default'  => array(
        //                     'Width'   => 0, 
        //                     'Height'  => 0
        //                 ),
        //             ),
        //             array(
        //                 'id'            => 'products_per_page',
        //                 'type'          => 'slider',
        //                 'title'         => esc_html__( 'Products Per Page', 'steelnova' ),
        //                 'default'       => 9,
        //                 'min'           => 1,
        //                 'step'          => 1,
        //                 'max'           => 50,
        //                 'display_value' => 'label',
        //             ),
        //             array(
        //                 'id'            => 'related_products_per_page',
        //                 'type'          => 'slider',
        //                 'title'         => esc_html__( 'Related Products Per Page', 'steelnova' ),
        //                 'default'       => 6,
        //                 'min'           => 1,
        //                 'step'          => 1,
        //                 'max'           => 50,
        //                 'display_value' => 'label',
        //             )
        //         )
        //     )
        // ));

        // \Redux::setSection($opt_name, array(
        //     'title' => __('Single Product', 'steelnova'),
        //     'icon'  => 'eicon-single-posts',
        //     'subsection' => true,
        //     'fields'     => array_merge(
        //         Helpers::get_page_hero_options('product'),
        //         Helpers::get_breadcrumb_option('single_product'),
        //         array(
        //             array(
        //                 'id' => 'single_product_css_heading',
        //                 'title' => esc_html__('Custom Layout', 'steelnova'),
        //                 'type'  => 'section',
        //                 'indent' => true,
        //             ),
        //             array(
        //                 'id'             => 'single_product_content_spacing',
        //                 'type'           => 'spacing',
        //                 'right'          => false,
        //                 'left'           => false,
        //                 'mode'           => 'padding',
        //                 'units'          => array( 'px' ),
        //                 'units_extended' => 'false',
        //                 'title'          => esc_html__( 'Spacing Top/Bottom', 'steelnova' ),
        //                 'default'        => array(
        //                     'padding-top'    => '',
        //                     'padding-bottom' => '',
        //                     'units'          => 'px',
        //                 )
        //             ), 
        //             array(
        //                 'id'             => 'single_product_container_width',
        //                 'type'           => 'dimensions',
        //                 'units'          => array('px'), 
        //                 'units_extended' => 'false',
        //                 'title'          => __('Container Width', 'steelnova'),
        //                 'width'          => true, 
        //                 'height'         => false,
        //             ),
        //         )
        //     )
        // ));
        
        // // Post Type Settings
        // \Redux::setSection($opt_name, array(
        //     'title'      => __('Post Types', 'steelnova'),
        //     'icon'       => 'eicon-posts-ticker',
        //     'subsection' => false,
        //     'fields'     => array(
        //         array(
        //             'id'       => 'pxl_post_types',
        //             'type'     => 'repeater',
        //             'title'    => __('Add Post Type', 'steelnova'),
        //             'full_width' => true, 
        //             'sortable' => false,
        //             'group_values' => false,
        //             'bind_title' => 'pxl_post_type',
        //             'init_empty' => true,
        //             'fields'   => array(
        //                 array(
        //                     'id'    => 'pxl_post_type_status',
        //                     'type'  => 'switch',
        //                     'title' => __('Post Type Status', 'steelnova'),
        //                     'default' => '0',
        //                 ),
        //                 array(
        //                     'id'    => 'pxl_post_type',
        //                     'type'  => 'text',
        //                     'title' => __('Post Type Name', 'steelnova'),
        //                     'placeholder' => __('Ex: Project', 'steelnova'),
        //                 ),
        //                 array(
        //                     'id'    => 'pxl_post_type_label',
        //                     'type'  => 'text',
        //                     'title' => __('Post Type Label', 'steelnova'),
        //                     'placeholder' => __('Ex: Projects', 'steelnova'),
        //                 ),
        //                 array(
        //                     'id'    => 'pxl_post_type_slug',
        //                     'type'  => 'text',
        //                     'title' => __('Post Type Slug', 'steelnova'),
        //                     'placeholder' => __('Ex: projects', 'steelnova'),
        //                 ),
        //                 array(
        //                     'id' => 'pxl_on_category',
        //                     'title' => esc_html__('Enable Category', 'steelnova'),
        //                     'type'  => 'switch',
        //                     'description' => __('When category is enable. The category will be automatically created with the structure post_type_name + "_category"', 'steelnova'),
        //                     // 'default' => true,
        //                 ),
        //                 array(
        //                     'id'    => 'pxl_category_label',
        //                     'type'  => 'text',
        //                     'title' => __('Category Label', 'steelnova'),
        //                     'placeholder' => __('Ex: Categories', 'steelnova'),
        //                     'required' => ['pxl_on_category', '=', true]
        //                 ),
        //             ),
        //         )
        //     ),
        // ));

        // /**
        //  * User Settings
        //  */
        // \Redux::setSection($opt_name, array(
        //     'title' => __('User Socials', 'steelnova'),
        //     'icon'  => 'eicon-single-posts',
        //     'subsection' => false,
        //     'fields'     => array(
        //         array(
        //             'id'       => 'user_socials',
        //             'type'     => 'repeater',
        //             'title'    => __('User Social', 'steelnova'),
        //             'full_width' => true, 
        //             'sortable' => false,
        //             'group_values' => false,
        //             'bind_title' => 'user_social_name',
        //             'init_empty' => true,
        //             'fields'   => array(
        //                 array(
        //                     'id' => 'user_social_name',
        //                     'type' => 'text',
        //                     'title' => __('Social Media Name', 'steelnova'),
        //                     'placeholder' => __('Ex: Facebook', 'steelnova'),
        //                 ),
        //                 array(
        //                     'id'    => 'user_social_icon',
        //                     'type'  => 'media',
        //                     'title' => __('Social Media Icon', 'steelnova'),    
        //                     'url'      => false,
        //                 ),
        //             ),
        //             'default' => [
        //                 [
        //                     'user_social_name' => 'Facebook',
        //                     'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/facebook.png') ],
        //                 ],
        //                 [
        //                     'user_social_name' => 'Twitter',
        //                     'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/twitter.png') ],
        //                 ],
        //                 [
        //                     'user_social_name' => 'Instagram',
        //                     'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/instagram.png') ],
        //                 ],
        //                 [
        //                     'user_social_name' => 'LinkedIn',
        //                     'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/linkedin.png') ],
        //                 ]
        //             ]
        //         )
        //     )
        // ));

    }
}