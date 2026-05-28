<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */
?>

<div class="woocommerce-shipping-totals shipping">
	<div class="label">
		<?php echo wp_kses_post( $package_name ); ?>
	</div>

	<div class="value" data-title="<?php echo esc_attr( $package_name ); ?>">

		<?php if ( ! empty( $available_methods ) && is_array( $available_methods ) ) : 
			$calculator_text = '';	
		?>

			<ul id="shipping_method" class="woocommerce-shipping-methods">
				<?php foreach ( $available_methods as $method ) : ?>
					<li>
						<?php
						$method_id    = esc_attr( sanitize_title( $method->id ) );
						$input_id     = "shipping_method_{$index}_{$method_id}";
						$method_value = esc_attr( $method->id );
						$label = $method->label;
						$cost  = $method->cost > 0 ? wc_price( $method->cost ) : '';

						if ( 1 < count( $available_methods ) ) :
							?>
							<label for="<?php echo esc_attr( $input_id ); ?>" class="radio-field"
							<?php if( !empty($cost) ) : ?> data-tooltip="<?php echo esc_attr( wp_strip_all_tags( $cost ) ); ?>" <?php endif; ?>>
								
								<input
									type="radio"
									name="shipping_method[<?php echo esc_attr( $index ); ?>]"
									data-index="<?php echo esc_attr( $index ); ?>"
									id="<?php echo esc_attr( $input_id ); ?>"
									value="<?php echo esc_attr($method_value); ?>"
									class="shipping_method"
									<?php checked( $method->id, $chosen_method ); ?>
								/>

								<span class="radio-field__checked"></span>

								<span class="radio-field__label">
									<?php echo esc_html( $label ); ?>
								</span>

							</label>
							<?php
						else :
							?>
							<label class="radio-field radio-field--hidden">
								
								<input
									type="hidden"
									name="shipping_method[<?php echo esc_attr( $index ); ?>]"
									data-index="<?php echo esc_attr( $index ); ?>"
									id="<?php echo esc_attr( $input_id ); ?>"
									value="<?php echo esc_attr($method_value); ?>"
									class="shipping_method"
								/>

								<span class="radio-field__checked"></span>

								<span class="radio-field__label">
									<?php echo esc_html( $label ); ?>
								</span>

								<?php if ( $cost ) : ?>
									<span 
										class="radio-field__cost"
										data-tooltip="<?php echo esc_attr( wp_strip_all_tags( $cost ) ); ?>"
									>
										<?php echo wp_kses_post( $cost ); ?>
									</span>
								<?php endif; ?>

							</label>
							<?php
						endif;

						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						printf(
							esc_html__( 'Shipping to %s.', 'steelnova' ) . ' ',
							'<strong>' . esc_html( $formatted_destination ) . '</strong>'
						);
						$calculator_text = esc_html__( 'Change address', 'steelnova' );
					} else {
						echo wp_kses_post(
							apply_filters(
								'woocommerce_shipping_estimate_html',
								__( 'Shipping options will be updated during checkout.', 'steelnova' )
							)
						);
					}
					?>
				</p>
			<?php endif; ?>

		<?php elseif ( ! $has_calculated_shipping || ! $formatted_destination ) : ?>

			<?php
			if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				echo wp_kses_post(
					apply_filters(
						'woocommerce_shipping_not_enabled_on_cart_html',
						__( 'Shipping costs are calculated during checkout.', 'steelnova' )
					)
				);
			} else {
				echo wp_kses_post(
					apply_filters(
						'woocommerce_shipping_may_be_available_html',
						__( 'Enter your address to view shipping options.', 'steelnova' )
					)
				);
			}
			?>

		<?php elseif ( ! is_cart() ) : ?>

			<?php
			echo wp_kses_post(
				apply_filters(
					'woocommerce_no_shipping_available_html',
					__( 'There are no shipping options available.', 'steelnova' )
				)
			);
			?>

		<?php else : ?>

			<?php
			echo wp_kses_post(
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					sprintf(
						esc_html__( 'No shipping options were found for %s.', 'steelnova' ) . ' ',
						'<strong>' . esc_html( $formatted_destination ) . '</strong>'
					),
					$formatted_destination
				)
			);
			$calculator_text = esc_html__( 'Enter a different address', 'steelnova' );
			?>

		<?php endif; ?>

		<?php if ( $show_package_details ) : ?>
			<p class="woocommerce-shipping-contents">
				<small><?php echo esc_html( $package_details ); ?></small>
			</p>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>

	</div>
</div>