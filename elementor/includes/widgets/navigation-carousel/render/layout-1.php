<?php 

?>
<div id="<?php echo esc_attr($settings['html_id']); ?>" class="cs-navigation-carousel">    
    <div class="cs-button cs-navigation-carousel__button cs-navigation-carousel__button--prev">
        <?php if(!empty( $settings['nav_prev_icon']['value'] )) : ?>
            <?php \Elementor\Icons_Manager::render_icon( $settings['nav_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="15" viewBox="0 0 9 15" fill="none">
                <path d="M8.08105 0.530273L1.08105 7.53027L8.08105 14.0303" stroke="currentcolor" stroke-width="1.5"/>
            </svg>
        <?php endif; ?>
    </div>
    <div class="cs-button cs-navigation-carousel__button cs-navigation-carousel__button--next">
        <?php if(!empty( $settings['nav_next_icon']['value'] )) : ?>
            <?php \Elementor\Icons_Manager::render_icon( $settings['nav_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="15" viewBox="0 0 9 15" fill="none">
                <path d="M0.530273 0.530273L7.53027 7.53027L0.530273 14.0303" stroke="currentcolor" stroke-width="1.5"/>
            </svg>
        <?php endif; ?>
    </div>
</div>