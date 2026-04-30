<?php
 namespace SteelNova\Inc\Plugins\Pxlart;

/**
 * Handles integration with the Case-Addons plugin.
 *
 * @package    SteelNova
 * @subpackage Inc\Plugins
 */

use SteelNova\Inc\Core\Option;

class Pxl_Hooks {
    private $option;

    public function __construct( Option $option_instance ) {
        $this->option = $option_instance;

        add_action( 'init', [ $this, 'remove_plugin_actions' ], 11 );

        add_filter( 'pxl_support_e_control_icons', [ $this, 'disable_hook' ] );
        add_filter( 'pxl_support_e_control_list', [ $this, 'disable_hook' ] );
        add_filter( 'pxl_enable_pagepopup', [ $this, 'disable_hook' ] );
        add_filter( 'pxl_enable_megamenu', [ $this, 'enable_hook' ] );
        add_filter( 'pxl_enable_onepage', [ $this, 'enable_hook' ] );
        add_filter( 'pxl_support_awesome_pro', [ $this, 'disable_hook' ] );
        add_filter( 'pxl_scssc_on', [ $this, 'disable_hook' ] );

        // Disable register widget
        // add_filter( 'pxl-register-widgets-folder', [ $this, 'get_folder_widgets_path' ] );

        /**
         * Disable Enqueue Swiper to Core
         */
        add_filter( 'pxl-swiper-version-active', [ $this, 'disable_hook' ] );

        // add_filter( 'post_type_archive_link', [ $this, 'set_post_types_archive_url' ], 10, 2 );

        add_filter( 'pxl_server_info', [ $this, 'server_info' ] );
        add_filter( 'pxl_export_wp_settings', [ $this, 'export_wp_settings' ] );
        // add_filter( 'pxl_wg_get_source_id_builder', [ $this, 'wg_get_source_builder' ] );

        add_filter( 'pxl_template_type_support', [ $this, 'template_type_support' ] );
        add_filter( 'pxl_support_default_cpt', [ $this, 'cpt_support_default' ] );
        add_filter( 'pxl_extra_post_types', [ $this, 'register_post_types' ] );
        add_filter( 'pxl_theme_builder_post_types', [ $this, 'post_type_theme_supports_builder' ] );

        add_filter( 'pxl_extra_taxonomies', [ $this, 'register_taxonomies' ] );
    }

    public function enable_hook() {
        return true;
    }

    public function disable_hook() {
        return false;
    }

    public function get_folder_widgets_path($folder) {
        $new_folder = get_stylesheet_directory() . '/elementor/widgets/';
        if ( is_dir( $new_folder ) ) {
            return $new_folder;
        }
        return '';
    }

    public function remove_plugin_actions() {
        if ( class_exists( 'Pxl_Elementor' ) ) {
            remove_action( 'elementor/widgets/register', [ \Pxl_Elementor::instance(), 'register_widgets' ] );
		}
    }

	public function server_info( $infos ) {
		return [
            'api_url' => 'https://api.casethemes.net/',
            'docs_url' => 'https://doc.casethemes.net/steelnova/',
            'plugin_url' => 'https://api.casethemes.net/plugins/',
            'demo_url' => 'https://steelnova.casethemes.net/',
            'support_url' => 'https://casethemes.ticksy.com/',
            'help_url' => 'https://doc.casethemes.net/steelnova',
            'email_support' => 'casethemesagency@gmail.com',
            'video_url' => '#'
		];
	}

	public function export_wp_settings( $wp_options ) {
		$wp_options[] = 'mc4wp_default_form_id';
		return $wp_options;
	}

	public function wg_get_source_builder( $wg_datas ) {
		$wg_datas['tabs']   = ['control_name' => 'tabs', 'source_name' => 'content_template'];
		$wg_datas['slides'] = ['control_name' => 'slides', 'source_name' => 'slide_template'];
		return $wg_datas;
	}
    
    public function template_type_support( $type ) {
		$extra_type = [
            'header'          => __('Header Desktop', 'steelnova'),
            'header-mobile'   => __('Header Mobile', 'steelnova'),
            'footer'          => __('Footer', 'steelnova'), 
            'sidebar'         => __('Sidebar', 'steelnova'),
            'mega-menu'       => __('Mega Menu', 'steelnova') ,
            'hero'            => __('Hero', 'steelnova'), 
            'panel'           => __('Panel', 'steelnova'),
            // 'archive'      => __('Archive', 'steelnova')
            'section'         => __('Section', 'steelnova')
		];
		return $extra_type;
	}

    function cpt_support_default($postypes){
        return $postypes; // pxl-template
    }

    /**
     * 
     */
    function post_type_theme_supports_builder($postypes){
        //default are header, footer, mega-menu
        return $postypes;
    }

    /**
     * Register post types
     */
    function register_post_types( $postypes ) {

        $post_types = [
            'member' => [
                'status'     => true,
                'item_name'  => __('Member', 'steelnova'),
                'items_name' => __('Members', 'steelnova'),
                'slug'       => 'team',
                'menu_position' => 6, 
            ],
            'service' => [
                'status'     => true,
                'item_name'  => __('Service', 'steelnova'),
                'items_name' => __('Services', 'steelnova'),
                'slug'       => 'services',
                'menu_position' => 6, 
                'menu_icon' => 'dashicons-portfolio',
            ],
            'project' => [
                'status'     => true,
                'item_name'  => __('Project', 'steelnova'),
                'items_name' => __('Projects', 'steelnova'),
                'slug'       => 'projects',
                'menu_position' => 6, 
            ]
        ];

        if( !is_array( $post_types ) || empty( $post_types ) ) {
            return [];
        }

        foreach( $post_types as $post_type => $params ) {
            if( empty( $post_type ) ) {
                continue;
            }
            $postypes[$post_type] = array(
                'status'     => $params['status'],
                'item_name'  => $params['items_name'],
                'items_name' => $params['items_name'],
                'args'       => array(
                    'has_archive' => false,
                    'rewrite'     => array(
                        'slug'    => $params['slug'],
                    ),
                ),
                'labels'     => array(
                    'add_new_item' => __('Add ', 'steelnova').ucwords($post_type),
                ),
            );
        }
    
        return $postypes;
    }

    /**
     * Resgister taxonomies
     */
    function register_taxonomies( $taxonomies ) {
        $taxonomies['project_category'] = array(
            'status'     => true,
            'post_type'  => array( 'project' ),
            'taxonomy'   => 'Project Category',
            'taxonomies' => 'Project Categories',
            'args'       => array(
                'rewrite'             => array(
                    'slug'       => 'project-category'
                ),
            ),
            'labels'     => array()
        );
        return $taxonomies;
    }

}