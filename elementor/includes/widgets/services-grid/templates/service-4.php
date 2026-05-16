<?php
$thumbnail_url = get_the_post_thumbnail_url($post->ID);    
$features = get_post_meta( $post->ID, 'service_features', true ) ?: [];

$service_icon = get_post_meta( $post->ID, 'service_icon', true ) ?: '';
extract( $display_args ); 

?>
<div class="service" style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>);">
    <div class="group">
        <svg class="mask mask--one" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
            <path d="M10 0H0C6.37451 1.32942 8.61208 3.49353 10 10V0Z" fill="black"/>
        </svg>
        <svg class="mask mask--two" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
            <path d="M10 0H0C6.37451 1.32942 8.61208 3.49353 10 10V0Z" fill="black"/>
        </svg>
        <div class="service__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M0.0799834 1.0751C0.0851791 0.476102 0.574856 -0.005154 1.17385 4.16767e-05L10.3769 0.0798685C10.9758 0.0850952 11.4571 0.57476 11.4519 1.17374L11.3721 10.3767C11.3669 10.9756 10.8772 11.4569 10.2782 11.4517C9.67918 11.4465 9.19794 10.9568 9.20311 10.3579L9.26022 3.77321L1.84488 11.061C1.41767 11.4809 0.73094 11.4749 0.311054 11.0477C-0.108826 10.6205 -0.102869 9.93377 0.324359 9.51389L7.7397 2.22608L1.15504 2.16897C0.556062 2.16377 0.0748192 1.67407 0.0799834 1.0751Z" fill="white"/>
            </svg>
        </div>
    </div>
    <<?php echo esc_attr( $title_tag ); ?> class="service__title">
        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
            <?php echo esc_html( get_the_title( $post->ID ) ); ?>
        </a>
    </<?php echo esc_attr( $title_tag ); ?>>
    <div class="divider"></div>
    <?php if( $show_excerpt == true ) : ?>
        <p class="service__excerpt">
            <?php echo wp_trim_words( $post->post_excerpt, $num_of_words, $more = null); ?>
        </p>
    <?php endif; ?>
</div>
