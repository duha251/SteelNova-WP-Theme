<?php
if ( empty( $settings['items'] ) ) {
    printf( '<div style="color:red;">Items not found.</div>' );
    return;
}

$swiper_settings = steelnova_get_carousel_settings( $settings, [
    'breakpoints' => [
        'xs' => [
            'slidesPerView' => $settings['slides_per_view_xs'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_xs'] ?: 1,
            'spaceBetween' => $settings['space_between_xs']['column'] ?: 30
        ],
        'sm' => [
            'slidesPerView' => $settings['slides_per_view_sm'] ?: 1,
            'gridRows' => $settings['swiper_grid_rows_sm'] ?: 1,
            'spaceBetween' => $settings['space_between_sm']['column'] ?: 30
        ],
        'md' => [
            'slidesPerView' => $settings['slides_per_view_md'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_md'] ?: 1,
            'spaceBetween' => $settings['space_between_md']['column'] ?: 30
        ],
        'lg' => [
            'slidesPerView' => $settings['slides_per_view_lg'] ?: 2,
            'gridRows' => $settings['swiper_grid_rows_lg'] ?: 1,
            'spaceBetween' => $settings['space_between_lg']['column'] ?: 30
        ],
        'xl' => [
            'slidesPerView' => $settings['slides_per_view_xl'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows_xl'] ?: 1,
            'spaceBetween' => $settings['space_between_xl']['column'] ?: 30
        ],
        'xxl' => [
            'slidesPerView' => $settings['slides_per_view'] ?: 3,
            'gridRows' => $settings['swiper_grid_rows'] ?: 1,
            'spaceBetween' => $settings['space_between']['column'] ?: 38
        ],
    ]
]);

$title_tag = $settings['title_tag'] ?: 'h6';

$wrapper_attrs = array_merge( 
    [
        'class' => 'cs-price-carousel carousel',
        'data-layout' => $settings['layout'],
    ], 
    $wrapper_attrs
);

$this->add_render_attribute( 'wrapper', $wrapper_attrs );

$box_gradient_class = !empty( $settings['box_inner_background_color_b'] ) || 
                    !empty( $settings['box_inner_background_image'] ) ||  
                    !empty( $settings['box_inner_background_hover_color_b'] ) || 
                    !empty( $settings['box_inner_background_hover_image'] ) ? ' box-gradient' : '';

$item_active = $settings['item_active'] ?: 1;

?>
<div <?php pxl_print_html( $this->get_render_attribute_string('wrapper') ); ?>>
    <div class="carousel__container swiper" data-swiper="<?php echo esc_attr( json_encode( $swiper_settings ) ); ?>">
        <div class="carousel__inner swiper-wrapper">
            <?php foreach( $settings['items'] as $i => $item ) : 
                $active_class = $item_active === ( $i + 1 ) ? ' is-active' : '';  
                $item_key = 'item-'.$i;
                $item_attrs = [
                    'class' => 'carousel__item swiper-slide'
                ];
                if( !empty( $settings['items_animation'] ) && isset($settings['items_animation'][$i]['item_entrance_anim']) && !empty( $settings['items_animation'][$i]['item_entrance_anim'] ) ) {
                    $item_attrs['class'] .= ' wow elementor-repeater-item-'.$settings['items_animation'][$i]['_id'].' '.$settings['items_animation'][$i]['item_entrance_anim'];
                }
                $this->add_render_attribute( $item_key , $item_attrs);  
            ?>
                <div <?php pxl_print_html( $this->get_render_attribute_string($item_key) ); ?>>
                    <div class="price">
                        <div class="price__inner<?php echo esc_attr( $box_gradient_class . $active_class ); ?>">
                            <?php if( !empty( $item['icon']['value'] ) ) : ?>
                                <div class="price__icon price__icon--copy">
                                    <?php steelnova_elementor_print_icon( $item['icon'] ); ?>
                                </div>
                                <div class="price__icon d-inline-flex-center price__icon--main">
                                    <?php steelnova_elementor_print_icon( $item['icon'] ); ?>
                                </div>
                            <?php endif; ?>
                            <<?php echo esc_attr( $title_tag ); ?> class="price__title">
                                <?php echo esc_html( $item['title'] ); ?>
                            </<?php echo esc_attr( $title_tag ); ?>>
                            <?php if( !empty( $item['desc'] ) ) : ?>
                                <p class="price__description">
                                    <?php echo esc_html( $item['desc'] ); ?>
                                </p>
                            <?php endif; ?>
                            <div class="price__amount">
                                <?php if( !empty( $item['price_prefix'] ) ) : ?>
                                    <span class="price__amount-prefix">
                                        <?php echo esc_html( $item['price_prefix'] ); ?>
                                    </span> 
                                <?php endif; ?>
                                <?php echo esc_html( $item['price_amount'] ); ?>
                                <?php if( !empty( $item['price_suffix'] ) ) : ?>
                                    <span class="price__amount-suffix">
                                        <?php echo esc_html( $item['price_suffix'] ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="divider"></div>
                            <?php 
                                if( !empty( $item['features'] ) ) : 
                                    $features = explode('|', $item['features']);
                                    if( count( $features ) > 0 ) :
                                        echo '<ul class="price__features cs-list">';
                                        foreach( $features as $feature ) :
                                            echo '<li class="price__feature cs-list__item">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.2983 9.64884C19.2983 14.9792 14.9406 19.298 9.64913 19.298C4.31875 19.298 -1.66595e-05 14.9792 -1.66595e-05 9.64884C-1.66595e-05 4.35737 4.31875 -0.000304431 9.64913 -0.000304431C14.9406 -0.000304431 19.2983 4.35737 19.2983 9.64884ZM8.5208 14.7847L15.6798 7.62563C15.9133 7.39218 15.9133 6.9642 15.6798 6.73075L14.785 5.87478C14.5515 5.60242 14.1624 5.60242 13.929 5.87478L8.09281 11.711L5.33036 8.9874C5.09691 8.71505 4.70783 8.71505 4.47438 8.9874L3.5795 9.84338C3.34606 10.0768 3.34606 10.5048 3.5795 10.7383L7.62592 14.7847C7.85936 15.0181 8.28735 15.0181 8.5208 14.7847Z" fill="#FF5B1B"/>
                                                    </svg>'.
                                                    esc_html( $feature ).
                                            '</li>';
                                        endforeach;
                                        echo '</ul>';
                                    endif;
                                endif;
                            ?>
                            <?php if( !empty( $item['link']['url'] ) ) : ?>
                                <a href="<?php steelnova_elementor_print_link_attributes( $item['link'] ); ?>" class="cs-button cs-button--primary box-gradient">
                                    <span class="cs-button__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M5.39401 0.251055C5.72875 -0.083685 6.27133 -0.083685 6.60607 0.251055L11.749 5.39398C12.0837 5.72872 12.0837 6.27132 11.749 6.60605L6.60607 11.749C6.27134 12.0837 5.72874 12.0837 5.39401 11.749C5.05928 11.4142 5.0593 10.8717 5.39401 10.5369L9.07372 6.85717H0.857149C0.38378 6.85717 3.49814e-05 6.47338 0 6.00002C2.76113e-08 5.52662 0.383759 5.14286 0.857149 5.14286H9.07372L5.39401 1.46312C5.05928 1.1284 5.0593 0.585797 5.39401 0.251055Z" fill="white"/>
                                        </svg>
                                    </span>
                                    <span class="cs-button__text">
                                        <?php echo esc_html( $settings['btn_text'] ?: __( 'Get Started With Plan', 'steelnova' ) ); ?>
                                    </span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php steelnova_print_swiper_controls( $settings ); ?>
    </div>
</div>