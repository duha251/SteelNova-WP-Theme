<form action="/" method="get" class="cs-search-form__form">
	<input type="text" name="s" class="cs-search-form__field" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"/>
	<button type="submit" class="cs-search-form__submit">
        <?php if( !empty( $btn_text ) ) : ?>
            <span class="cs-button__text">
                <?php pxl_print_html( $btn_text ); ?>
            </span>
        <?php endif; ?>
        <?php if( !empty( $btn_icon ) ) : ?>
            <span class="cs-button__icon">
                <?php pxl_print_html( $btn_icon ); ?>
            </span>
        <?php endif; ?>
    </button>
    <?php if( !empty( $post_type ) ) : ?>
        <input type="hidden" value="<?php echo esc_attr( $post_type ); ?>" name="post_type" id="post_type" />
    <?php endif; ?>
</form>