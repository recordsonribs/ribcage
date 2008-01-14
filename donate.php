<?php

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

function ribcage_donate (){
	global $paypal;
	global $artist, $release;
	
	//Paypal Sandbox Fake Business
	$paypal->add_field('business', 'alex@highsoc.com');

	$paypal->add_field('charset', 'utf-8');

	$paypal->add_field('return', get_option('siteurl').'/download/'.release_slug(FALSE).'/back/');
	$paypal->add_field('cancel_return', get_option('siteurl').'/download/'.release_slug(FALSE));
	$paypal->add_field('notify_url', get_option('siteurl').'/donate/ipn');

	$paypal->add_field('item_name', release_title(FALSE).' Download Donation');
	$paypal->add_field('item_number', release_cat_no(FALSE));
	$paypal->add_field('custom', release_id(FALSE));
	$paypal->add_field('quantity', '1');

	$paypal->add_field('currency_code', 'GBP');

    $paypal->submit_paypal_post(); // submit the fields to paypal
}

function ribcage_donate_download_thanks  () {
	global $release, $artist, $wp_query;
	
	$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);
	$artist = get_artist ($release['release_artist']);
	$load = ribcage_load_template('download-thanks.php');
}

function ribcage_donate_ipn () {
	global $paypal;
	global $wpdb;

	//if ($paypal->validate_ipn()) {   
  		$log = sprintf("
			INSERT INTO  `%s` (
			`donate_id` ,
			`donate_ipn` ,
			)
			VALUES (
			NULL ,  '%s'
			);
			",
			$wpdb->ribcage_donations,
			serialize($paypal->ipn_data)
			);
			
			$wpdb->query("$log");
	//}
}
?>