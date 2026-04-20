<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}
    
$post_id = get_the_ID();
$wrapper_attrs = array_merge( 
    [
        'class' => 'steelnova-post-social-share',
    ], 
    $wrapper_attrs
);

$this->add_render_attribute('wrapper', $wrapper_attrs);

?>
<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
    <?php if( !empty( $settings['share_label'] ) ) : ?>
    <div class="steelnova-post-social-share__label">
        <?php echo esc_html($settings['share_label']); ?>
    </div>
    <?php endif; ?>
    <ul class="steelnova-post-social-share__list">
        <?php foreach( $settings['items'] as $i => $item ) : 
            // var_dump($item['social']);
            switch ( $item['social'] ) {
                case 'facebook' : 
                    $share_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink( $post_id ) );
                    break;
                case 'X' : 
                    $share_url = 'https://twitter.com/intent/tweet?url=' . urlencode( get_permalink( $post_id ) ) . '&text=' . urlencode( get_the_title( $post_id ) );
                    break;
                case 'linkedin' : 
                    $share_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink( $post_id ) ) . '&title=' . urlencode( get_the_title( $post_id ) );
                    break;
                case 'pinterest' : 
                    $share_url = 'https://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink( $post_id ) ) . '&description=' . urlencode( get_the_title( $post_id ) );
                    break;
                case 'reddit' : 
                    $share_url = 'https://www.reddit.com/submit?url=' . urlencode( get_permalink( $post_id ) ) . '&title=' . urlencode( get_the_title( $post_id ) );
                    break;  
                case 'tumblr' : 
                    $share_url = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . urlencode( get_permalink( $post_id ) ) . '&title=' . urlencode( get_the_title( $post_id ) );
                    break;
                case 'whatsapp' :
                    $share_url = 'https://api.whatsapp.com/send?text=' . urlencode( get_the_title( $post_id ) . ' ' . get_permalink( $post_id ) );
                    break;
                case 'telegram' :
                    $share_url = 'https://t.me/share/url?url=' . urlencode( get_permalink( $post_id ) ) . '&text=' . urlencode( get_the_title( $post_id ) );
                    break;
                case 'email' :
                    $share_url = 'mailto:?subject=' . rawurlencode( get_the_title( $post_id ) ) . '&body=' . rawurlencode( get_permalink( $post_id ) );
                    break;
                case 'instagram' :
                    $share_url = $settings['instagram_url']['url'];
                    break;
                case 'youtube' :
                    $share_url = $settings['youtube_url']['url'];
                    break;
                default: 
                    $share_url = '#';
                    break;
            }  
        ?>
        <a class="button steelnova-post-social-share__link" href="<?php echo esc_url( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $item['social'] ) ; ?>" >
            <?php steelnova_elementor_print_icon( $item['icon'] ); ?>
        </a>
        <?php endforeach; ?>
    </ul>
</div>