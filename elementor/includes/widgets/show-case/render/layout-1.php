<div class="cs-show-case">
    <div class="cs-show-case__image">
        <?php steelnova_print_image_by_size( $settings['image']['id'], null, null, [] ); ?>
        <?php if( !empty( $settings['btns'] ) ) : ?>
            <div class="cs-show-case__buttons">
                <?php foreach( $settings['btns'] as $button ) : ?>
                    <a class="cs-button cs-button--primary elementor-repeater-item-<?php echo esc_attr( $button['_id'] ); ?>" <?php steelnova_elementor_print_link_attributes($button['link']); ?>>
                        <?php 
                        steelnova_get_template(
                            'elementor/includes/widgets/button/templates/primary', 
                            [
                                'settings' => $button
                            ]
                        ); 
                        ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if( !empty( $settings['title'] ) ) : ?>
        <h6 class="cs-show-case__title">
            <?php echo esc_html( $settings['title'] ); ?>
        </h6>
    <?php endif; ?>
</div>