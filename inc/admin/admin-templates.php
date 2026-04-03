<?php

if( !defined( 'ABSPATH' ) )
	exit; 

class SteelNova_Admin_Templates {

	public function __construct() {
		add_action( 'admin_menu', [$this, 'register_page'], 20 );
	}
 
	public function register_page() {
		add_submenu_page(
			'pxlart',
		    esc_html__( 'Templates', 'steelnova' ),
		    esc_html__( 'Templates', 'steelnova' ),
		    'manage_options',
		    'edit.php?post_type=pxl-template',
		    false
		);
	}
}
new SteelNova_Admin_Templates;
