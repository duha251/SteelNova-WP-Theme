<?php
if($layout_id <= 0) {
    return;
}
?>
<section id="hero" class="hero" data-layout="builder">
    <?php steelnova_elementor_print_builder_content( $layout_id ); ?>
</section>

