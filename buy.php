<?php

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

function ribcage_buy_process ()
{
	global $paypal;
	global $product;
	
	//Paypal Sandbox Fake Business
	$paypal->add_field('business', 'suppor_1200230957_biz@recordsonribs.com');
	
	$paypal->add_field('charset', 'utf-8');
	
	$paypal->add_field('return', get_option('siteurl').'/buy/'.$product['product_id'].'/thanks');
	$paypal->add_field('cancel_return', get_option('siteurl').'/buy/'.$product['product_id'].'/cancel');
	$paypal->add_field('notify_url', get_option('siteurl').'/buy/'.$product['product_id'].'/ipn');

	$paypal->add_field('item_name', $product['product_name']);
	$paypal->add_field('item_number', 'ROR'.str_pad($product['product_id'], 3, "0", STR_PAD_LEFT));
	$paypal->add_field('custom', $product['product_id']);
	$paypal->add_field('undefined_quantity', '1');
	
	$paypal->add_field('currency_code', 'GBP');
	$paypal->add_field('amount', $product['product_cost']);

    $paypal->submit_paypal_post(); // submit the fields to paypal
}

function ribcage_buy_ipn () {
	global $paypal;

	if ($paypal->validate_ipn()) {        
		// Payment has been recieved and IPN is verified.  This is where you
		// update your database to activate or process the order, or setup
		// the database with the user's order details, email an administrator,
		// etc.  You can access a slew of information via the ipn_data() array.
  
		// Check the paypal documentation for specifics on what information
		// is available in the IPN POST variables.  Basically, all the POST vars
		// which paypal sends, which we send back for validation, are now stored
		// in the ipn_data() array.
  
		// For this example, we'll just email ourselves ALL the data.
		$subject = 'Instant Payment Notification - Recieved Payment';
		$to = 'alex@recordsonribs.com';    //  your email
		$body =  "An instant payment notification was successfully recieved\n";
		$body .= "from ".$paypal->ipn_data['payer_email']." on ".date('m/d/Y');
		$body .= " at ".date('g:i A')."\n\nDetails:\n";
		foreach ($paypal->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
			mail ($to, $subject, $body);
		}

}
?>