<?php
/**
 * Functions that are concerned with buying products.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @package Ribcage
 * @subpackage Buy
 **/

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

/**
 * Sends the user out to PayPal to purchase a product.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @return void
 */
function ribcage_buy_process ()
{
	global $paypal;
	global $wp_query;
	global $product;
	
	if ($wp_query->query_vars['ribcage_buy_mode'] == 'go-ww') {
		$amount = $product['product_cost'] + get_option('ribcage_postage_worldwide');	
		$postage = 'Worldwide';
	}
			
	else {
		$amount = $product['product_cost'];
		$postage = 'UK';
	}

	$paypal->add_field('business', get_option('ribcage_paypal_email'));
	
	$paypal->add_field('charset', 'utf-8');
	
	$paypal->add_field('return', get_option('siteurl').'/buy/'.$product['product_id'].'/thanks');
	$paypal->add_field('cancel_return', get_option('siteurl'));
	$paypal->add_field('notify_url', get_option('siteurl').'/buy/'.$product['product_id'].'/ipn');
	$paypal->add_field('item_name', $product['product_name'].' (Including '.$postage.' postage)');
	$paypal->add_field('item_number', get_option('ribcage_mark').str_pad($product['product_id'], 3, "0", STR_PAD_LEFT));
	$paypal->add_field('custom', $product['product_id']);
	$paypal->add_field('undefined_quantity', '1');
	$paypal->add_field('rm', '2');
	
	$paypal->add_field('currency_code', 'GBP');
	
	$paypal->add_field('amount', $amount );
	
	// Submit the fields to PayPal
    $paypal->submit_paypal_post(); 
}

/**
 * Validates and processes the IPN returned from PayPal.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @return void
 */
function ribcage_buy_ipn () {
	global $paypal;
	global $wpdb;

	if ($paypal->validate_ipn()) {        
		// Add order to the database.
		
		// Send e-mail to the administrator informing them of the new order.	
		$subject = 'Instant Payment Notification - Order Recieved';
		$to = get_option('ribcage_paypal_email');
		//$body = ribcage_load_email_template ('to-administrator.php');
		$body = "Testing, testing.";
		wp_mail ($to, $subject, $body);
	
		// Send e-mail to the customer thanking them for their order.
		//$body = ribcage_load_email_template ('to-buyer.php');
		
	}	

}
?>