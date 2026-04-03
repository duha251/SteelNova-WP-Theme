<?php

/**
 * Various front-end customize for the theme.
 *
 * @package    SteelNova
 * @subpackage Inc\Frontend
 */
namespace SteelNova\Inc\Frontend;

use SteelNova\Inc\Core\Option;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Customize {

	private $option;

	public function __construct( Option $option_instance  ) {
		$this->option = $option_instance;
		add_action( 'pre_get_posts', [ $this, 'custom_search_query' ] );
		add_action('delete_attachment', [ $this, 'delete_custom_cropped_images' ] );
        add_action('init', [ $this, 'init' ] );
	}

    public function init() {
		add_filter( 'wp_lazy_loading_enabled', '__return_false' );
		add_filter( 'body_class', [ $this, 'body_classes' ] );
        // add_filter('intermediate_image_sizes_advanced', '__return_empty_array');
		// add_filter('big_image_size_threshold', '__return_false');
    }

	public function custom_search_query( $query ) {
		if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
			$query->set( 'post_type', [ 'post', 'project', 'service', 'product' ] );
		}
	}

	/**
	 * custom classs
	 */
	function body_classes( $classes ) {   
		$classes[] = '';
		$body_custom_class = $this->option->get_page_option('body_custom_class', '');
		$sidebar_pos_class = steelnova()->get_theme_option('blog_sidebar_mode', 'none');
		if( is_singular('post') ) {
			$sidebar_pos_class = steelnova()->get_theme_option('single_post_sidebar_mode', 'none');
		}elseif ( class_exists( 'Woocommerce' ) && is_shop() ) {
			$sidebar_pos_class = steelnova()->get_theme_option('shop_sidebar_mode', 'none');
		}
		if( isset( $_GET['sidebar'] ) ) {
			$sidebar_pos_class = $_GET['sidebar'];
		}
		if( !empty($body_custom_class) ) {
			$classes[] .= ' '.$body_custom_class;
		}
		if( !empty( $sidebar_pos_class ) ) {
			$classes[] .= 'sidebar-position-'.$sidebar_pos_class;
		}
		// $is_dark_mode = 
		$request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL) ?? '';	

		$is_dark_mode = isset($_GET['dark']) || strpos($request_uri, 'dark') !== false;
		if ( $is_dark_mode ) {
			$classes[] = 'dark-page';
		}
		return $classes;
	}

	/**
	 * Drop images created by get_image_by_size()
	 */
	public function delete_custom_cropped_images($attachment_id) {
		$cropped_files = get_post_meta($attachment_id, '_custom_cropped_files', true);

		if (!is_array($cropped_files) || empty($cropped_files)) {
			error_log("ℹ No cropped images found for ID: {$attachment_id}");
			return;
		}

		$upload_dir = wp_upload_dir();
		$upload_basedir = wp_normalize_path( $upload_dir['basedir'] ); // physical dir, normalized
		$upload_baseurl  = $upload_dir['baseurl'];

		foreach ($cropped_files as $original) {
			$file = trim($original);

			if (strpos($file, $upload_baseurl) !== false) {
				$file_path = str_replace($upload_baseurl, $upload_basedir, $file);
			}
			elseif (preg_match('#^(?:/|[A-Za-z]:[\\/])#', $file)) {
				$file_path = $file;
			}
			else {
				if (strpos($file, 'wp-content/uploads') !== false) {
					$pieces = explode('wp-content/uploads', $file);
					$rel = ltrim(end($pieces), '/\\');
					$file_path = $upload_basedir . DIRECTORY_SEPARATOR . $rel;
				} else {
					$rel = ltrim($file, '/\\');
					$file_path = $upload_basedir . DIRECTORY_SEPARATOR . $rel;
				}
			}

			// Normalize slashes and remove accidental duplicate segments
			$file_path = wp_normalize_path($file_path);

			// Extra guard: avoid doubling basedir (if basedir already present more than once)
			// Replace multiple occurrences of basedir with single one
			if (substr_count($file_path, $upload_basedir) > 1) {
				// keep only the last occurrence + following path
				$pos = strrpos($file_path, $upload_basedir);
				$file_path = substr($file_path, $pos);
			}

			// Final normalize
			$file_path = wp_normalize_path($file_path);

		}
		delete_post_meta($attachment_id, '_custom_cropped_files');
	}


	public function comment_list( $comment, $args, $depth ) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo ''.$tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-box">
			<?php endif; ?>
				<div class="comment-inner">
					<?php if ($args['avatar_size'] != 0) : ?> 
						<div class="comment-image">
							<?php echo get_avatar($comment, 90); ?>
						</div>
					<?php endif; ?>
					<div class="comment-content">
						<div class="comment-header">
							<div class="comment-user">
								<?php printf( '%s', get_comment_author_link() ); ?>
							</div>
							<span class="comment-date">
								<?php echo get_comment_date('d F Y'); ?>
							</span>
						</div>
						<div class="comment-text"><?php comment_text(); ?></div>
						<div class="comment-reply">
							<?php comment_reply_link( array_merge( $args, array(
								'add_below' => $add_below,
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'reply_text' => 'Reply',
							) ) ); ?>
						</div>
					</div>
				</div>
			<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif;
	}

}