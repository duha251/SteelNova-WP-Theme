<?php
$post_id = get_the_ID();
$image_id = get_post_thumbnail_id($post_id);
$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
?>
<div class="cs-post-featured-image cs-image">
    <?php steelnova_print_image_by_size($image_id, $img_w, $img_h, []); ?>
</div>
