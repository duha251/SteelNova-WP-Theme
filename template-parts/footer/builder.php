<?php
if($layout_id <= 0) {
    return;
}
?>

<footer id="footer" class="footer" data-layout="builder">
    <?php echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $layout_id ); ?>
</footer>