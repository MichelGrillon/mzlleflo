<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;

echo '<p>Fichier review-order.php surchargé chargé</p>'; // Message de débogage

do_action('woocommerce_review_order_before_payment');
?>

<div id="payment" class="woocommerce-checkout-payment">
	<?php if (WC()->cart->needs_payment()) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			if (!empty($available_gateways)) {
				foreach ($available_gateways as $gateway) {
					wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce') . '</li>';
			}
			?>
		</ul>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>');
			?>
			<br /><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>"><?php esc_html_e('Update totals', 'woocommerce'); ?></button>
		</noscript>

		<?php wc_get_template('checkout/terms.php'); ?>

		<?php do_action('woocommerce_review_order_before_submit'); ?>

		<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine 
		?>

		<?php do_action('woocommerce_review_order_after_submit'); ?>

		<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
	</div>
</div>

<?php
do_action('woocommerce_review_order_after_payment');

// Ajout des informations de paiement
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
	$product = $cart_item['data'];
	if ($product->is_type('variation')) {
		$type_of_transaction = $product->get_attribute('pa_type_de_transaction');
		echo '<p>Type de transaction : ' . $type_of_transaction . '</p>'; // Message de débogage

		if ($type_of_transaction == 'Vente') {
			echo '<p>Paiement par carte bancaire.</p>';
		} elseif ($type_of_transaction == 'Location (mensuel)') {
			echo '<p>Paiement par prélèvement automatique. Une caution de 30% du prix de vente sera prélevée.</p>';
		}
	}
}
?>