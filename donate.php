<?php

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

function ribcage_donate (){
	global $paypal;
	global $artist, $release;
	
	//Paypal Sandbox Fake Business
	$paypal->add_field('business', 'suppor_1200230957_biz@recordsonribs.com');

	$paypal->add_field('charset', 'utf-8');

	$paypal->add_field('return', get_option('siteurl').'/download/'.release_slug(FALSE));
	$paypal->add_field('cancel_return', get_option('siteurl').'/download/'.release_slug(FALSE));
	$paypal->add_field('notify_url', get_option('siteurl').'/donate/'.release_slug(FALSE).'/ipn');

	$paypal->add_field('item_name', release_title(FALSE).' Download Donation');
	$paypal->add_field('item_number', release_cat_no(FALSE));
	$paypal->add_field('custom', release_id(FALSE));
	$paypal->add_field('quantity', '1');

	$paypal->add_field('currency_code', 'GBP');

    $paypal->submit_paypal_post(); // submit the fields to paypal
	$paypal->dump_fields();	
}

function ribcage_donate_download_thanks  () {
	global $release, $artist, $wp_query;
	
	$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);
	$artist = get_artist ($release['release_artist']);
	$load = ribcage_load_template('download-thanks.php');
}

function ribcage_donate_ipn () {
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