<?php
namespace SteelNova\Inc\Frontend;

/**
 * Frontend Layout
 *
 * Handles layout structure for frontend.
 *
 * @package SteelNova
 */

use SteelNova\Inc\Core\Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Components {

    private $option;

    public function __construct( Option $option_instance ) {
        $this->option = $option_instance;
        add_action('steelnova_before_main_content', [$this, 'before_main_content_render']);
        add_action('steelnova_after_main_content', [$this, 'after_main_content_render']);
    }

    public function before_main_content_render() {
        $this->get_body_overlay();
        $this->get_site_loader();
    }

    public function after_main_content_render() {
    }

    public function get_body_overlay() {
        ?>
        <div class="body__overlay"></div>
        <?php
    }

    public function get_site_loader() {
        $enable_site_loader = (bool) $this->option->get_theme_option('site_loader', '');
        if ( !$enable_site_loader ) {
            return '';
        }
        $loader_image = $this->option->get_theme_option('loader_logo', []); ?>
        <div id="siteLoader" class="site-loader">
            <div class="site-loader-logo image">
                <?php echo wp_kses_post('<img src="' . esc_url( $loader_image['url'] ) . '" alt="Site Loader Logo">'); ?>
            </div>
        </div>
        <?php
    }

    public function get_back_to_top() {
        $enable_back_to_top = (bool) $this->option->get_theme_option('back_to_top', '');
        if( !$enable_back_to_top ) {
            return '';
        } ?>
        <button class="back-to-top">
            <span class="button-icon" data-loop-animation="bongBenhStop">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 12 12" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 10.375C6.09946 10.375 6.19484 10.3355 6.26516 10.2652C6.33549 10.1948 6.375 10.0995 6.375 10V5.375H5.625V10C5.625 10.207 5.793 10.375 6 10.375Z" fill="black"/>
                    <path d="M2.99967 5.37504C2.92555 5.37497 2.85311 5.35294 2.7915 5.31173C2.7299 5.27052 2.68188 5.21198 2.65353 5.1435C2.62517 5.07502 2.61775 4.99967 2.63219 4.92697C2.64663 4.85427 2.68229 4.78748 2.73467 4.73504L5.73467 1.73504C5.80498 1.66481 5.9003 1.62537 5.99967 1.62537C6.09905 1.62537 6.19436 1.66481 6.26467 1.73504L9.26467 4.73504C9.31705 4.78748 9.35271 4.85427 9.36715 4.92697C9.38159 4.99967 9.37417 5.07502 9.34581 5.1435C9.31746 5.21198 9.26944 5.27052 9.20784 5.31173C9.14623 5.35294 9.07379 5.37497 8.99967 5.37504H2.99967Z" fill="black"/>
                </svg>
            </span>
        </button>
        <?php
    }

    public function get_navigation_menu($args = []) {
        if( has_nav_menu('primary') || ( isset($args['menu']) && $args['menu'] !== 'empty') ) :
            $menu_icon = '<span class="menu-link-icon menu-link-icon--desktop">';
            if( !empty($args['menu_icon']['value']) ) {
                ob_start();
                \Elementor\Icons_Manager::render_icon( $args['menu_icon'], [ 'aria-hidden' => 'true' ] );
                $menu_icon .= ob_get_clean();
            }else {
                $menu_icon .= '<svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 12 8" fill="none">
                                    <path d="M10.1094 0L5.78125 4.32812L1.4375 0L0 1.4375L5.76562 7.5L11.5469 1.4375L10.1094 0Z" fill="white"/>
                                </svg>';
            }
            $menu_icon .= '</span>';
            wp_nav_menu(
                array_merge(
                    array(
                        'theme_location' => 'primary',
                        'container'      => '',
                        'menu_id'        => '',
                        'menu_class'     => 'header-menu menu-primary',
                        'before'         => '',
                        'after'          => '',
                        'link_before'    => '<span class="menu-link-inner">
                                                <span class="menu-link-text">',
                        'link_after'     => '   </span>
                                                <span class="menu-link-icon menu-link-icon--mobile"><span class="icon-plus"></span>
                                                </span>'.
                                                $menu_icon .
                                            '</span>',
                        'walker'         => class_exists( 'PXL_Mega_Menu_Walker' ) ? new \PXL_Mega_Menu_Walker : '',
                    ),
                    $args,
                )
            );
        else : ?>
            <ul class="header-menu header-menu-empty">
                <li>
                    <a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">
                        <?php echo esc_html__( 'Create New Menu', 'steelnova' ); ?>
                    </a>
                </li>
            </ul>
        <?php endif;
    }

    /**
     * Display searchform
     */
    public function get_search_form( $template = '', $args = [] ) {
        if( empty( $template ) ) {
            $template = 'default';
        }
        get_search_form( array_merge( [ 'template' => $template ], $args ) );
    }

    /**
     * Get hero title
     */
    public function get_hero_title() {
        $prefix_id = steelnova_get_prefix_id_option();

        $title = $this->option->get_option( $prefix_id . 'hero_title', '');
        if( empty( $title ) ) {
            $title = $this->get_title();
        }
        return $title;
    }

    /**
     * Get hero title
     */
    public function get_hero_note() {
        $prefix_id = steelnova_get_prefix_id_option();

        $note = $this->option->get_option( $prefix_id . 'hero_note', '');
        return $note;
    }

    /**
     * 
     */
    public function get_title() {
        $title = get_the_title();

        if (is_404()) {
            $title = '404';
        } elseif (is_archive()) {
            if (is_category() || is_tax()) {
                $term = get_queried_object();
                if ($term && !is_wp_error($term)) {
                    $title = $term->name;
                }
            } elseif ( is_post_type_archive() ) {
                $post_type = get_post_type_object(get_post_type());
                if ($post_type) {
                    $title = $post_type->labels->name;
                }
            }
        }

        return $title;
    }

    /**
     * Get Bre
     */
    public function get_breadcrumb( $args = [] ) {
        $args = array_merge([
            'separator' => '<svg xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 4 4" fill="none">
                                <path d="M2 4C3.10457 4 4 3.10457 4 2C4 0.89543 3.10457 0 2 0C0.89543 0 0 0.89543 0 2C0 3.10457 0.89543 4 2 4Z" fill="white"/>
                            </svg>'
        ], $args);
        extract( $args );

        $show_home_label = (bool)$this->option->get_option('show_home_label', '');
        $show_page_label = (bool)$this->option->get_option('show_page_label', '');

        
        $separator = ' <span class="separator">'. $separator .'</span> ';
        $breadcrumb = [];

        $prefix_id = steelnova_get_prefix_id_option();

        $current_label_mode = $this->option->get_option($prefix_id . 'breadcrumb_text_mode', '');
        // Home
        if( $show_home_label ) {
            $home_label_text = $this->option->get_option('home_label_text', '');
            $breadcrumb[] = '<a href="' . home_url() . '">' . $home_label_text . '</a>';
        }

        if( $show_page_label ) {
            $page_label_text = $this->option->get_option('page_label_text', '');
            $breadcrumb[] = '<span>'. $page_label_text .'</span>';
        }

        $label_text = $current_label_mode === 'custom' 
        ? $this->option->get_option($prefix_id . 'breadcrumb_label_text', '')
        : $this->get_title();
                
        $breadcrumb[] = '<span>' . $label_text . '</span>';

        return implode($separator, $breadcrumb);
    }

    /**
     * 
     */
    public function get_current_page($link){
        $parts = parse_url($link);
        if( !isset($parts['query']) ) return $link;
        
        parse_str($parts['query'], $query_vars);
        
        $current_page = 1;
        if(isset($query_vars['page'])){
            $current_page = $query_vars['page'];
        } elseif(isset($query_vars['paged'])){
            $current_page = $query_vars['paged'];
        }
        
        return '#' . $current_page;
    }

    /**
     * Get Pagination HTML
     * * @param WP_Query $query
     * @param bool $ajax
     * @return string
     */
    public function get_pagination( $query = null, $ajax = false ) {
        if ( $ajax ) {
            add_filter( 'paginate_links', array( $this, 'get_current_page' ) );
        }

        if ( empty( $query ) ) {
            $query = $GLOBALS['wp_query'];
        }

        // Luôn trả về chuỗi rỗng thay vì null để tránh lỗi PHP 8.1+
        if ( empty( $query->max_num_pages ) || $query->max_num_pages < 2 ) {
            return '';
        }

        $paged = $query->get( 'paged' );
        if ( ! $paged ) {
            $paged = $query->get( 'page' );
        }
        $paged = $paged ? intval( $paged ) : 1;

        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        unset( $query_args['elementor-preview'], $query_args['ver'] );

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $prev_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M6.4092 10.8639C6.57239 10.7073 6.66406 10.4949 6.66406 10.2735C6.66406 10.052 6.57239 9.83964 6.4092 9.68304L2.10028 5.54922L6.4092 1.41541C6.56776 1.2579 6.6555 1.04695 6.65352 0.827986C6.65154 0.609021 6.55999 0.399564 6.39859 0.244727C6.2372 0.0898905 6.01887 0.0020628 5.79063 0.000160217C5.56239 -0.00174236 5.3425 0.0824327 5.17832 0.234555L0.253969 4.9588C0.0907769 5.1154 -0.000898838 5.32778 -0.000898838 5.54922C-0.000898838 5.77066 0.0907769 5.98304 0.253969 6.13965L5.17832 10.8639C5.34157 11.0204 5.56294 11.1084 5.79376 11.1084C6.02458 11.1084 6.24595 11.0204 6.4092 10.8639Z" fill="currentColor"/></svg>';
        $next_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="13" viewBox="0 0 8 13" fill="none">
                        <path d="M-0.000161171 1.05973L1.06084 -0.000272751L6.83984 5.77673C6.93299 5.86929 7.00692 5.97937 7.05737 6.10062C7.10782 6.22187 7.13379 6.3519 7.13379 6.48323C7.13379 6.61455 7.10782 6.74458 7.05737 6.86583C7.00692 6.98708 6.93299 7.09716 6.83984 7.18973L1.06084 12.9697L0.000838757 11.9097L5.42484 6.48473L-0.000161171 1.05973Z" fill="#0A1119"/>
                    </svg>';

        $paginate_links_args = array(
            'base'               => $ajax ? '%_%' : $pagenum_link,
            'format'             => $ajax ? '?page=%#%' : 'page/%#%/',
            'total'              => $query->max_num_pages,
            'current'            => $paged,
            'mid_size'           => 1,
            'add_args'           => array_map( 'urlencode', $query_args ),
            'prev_text'          => $prev_svg, 
            'next_text'          => $next_svg, 
            'before_page_number' => '<span>',
            'after_page_number'  => '</span>',
        );

        $links = paginate_links( $paginate_links_args );

        if ( $links ) {
            // Thêm số 0 phía trước các con số (01, 02...)
            // $links = preg_replace_callback( '/>(\d+)</', function( $matches ) {
            //     return '>' . sprintf( '%02d', $matches[1] ) . '<';
            // }, $links );

            $ajax_class = $ajax ? ' ajax' : '';
            
            // Khai báo bộ lọc HTML cho phép SVG
            $allowed_html = wp_kses_allowed_html( 'post' );
            $allowed_html['svg']  = array( 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true );
            $allowed_html['path'] = array( 'd' => true, 'fill' => true );

            ob_start();
            ?>
            <div class="cs-pagination<?php echo esc_attr( $ajax_class ); ?>">
                <?php echo wp_kses( $links, $allowed_html ); ?>
            </div>
            <?php
            return ob_get_clean();
        }

        return '';
    }
}