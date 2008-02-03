<?php

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

function ribcage_buy_process ()
{
	global $paypal;
	global $wp_query;
	global $product;
	
	if ($wp_query->query_vars['ribcage_buy_mode'] == 'go-ww') {
		$amount = $product['product_cost'] + 1;	
		$postage = 'Worldwide';
	}
			
	else {
		$amount = $product['product_cost'];
		$postage = 'UK';
	}

	$paypal->add_field('business', 'alex@recordsonribs.com');
	
	$paypal->add_field('charset', 'utf-8');
	
	$paypal->add_field('return', get_option('siteurl').'/buy/'.$product['product_id'].'/thanks');
	$paypal->add_field('cancel_return', get_option('siteurl'));
	$paypal->add_field('notify_url', get_option('siteurl').'/buy/'.$product['product_id'].'/ipn');
	$paypal->add_field('item_name', $product['product_name'].' (Including '.$postage.' postage)');
	$paypal->add_field('item_number', 'ROR'.str_pad($product['product_id'], 3, "0", STR_PAD_LEFT));
	$paypal->add_field('custom', $product['product_id']);
	$paypal->add_field('undefined_quantity', '1');
	$paypal->add_field('rm', '2');
	
	$paypal->add_field('currency_code', 'GBP');
	
		

	$paypal->add_field('amount', $amount );

    $paypal->submit_paypal_post(); // submit the fields to paypal
}

function ribcage_buy_ipn () {
	global $paypal;
	global $wpdb;

	if ($paypal->validate_ipn()) {        
		
		// Add order to the database.
		
		// Send e-mail to the administrator informing them of the new order.
		
		// Send e-mail to the customer thanking them for their order.
		
		$subject = 'Instant Payment Notification - Recieved Payment';
		$to = 'alex@recordsonribs.com';    //  your email
		$body =  "An instant payment notification was successfully recieved\n";
		$body .= "from ".$paypal->ipn_data['payer_email']." on ".date('m/d/Y');
		$body .= " at ".date('g:i A')."\n\nDetails:\n";
		foreach ($paypal->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
			wp_mail ($to, $subject, $body);
		}

}
?>