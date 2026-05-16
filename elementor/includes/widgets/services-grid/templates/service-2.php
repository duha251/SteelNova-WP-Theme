<?php
$thumbnail_id = get_post_thumbnail_id($post->ID);    
$features = get_post_meta( $post->ID, 'service_features', true ) ?: [];

$service_icon = get_post_meta( $post->ID, 'service_icon', true ) ?: '';
extract( $display_args ); 

?>
<div class="service">
    <div class="service__icon">
        <?php steelnova_print_svg_content( $service_icon['url'] ); ?>
    </div>
    <<?php echo esc_attr( $display_args['title_tag'] ); ?> class="service__title">
        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
            <?php echo esc_html( get_the_title( $post->ID ) ); ?>
        </a>
    </<?php echo esc_attr( $display_args['title_tag'] ); ?>>
    <?php if( $show_excerpt == true ) : ?>
        <p class="service__excerpt">
            <?php echo wp_trim_words( $post->post_excerpt, $num_of_words, $more = null); ?>
        </p>
    <?php endif; ?>
    <?php if ( ! empty( $features ) ): ?>
        <ul class="service__features cs-list">
            <?php foreach ( $features as $feature ): ?>
                <li class="cs-list__item">
                    <span class="cs-list__item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="7" viewBox="0 0 9 7" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.75657 0.154249C9.00921 0.377551 9.03285 0.763848 8.80955 1.01812L4.12345 6.31544C4.06933 6.37663 4.0035 6.42635 3.92984 6.46167C3.85618 6.49699 3.77619 6.51718 3.69459 6.52105C3.61299 6.52493 3.53145 6.51241 3.45477 6.48423C3.37809 6.45605 3.30784 6.41279 3.24817 6.35701L0.192025 3.5046C0.0744545 3.3938 0.00553039 3.24096 0.000318517 3.0795C-0.00489336 2.91803 0.054031 2.76106 0.164211 2.64291C0.274391 2.52476 0.426865 2.45504 0.588304 2.44898C0.749743 2.44292 0.907015 2.50102 1.02574 2.61058L3.6255 5.03104L7.89596 0.206407C7.9492 0.146176 8.01381 0.0970389 8.08607 0.0618111C8.15833 0.0265832 8.23683 0.00595606 8.31708 0.00111109C8.39732 -0.00373389 8.47773 0.00729853 8.55371 0.0335763C8.62968 0.059854 8.69973 0.100861 8.75983 0.154249H8.75657Z" fill="#FF5B1B"/>
                        </svg>
                    </span>
                    <?php echo esc_html( $feature ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="cs-button service__read-more">
        <span class="cs-button__text">
            <?php echo esc_html__( 'Learn Details', 'steelnova' ); ?>
        </span>
        <span class="cs-button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                <path d="M4.49501 0.209212C4.77396 -0.0697375 5.22611 -0.0697375 5.50506 0.209212L9.79083 4.49498C10.0697 4.77393 10.0697 5.2261 9.79083 5.50504L5.50506 9.79083C5.22612 10.0697 4.77395 10.0697 4.49501 9.79083C4.21607 9.51183 4.21608 9.05975 4.49501 8.78075L7.56143 5.71431H0.714291C0.319817 5.71431 2.91512e-05 5.39448 0 5.00002C2.30094e-08 4.60552 0.319799 4.28572 0.714291 4.28572H7.56143L4.49501 1.21927C4.21607 0.940333 4.21608 0.488164 4.49501 0.209212Z" fill="white"/>
            </svg>
        </span>
    </a>
</div>
