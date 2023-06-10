<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<div class="cart-row uk-grid-collapse woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>" data-uk-grid>
        				<div class="cart-btn uk-width-auto">
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

						</div>
        				<div class="cart-btn uk-position-relative tw-padding-left uk-width-3-4">

							<?php if ( ! $_product->is_visible() ) : ?>
								<?php echo esc_attr($product_name); ?>
							<?php else : ?>
								<a class="cart-widget-title" href="<?php echo esc_url( $product_permalink ); ?>"><?php echo esc_attr($product_name); ?></a>
							<?php endif; ?>

							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity cart-meta">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
						</div>
					</div>
					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
		?>

		<?php else : ?>

			<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'lvly' ); ?></p>

		<?php endif; ?>

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<div class="cart-row subtotal-row uk-grid-collapse" data-uk-grid>
			<a href="<?php echo wc_get_checkout_url(); ?>" class="cart-btn uk-width-expand">
				<span class="cart-widget-title"><?php esc_html_e( 'Subtotal', 'lvly' ); ?>:</span>
			</a>
			<a href="<?php echo wc_get_checkout_url(); ?>" class="cart-widget-title cart-btn uk-text-right uk-width-auto">
				<?php echo WC()->cart->get_cart_subtotal(); ?>
			</a>
		</div>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
	
		
    <div class="cart-row cart-checkout-row uk-grid-collapse" data-uk-grid>
        <div class="cart-btn uk-width-expand">
			<a href="<?php echo wc_get_cart_url(); ?>" class="cart-widget-title"><i class="simple-icon-bag"></i> <?php esc_html_e( 'View Cart', 'lvly' ); ?></a>
		</div>
        <div class="cart-btn uk-text-right uk-width-auto">
			<a href="<?php echo wc_get_checkout_url(); ?>" class="cart-widget-subtotal"><i class="ion-ios-checkmark-outline"></i> <?php esc_html_e( 'Checkout', 'lvly' ); ?></a>
		</div>
    </div>
	
	<?php endif; ?>
	
<?php do_action( 'woocommerce_after_mini_cart' ); ?>