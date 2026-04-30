<?php
namespace SteelNova\WooCommerce;
use \SteelNova\Inc\Core\Option;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Single_Product extends SteelNova_WooCommerce {

    private $option, $version;

    public function __construct( Option $option_instance, $theme_version ) {
        $this->option = $option_instance;
        $this->version = $theme_version;

        add_filter('woocommerce_gallery_image_size', [ $this, 'custom_gallery_thumbnail_size' ], 999);
        add_filter('woocommerce_gallery_thumbnail_size', [ $this, 'custom_gallery_thumbnail_size' ], 999);
        add_filter( 'woocommerce_product_review_comment_form_args', [$this, 'product_review_form_args'] );
        add_filter( 'woocommerce_reviews_title', [$this, 'review_heading_title'] );
        add_filter( 'woocommerce_product_review_list_args', [ $this, 'custom_review_list_args' ] );

        add_action( 'wp', [ $this, 'remove_actions' ] );
        add_action( 'woocommerce_single_product_summary', [$this, 'product_rating'], 5);
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }


    public function remove_actions() {
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    }

    public function review_heading_title() {
        return __('Reviews', 'steelnova');
    }

    public function product_rating() {
        global $product;
        $count = $product->get_review_count();
        echo '<div class="product__rating">';
        $this->custom_loop_rating();
        echo '<span class="rating-count">('.( $count < 10 && $count != 0 ? '0'.$count : $count ).' customer Reviews)</span>';
        echo '</div>';
    }
        
    public function custom_gallery_thumbnail_size( $size ) {
        return 'full';
    }

    public function product_review_form_args() {
        $commenter = wp_get_current_commenter();

        $comment_form = array(
            'title_reply'         => have_comments()
                ? esc_html__( 'Add a review', 'steelnova' )
                : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'steelnova' ), get_the_title() ),

            'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'steelnova' ),
            'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
            'title_reply_after'   => '</span>',
            'comment_notes_after' => '',
            'label_submit'        => esc_html__( 'Submit', 'steelnova' ),
            'logged_in_as'        => '',
        );

        $name_email_required = (bool) get_option( 'require_name_email', 1 );

        // ===== NAME + EMAIL =====
        $fields = array(
            'author' => array(
                'label'        => __( 'Name', 'steelnova' ),
                'type'         => 'text',
                'value'        => $commenter['comment_author'],
                'placeholder'  => __( 'Enter name...', 'steelnova' ),
                'required'     => $name_email_required,
                'autocomplete' => 'name',
            ),
            'email'  => array(
                'label'        => __( 'Email', 'steelnova' ),
                'type'         => 'email',
                'value'        => $commenter['comment_author_email'],
                'placeholder'  => __( 'Enter email...', 'steelnova' ),
                'required'     => $name_email_required,
                'autocomplete' => 'email',
            ),
        );

        $comment_form['fields'] = array();

        foreach ( $fields as $key => $field ) {
            $field_html  = '<div class="field-control comment-form-' . esc_attr( $key ) . '">';
            $field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

            if ( $field['required'] ) {
                $field_html .= ' <span class="required">*</span>';
            }

            $field_html .= '</label>';
            $field_html .= '<input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" autocomplete="' . esc_attr( $field['autocomplete'] ) . '" ' . ( $field['required'] ? 'required' : '' ) . ' />';
            $field_html .= '</div>';

            $comment_form['fields'][ $key ] = $field_html;
        }

        // ===== LOGIN =====
        $account_page_url = wc_get_page_permalink( 'myaccount' );
        if ( $account_page_url ) {
            $comment_form['must_log_in'] = '<p class="must-log-in">' .
                sprintf(
                    esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'steelnova' ),
                    '<a href="' . esc_url( $account_page_url ) . '">',
                    '</a>'
                ) . '</p>';
        }

        // ===== RATING + COMMENT =====
        $comment_field = '';

        if ( wc_review_ratings_enabled() ) {
            $comment_field .= '<div class="field-control comment-form-rating">';
            $comment_field .= '<label for="rating">' . esc_html__( 'Your rating', 'steelnova' );

            if ( wc_review_ratings_required() ) {
                $comment_field .= ' <span class="required">*</span>';
            }

            $comment_field .= '</label>';
            $comment_field .= '<select name="rating" id="rating" required>
                <option value="">' . esc_html__( 'Rate&hellip;', 'steelnova' ) . '</option>
                <option value="5">' . esc_html__( 'Perfect', 'steelnova' ) . '</option>
                <option value="4">' . esc_html__( 'Good', 'steelnova' ) . '</option>
                <option value="3">' . esc_html__( 'Average', 'steelnova' ) . '</option>
                <option value="2">' . esc_html__( 'Not that bad', 'steelnova' ) . '</option>
                <option value="1">' . esc_html__( 'Very poor', 'steelnova' ) . '</option>
            </select>';
            $comment_field .= '</div>';
        }

        $comment_field .= '<div class="field-control comment-form-comment">';
        $comment_field .= '<label for="comment">' . esc_html__( 'Your review', 'steelnova' ) . ' <span class="required">*</span></label>';
        $comment_field .= '<textarea id="comment" name="comment" rows="5" placeholder="' . esc_attr__( 'Write your review here...', 'steelnova' ) . '" required></textarea>';
        $comment_field .= '</div>';

        $comment_form['comment_field'] = $comment_field;
        // ===== CUSTOM SUBMIT BUTTON =====
        $comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s button" value="%4$s">
            <span class="button-text">' . esc_html__( 'Submit Review', 'steelnova' ) . '</span>
        </button>';

        // ===== CUSTOM WRAP CHO BUTTON =====
        $comment_form['submit_field'] = '<div class="form-submit review-submit-wrap">%1$s %2$s</div>';
        return $comment_form;
    }

    public function custom_review_list_args( $args ) {
        $args['callback'] = [ $this, 'custom_review_item' ];
        return $args;
    }

    public function custom_review_item( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;

        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
        ?>
        
        <li <?php comment_class( 'review-item' ); ?> id="li-comment-<?php comment_ID(); ?>">
        
            <article id="comment-<?php comment_ID(); ?>" class="review-item__inner">
                <div class="review-item__head">
                    <div class="review-item__avatar">
                        <?php steelnova_print_user_avatar( $comment->user_id ?? 0, 96 ); ?>
                    </div>
                    <div class="review-item__content">
                        <h6 class="review-item__author">
                            <?php comment_author(); ?>
                        </h6>

                        <time class="review-item__date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>">
                            <?php echo esc_html( get_comment_date() ); ?>
                        </time>

                    </div>
                </div>
                    
                <?php if ( $rating && wc_review_ratings_enabled() ) : ?>
                    <div class="review-item__rating">
                        <?php $this->custom_loop_rating( $rating ); ?>
                    </div>
                <?php endif; ?>
                <div class="review-item__text">
                    <?php comment_text(); ?>
                </div>

            </article>
        </li>

        <?php
    }


    function enqueue_scripts() {
        if( ! is_singular( 'product' ) ) {
            return '';
        }
        parent::enqueue_scripts();
        
        wp_enqueue_style('wc-single-product-style',get_template_directory_uri() . '/woo/assets/css/single-product.min.css', [], $this->version );
        // wp_enqueue_script('wc-single-product-js', get_template_directory_uri() . '/woo/assets/js/single-product.js', ['jquery'], $this->version, true);
    }
}