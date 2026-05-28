<?php

$nav_menu = $settings['nav_menu'] ?? '';

$primary_menu = steelnova()->get_page_option('header_nav_menu', '');

if( $primary_menu && !empty( $primary_menu ) ) {
    $nav_menu = $primary_menu;
}
    
$menu_settings = [
];


steelnova()->component->get_navigation_menu([
    'menu' =>  wp_get_nav_menu_object( $nav_menu ),
    'menu_class' => 'header-menu navigation-menu',
]);