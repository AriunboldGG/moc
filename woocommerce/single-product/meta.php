<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><span class="meta-head"><?php esc_html_e( 'SKU:', 'lvly' ); ?></span><span class="sku"><?php echo ( $sku = $product->get_sku() ) ? esc_attr($sku) : esc_html__( 'N/A', 'lvly' ); ?></span></span>

	<?php endif; ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '<span class="meta-head">Category:</span>', '<span class="meta-head">Categories:</span>', count( $product->get_category_ids() ), 'lvly' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '<span class="meta-head">Tag:</span>', '<span class="meta-head">Tags:</span>', count( $product->get_tag_ids() ), 'lvly' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
