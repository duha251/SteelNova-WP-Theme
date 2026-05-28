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
use SteelNova\Inc\Helpers\Static_Options;


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
                // array(
                //     'id'       => 'smooth_scroll',
                //     'type'     => 'button_set',
                //     'title'    => __('Smooth Scroll', 'steelnova'),
                //     'options'  => [
                //         '1'    => __('On' , 'steelnova'),
                //         '0'    => __('Off', 'steelnova'),
                //     ],
                //     'default'  => '0',
                // ),
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
                    'id'          => 'text_font',
                    'type'        => 'typography',
                    'title'       => __('Text Font', 'steelnova'),
                    'google'      => false,
                    'font-backup' => false,
                    'all_styles'  => false,
                    'line-height'  => false,
                    'font-size'   => false,
                    'color'       => false,
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
                    'font-weight' => false,
                    'text-align'  => false,
                    'color'       => false,
                    'output'      => array('h1', '.h1', 'h2', '.h2', 'h3', '.h3', 'h4', '.h4', 'h5', '.h5', 'h6', '.h6'),
                ),
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
                Static_Options::header_options(), 
                Static_Options::header_sticky_options(),
                Static_Options::header_mobile_options(),
            ),
        ));

        // Hero
        \Redux::setSection($opt_name, array(
            'title' => __('Hero', 'steelnova'),
            'icon'  => 'eicon-site-title',
            'subsection' => true,
            'fields'     => Static_Options::hero_options([ 
                'note'  => __( 'We are a dedicated company focused on delivering reliable solutions through expertise, innovation, and a client-first approach.', 'steelnova' ) 
            ]),
        ));

        // Breadcrumb
        \Redux::setSection($opt_name, array(
            'title' => __('Breadcrumb', 'steelnova'),
            'icon'  => 'eicon-ellipsis-h',
            'subsection' => true,
            'fields'     => Static_Options::breadcrumnb_options()
        ));
        
        // Footer
        \Redux::setSection($opt_name, array(
            'title'  => __('Footer', 'steelnova'),
            'icon'   => 'eicon-footer',
            'subsection' => true,
            'fields' => array_merge(
                Static_Options::footer_options(),
            )
        ));

        \Redux::setSection($opt_name, array(
            'title'  => __('404 Not Found', 'steelnova'),
            'icon'   => 'eicon-error-404',
            'subsection' => true,
            'fields' => array_merge(
                array(
                    array(
                        'id'       => '404_template',
                        'type'     => 'select',
                        'title'    => __('Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                    array(
                        'id' => '404_header_heading',
                        'title' => __('Header', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                ),
                Static_Options::header_options( [ 'scope' => 'private', 'prefix_id' =>'404_' ] ), 
                Static_Options::header_mobile_options( [ 'scope' => 'private', 'prefix_id' =>'404_' ] ),
                Static_Options::hero_options([ 
                    'scope' => 'private', 
                    'prefix_id' =>'404_', 
                    'meta_key' => 'page', 
                    'title' => __('404 Not Found!', 'steelnova'), 
                    'note'  => __( 'We are a dedicated company focused on delivering reliable solutions through expertise, innovation, and a client-first approach.', 'steelnova' ) 
                ]), 
                Static_Options::footer_options( [ 'scope' => 'private', 'prefix_id' =>'404_' ] ), 
            )
        ));
            
        // Blog
        \Redux::setSection($opt_name, array(
            'title' => __('Blog', 'steelnova'),
            'icon'  => 'eicon-post',
        ));
        \Redux::setSection($opt_name, array(
            'title' => __('Archive Blog', 'steelnova'),
            'icon'  => 'eicon-archive-posts',
            'subsection' => true,
            'fields'     => array_merge(
                array(
                    array(
                        'id'       => 'archive_standard_template_id',
                        'type'     => 'select',
                        'title'    => __('Archive Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                ),
                Static_Options::sidebar_options( [ 'scope' => 'global', 'prefix_id' =>'blog_' ] ),
            )
        ));

        \Redux::setSection($opt_name, array(
            'title' => __('Single Post', 'steelnova'),
            'icon'  => 'eicon-single-posts',
            'subsection' => true,
            'fields'     => array_merge(
                array(
                    array(
                        'id' => 'single_post_layout_heading',
                        'title' => esc_html__('Layout', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'single_post_header_template_id',
                        'type'     => 'select',
                        'title'    => __('Post Header Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                    array(
                        'id'       => 'single_post_footer_template_id',
                        'type'     => 'select',
                        'title'    => __('Post Footer Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                ),
                Static_Options::sidebar_options( [ 'scope' => 'global', 'prefix_id' =>'single_post_' ] ),
                Static_Options::breadcrumnb_options( [ 'scope' => 'private', 'prefix_id' =>'single_post_' ] ),
                Static_Options::header_options( [ 'scope' => 'private', 'prefix_id' =>'single_post_' ] ), 
                Static_Options::header_mobile_options( [ 'scope' => 'private', 'prefix_id' =>'single_post_' ] ),
                Static_Options::hero_options([ 
                    'scope' => 'private', 
                    'prefix_id' =>'single_post_', 
                    'meta_key' => 'single', 
                    'title' => '', 
                    'note'  => __( 'Stay informed with the latest updates from SteelNova, including company announcements, project highlights, technological advancements, and important developments shaping the modern manufacturing industry', 'steelnova' ) 
                ]), 
                Static_Options::footer_options( [ 'scope' => 'private', 'prefix_id' =>'single_post_' ] ), 
            )
        ));


        \Redux::setSection($opt_name, array(
            'title' => __('Project', 'steelnova'),
            'icon'  => 'eicon-post',
        ));
        \Redux::setSection($opt_name, array(
            'title' => __('Archive Project', 'steelnova'),
            'icon'  => 'eicon-archive-posts',
            'subsection' => true,
            'fields'     => array_merge(
            )
        ));

        \Redux::setSection($opt_name, array(
            'title' => __('Single Project', 'steelnova'),
            'icon'  => 'eicon-single-posts',
            'subsection' => true,
            'fields'     => array_merge(
                array(
                    array(
                        'id' => 'single_project_layout_heading',
                        'title' => esc_html__('Layout', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'single_project_header_template_id',
                        'type'     => 'select',
                        'title'    => __('Project Header Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                    array(
                        'id'       => 'single_project_footer_template_id',
                        'type'     => 'select',
                        'title'    => __('Project Footer Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                ),
                Static_Options::sidebar_options( [ 'scope' => 'global', 'prefix_id' =>'single_project_' ] ),
                Static_Options::breadcrumnb_options( [ 'scope' => 'private', 'prefix_id' =>'single_project_' ] ),
                Static_Options::header_options( [ 'scope' => 'private', 'prefix_id' =>'single_project_' ] ), 
                Static_Options::header_mobile_options( [ 'scope' => 'private', 'prefix_id' =>'single_project_' ] ),
                Static_Options::hero_options([ 
                    'scope' => 'private', 
                    'prefix_id' =>'single_project_', 
                    'meta_key' => 'single', 
                    'title' => 'Production Line Development <br> for Apex Industrial Group', 
                    'note'  => __( 'SteelNova designed and installed a high efficiency production line that improved manufacturing <br> workflow, increased output capacity, reduced operational downtime.', 'steelnova' ) 
                ]), 
                Static_Options::footer_options( [ 'scope' => 'private', 'prefix_id' =>'single_project_' ] ), 
            )
        ));

        // // Team Settings
        \Redux::setSection($opt_name, array(
            'title'      => __('Team', 'steelnova'),
            'icon'       => 'eicon-posts-ticker',
            'subsection' => false,
            'fields'     => array(),
        ));

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

        \Redux::setSection($opt_name, array(
            'title' => __('Single Member', 'steelnova'),
            'icon'  => 'eicon-single-posts',
            'subsection' => true,
            'fields'     => array_merge(
                array(
                    array(
                        'id' => 'single_member_layout_heading',
                        'title' => esc_html__('Layout', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'single_member_header_template_id',
                        'type'     => 'select',
                        'title'    => __('Project Header Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                    array(
                        'id'       => 'single_member_footer_template_id',
                        'type'     => 'select',
                        'title'    => __('Project Footer Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                ),
                Static_Options::sidebar_options( [ 'scope' => 'global', 'prefix_id' =>'single_member_' ] ),
                Static_Options::breadcrumnb_options( [ 'scope' => 'private', 'prefix_id' =>'single_member_' ] ),
                Static_Options::header_options( [ 'scope' => 'private', 'prefix_id' =>'single_member_' ] ), 
                Static_Options::header_mobile_options( [ 'scope' => 'private', 'prefix_id' =>'single_member_' ] ),
                Static_Options::hero_options([ 
                    'scope' => 'private', 
                    'prefix_id' =>'single_member_', 
                    'meta_key' => 'single', 
                    'title' => 'The Professionals Powering <br> SteelNova Growth', 
                    'note'  => __( 'We are a dedicated company focused on delivering reliable solutions <br>through expertise, innovation, and a client-first approach.', 'steelnova' ) 
                ]), 
                Static_Options::footer_options( [ 'scope' => 'private', 'prefix_id' =>'single_member_' ] ), 
            )
        ));


        // Services Settings
        \Redux::setSection($opt_name, array(
            'title'      => __('Service', 'steelnova'),
            'icon'       => 'eicon-posts-ticker',
            'subsection' => false,
            'fields'     => array(),
        ));

        \Redux::setSection($opt_name, array(
            'title'      => __('Archive Service', 'steelnova'),
            'icon'       => 'eicon-posts-ticker',
            'subsection' => true,
            'fields'     => array(
                array(
                    'id'    => 'service_status',
                    'type'  => 'switch',
                    'title' => __('Status', 'steelnova'),
                    'default' => true,
                ),
                array(
                    'id'    => 'service_label',
                    'type'  => 'text',
                    'title' => __('Label', 'steelnova'),
                    'default' => __('Service', 'steelnova')
                ),
                array(
                    'id'       => 'service_archive_templates_id',
                    'type'     => 'select',
                    'title'    => __('Page Before Template', 'steelnova'),
                    'options'  => Static_Options::get_templates_by_type('section'),
                    'default'  => '',
                ),
            ),
        ));

        \Redux::setSection($opt_name, array(
            'title' => __('Single Service', 'steelnova'),
            'icon'  => 'eicon-single-posts',
            'subsection' => true,
            'fields'     => array_merge(
                array(
                    array(
                        'id' => 'single_service_layout_heading',
                        'title' => esc_html__('Layout', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'single_service_header_template_id',
                        'type'     => 'select',
                        'title'    => __('Project Header Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                    array(
                        'id'       => 'single_service_footer_template_id',
                        'type'     => 'select',
                        'title'    => __('Project Footer Template', 'steelnova'),
                        'options'  => Static_Options::get_templates_by_type('section'),
                        'default'  => '',
                    ),
                ),
                Static_Options::sidebar_options( [ 'scope' => 'global', 'prefix_id' =>'single_service_' ] ),
                Static_Options::breadcrumnb_options( [ 'scope' => 'private', 'prefix_id' =>'single_service_' ] ),
                Static_Options::header_options( [ 'scope' => 'private', 'prefix_id' =>'single_service_' ] ), 
                Static_Options::header_mobile_options( [ 'scope' => 'private', 'prefix_id' =>'single_service_' ] ),
                Static_Options::hero_options([ 
                    'scope' => 'private', 
                    'prefix_id' =>'single_service_', 
                    'meta_key' => 'single', 
                    'title' => 'The Professionals Powering <br> SteelNova Growth', 
                    'note'  => __( 'We are a dedicated company focused on delivering reliable solutions <br>through expertise, innovation, and a client-first approach.', 'steelnova' ) 
                ]), 
                Static_Options::footer_options( [ 'scope' => 'private', 'prefix_id' =>'single_service_' ] ), 
            )
        ));

        // Shop
        \Redux::setSection($opt_name, array(
            'title' => __('Shop', 'steelnova'),
            'icon'  => 'eicon-products',
        ));
        \Redux::setSection($opt_name, array(
            'title' => __('Archive', 'steelnova'),
            'icon'  => 'eicon-products',
            'subsection' => true,
            'fields'     => array_merge(
                // array(
                //     array(
                //         'id'       => 'shop_before_template_id',
                //         'type'     => 'select',
                //         'title'    => __('Page Before Template', 'steelnova'),
                //         'options'  => Static_Options::get_templates_by_type('section'),
                //         'default'  => '',
                //     ),
                //     array(
                //         'id'       => 'shop_after_template_id',
                //         'type'     => 'select',
                //         'title'    => __('Page After Template', 'steelnova'),
                //         'options'  => Static_Options::get_templates_by_type('section'),
                //         'default'  => '',
                //     ),
                // ),
                array(
                    array(
                        'id' => 'shop_css_heading',
                        'title' => esc_html__('Custom Layout', 'steelnova'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'       => 'product_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Shop Column', 'steelnova'), 
                        'options'  => array(
                            '1'    => __('1 Column', 'steelnova'),
                            '2'    => __('2 Column', 'steelnova'),
                            '3'    => __('3 Column', 'steelnova'),
                            '4'    => __('4 Column', 'steelnova'),
                            '5'    => __('5 Column', 'steelnova'),
                        ),
        				'select2'  => [ 'allowClear' => false ],
                        'default'  => '4',
                    ),
                    // array(
                    //     'id'       => 'product_thumb_size',
                    //     'type'     => 'dimensions',
                    //     'units'    => array(''),
                    //     'title'    => esc_html__('Thumbnail Size (Width/Height)', 'steelnova'),
                    //     'default'  => array(
                    //         'Width'   => 0, 
                    //         'Height'  => 0
                    //     ),
                    // ),
                    array(
                        'id'            => 'products_per_page',
                        'type'          => 'slider',
                        'title'         => esc_html__( 'Products Per Page', 'steelnova' ),
                        'default'       => 12,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 50,
                        'display_value' => 'label',
                    ),
                    array(
                        'id'            => 'related_products_per_page',
                        'type'          => 'slider',
                        'title'         => esc_html__( 'Related Products Per Page', 'steelnova' ),
                        'default'       => 6,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 50,
                        'display_value' => 'label',
                    ),
                    array(
                        'id'             => 'shop_content_spacing',
                        'type'           => 'spacing',
                        'right'          => false,
                        'left'           => false,
                        'mode'           => 'padding',
                        'units'          => array( 'px' ),
                        'units_extended' => 'false',
                        'title'          => esc_html__( 'Spacing Top/Bottom', 'steelnova' ),
                        'default'        => array(
                            'padding-top'    => '',
                            'padding-bottom' => '',
                            'units'          => 'px',
                        )
                    ), 
                    array(
                        'id'             => 'shop_container_width',
                        'type'           => 'dimensions',
                        'units'          => array('px'), 
                        'units_extended' => 'false',
                        'title'          => __('Container Width', 'steelnova'),
                        'width'          => true, 
                        'height'         => false,
                    ),
                ),
                Static_Options::sidebar_options( [ 'scope' => 'global', 'prefix_id' =>'shop_' ] ),
            )
        ));

        \Redux::setSection($opt_name, array(
            'title' => __('Single Product', 'steelnova'),
            'icon'  => 'eicon-single-posts',
            'subsection' => true,
            'fields'     => array_merge(
                Static_Options::breadcrumnb_options( [ 'scope' => 'private', 'prefix_id' =>'single_product_' ] ),
                Static_Options::header_options( [ 'scope' => 'private', 'prefix_id' =>'single_product_' ] ), 
                Static_Options::header_mobile_options( [ 'scope' => 'private', 'prefix_id' =>'single_product_' ] ),
                Static_Options::hero_options([ 
                    'scope' => 'private', 
                    'prefix_id' =>'single_product_', 
                    'meta_key' => 'single', 
                    'title' => 'Browse Our Premium Industrial <br> Manufacturing Solutions', 
                    'note'  => __( 'Explore our collection of high quality industrial equipment and manufacturing products designed to <br> support modern engineering operations with reliability, precision, and long term performance', 'steelnova' ) 
                ]), 
                Static_Options::footer_options( [ 'scope' => 'private', 'prefix_id' =>'single_product_' ] ), 
            )
        ));
        
       

        /**
         * User Settings
         */
        \Redux::setSection($opt_name, array(
            'title' => __('User Socials', 'steelnova'),
            'icon'  => 'eicon-single-posts',
            'subsection' => false,
            'fields'     => array(
                array(
                    'id'       => 'user_socials',
                    'type'     => 'repeater',
                    'title'    => __('User Social', 'steelnova'),
                    // 'full_width' => true, 
                    // 'sortable' => false,
                    'group_values' => false,
                    // 'bind_title' => 'user_social_name',
                    // 'init_empty' => true,
                    'fields'   => array(
                        array(
                            'id' => 'user_social_name',
                            'type' => 'text',
                            'title' => __('Social Media Name', 'steelnova'),
                            'placeholder' => __('Ex: Facebook', 'steelnova'),
                        ),
                        array(
                            'id'    => 'user_social_icon',
                            'type'  => 'media',
                            'title' => __('Social Media Icon', 'steelnova'),    
                            'url'      => false,
                        ),
                    ),
                    'default' => [
                        [
                            'user_social_name' => 'Facebook',
                            'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/facebook.png') ],
                        ],
                        [
                            'user_social_name' => 'Twitter',
                            'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/twitter.png') ],
                        ],
                        [
                            'user_social_name' => 'Instagram',
                            'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/instagram.png') ],
                        ],
                        [
                            'user_social_name' => 'LinkedIn',
                            'user_social_icon' => [ 'url' => content_url('default-assets/imgs/socials/linkedin.png') ],
                        ]
                    ]
                )
            )
        ));

    }
}