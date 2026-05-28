<?php

$thumbnail_id = get_post_thumbnail_id($post->ID);    
$features = get_post_meta( $post->ID, 'service_features', true ) ?: [];

$service_icon = get_post_meta( $post->ID, 'service_icon', true ) ?: '';

extract( $display_args ); 

?>
<div class="service">
    <div class="service__thumbnail">
        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
            <?php steelnova_print_image_by_size( $thumbnail_id, $img_width, $img_height ); ?>
        </a>
        <div class="service__heading">
            <?php if( !empty( $service_icon ) ) : ?>
            <div class="service__icon">
                <?php steelnova_print_svg_content( $service_icon['url'] ?? '' ); ?>
            </div>
            <?php endif; ?>
            <div class="divider"></div>
            <<?php echo esc_attr( $display_args['title_tag'] ); ?> class="service__title">
                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                    <?php echo esc_html( get_the_title( $post->ID ) ); ?>
                </a>
            </<?php echo esc_attr( $display_args['title_tag'] ); ?>>
        </div>
    </div>
    <div class="service__content">
        <?php if ( ! empty( $features ) ): ?>
            <ul class="service__features">
                <?php foreach ( $features as $feature ): ?>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="11" viewBox="0 0 14 11" fill="none">
                            <path d="M13.3616 0.00681412C13.2978 0.0159287 13.2386 0.0341579 13.1839 0.0615016C13.1292 0.0888454 13.0836 0.125304 13.0472 0.170877C12.3271 0.890929 11.6207 1.61098 10.928 2.33103C10.2353 3.04197 9.54718 3.75519 8.86358 4.47068C8.17999 5.18618 7.49184 5.90395 6.79913 6.624C6.11553 7.33494 5.41827 8.04588 4.70733 8.75681L0.920222 5.72166C0.85642 5.67608 0.79034 5.64418 0.72198 5.62595C0.653621 5.60773 0.578425 5.60317 0.496394 5.61228C0.423478 5.6214 0.355118 5.64418 0.291316 5.68064C0.227514 5.7171 0.172827 5.76267 0.127254 5.81736C0.0269932 5.93585 -0.0140224 6.07257 0.00420673 6.22752C0.0224359 6.38246 0.0907953 6.50551 0.209285 6.59666L4.40655 9.95994C4.52504 10.0511 4.65492 10.0921 4.7962 10.083C4.93747 10.0739 5.05824 10.0192 5.1585 9.91892C5.9059 9.16241 6.63962 8.41046 7.35968 7.66306C8.07061 6.92478 8.78383 6.18194 9.49932 5.43455C10.2148 4.68715 10.928 3.93976 11.639 3.19236C12.359 2.45408 13.0882 1.71124 13.8265 0.963845C13.9176 0.881814 13.9746 0.779275 13.9974 0.656228C14.0202 0.533181 14.0042 0.41697 13.9495 0.307595C13.8948 0.19822 13.8128 0.116189 13.7034 0.0615016C13.5941 0.00681412 13.4801 -0.011415 13.3616 0.00681412Z" fill="#0A1119"/>
                        </svg>
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
</div>
