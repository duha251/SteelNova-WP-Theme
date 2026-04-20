<section id="hero" class="hero" data-layout="default">
    <div class="container">
        <div class="inner">
            <h1 class="hero__title">
                <?php echo esc_html( $title ); ?>
            </h1>
            <?php if( !empty( $note ) ) : ?>
                <p> <?php echo esc_html( $note ) ?> </p>
            <?php endif; ?>
        </div>
    </div>
</section>