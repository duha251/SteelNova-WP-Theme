<?php

if ( ! function_exists( 'steelnova_debug' ) ) {
    function steelnova_debug( $data, $die = false, $label = null ) {
        echo '<pre style="
            background: #1e1e1e;
            color: #dcdcdc;
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.4;
            overflow: auto;
        ">';

        if ( $label ) {
            echo "<strong style='color:#9cdcfe;'>[{$label}]</strong>\n";
        }

        if ( is_array( $data ) || is_object( $data ) ) {
            print_r( $data );
        } else {
            var_dump( $data );
        }

        echo '</pre>';

        if ( $die ) {
            die();
        }
    }
}

if ( ! function_exists( 'steelnova_get_template' ) ) {
    function steelnova_get_template( $slug, $args = [] ) {
        $template_file = $slug . '.php';
        $template_path = locate_template( $template_file );

        if ( ! $template_path ) {
            return;
        }

        if ( ! empty( $args ) && is_array( $args ) ) {
            extract( $args, EXTR_SKIP );
        }

        include $template_path;
    }
}

if( ! function_exists( 'steelnova_print_elementor_icon' ) ) {
    function steelnova_print_elementor_icon( $icon_attrs = [] ) {
        if( ! did_action( 'elementor/loaded' ) || empty( $icon_attrs ) ) {
            return '';
        }
        \Elementor\Icons_Manager::render_icon( $icon_attrs, [ 'aria-hidden' => 'true' ] );
    }
}

if( ! function_exists( 'steelnove_get_elementor_link_attributes' ) ) {
    function steelnove_get_elementor_link_attributes( $link ) {
        if( !isset ($link['url'] ) || empty( $link['url'] ) ) {
            return '';
        }
        $ouput = 'href="' . esc_url(trim($link['url'])) . '"';
        if ($link['is_external']) {
            $ouput .= ' target="_blank"';
        }
        if ($link['nofollow']) {
            $ouput .= ' rel="nofollow"';
        }
        if (!empty($link['custom_attributes'])) {
            $custom_attributes = explode(',', $link["custom_attributes"]);
            foreach ($custom_attributes as $attr) {
                list($key, $value) = explode('|', $attr);
                $ouput .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
            }
        }
        return $ouput;
    }
}

if( ! function_exists( 'steelnove_get_elementor_link_attributes' ) ) {
    function steelnove_print_elementor_link_attributes( $link ) {
        pxl_print_html( steelnove_get_elementor_link_attributes( $link ) );
    }
}