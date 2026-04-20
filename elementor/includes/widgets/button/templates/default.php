<?php

?>
<?php if( !empty( $settings['text'] ) ) : ?>
    <span class="button-text">
        <?php echo esc_html( $settings['text'] ); ?>
    </span>
<?php endif; ?>

<?php if( !empty( $settings['icon']['value'] ) ) : ?>
    <span class="button-icon">
        <?php steelnova_elementor_print_icon( $settings['icon'] ); ?>
    </span>
<?php endif; ?>