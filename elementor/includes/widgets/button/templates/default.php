<?php

?>
<?php if( !empty( $settings['text'] ) ) : ?>
    <span class="cs-button__text">
        <?php echo esc_html( $settings['text'] ); ?>
    </span>
<?php endif; ?>

<?php if( !empty( $settings['icon']['value'] ) ) : ?>
    <span class="cs-button__icon">
        <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
    </span>
<?php endif; ?>