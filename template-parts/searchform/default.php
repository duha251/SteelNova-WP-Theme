<form action="/" method="get" class="steelnova-search-form__form">
	<input type="text" name="s" class="steelnova-search-form__field" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"/>
	<button type="submit" class="steelnova-search-form__submit">
        <?php if( !empty( $btn_text ) ) : ?>
            <span class="button__text">
                <?php pxl_print_html( $btn_text ); ?>
            </span>
        <?php endif; ?>
        <?php if( !empty( $btn_icon ) ) : ?>
            <span class="button__icon">
                <?php pxl_print_html( $btn_icon ); ?>
            </span>
        <?php endif; ?>
    </button>
    <input type="hidden" value="post" name="post_type" id="post_type" />
</form>