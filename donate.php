<?php
/**
 * Functions concerned with handling donations.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @package Ribcage
 * @subpackage Donations
 **/

require_once dirname(__FILE__) . '/ribcage-includes/paypal/paypal.class.php';

/**
 * Sends the donating user out to PayPal to make their donation.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @return void
 */
function ribcage_donate (){
	global $paypal;
	global $artist, $release;
	
	$paypal->add_field('business', get_option('ribcage_paypal_email'));

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

/**
 * Displays thank you message to the user returning from PayPal
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @return void
 */
function ribcage_donate_download_thanks  () {
	global $release, $artist, $wp_query;
	
	$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);

        if (is_wp_error($release)){
            ribcage_404();
        }

	$artist = get_artist ($release['release_artist']);

        if (is_wp_error($artist)){
                                    ribcage_404();
                                }

	$load = ribcage_load_template('download-thanks.php');
}

/**
 * Validates IPN from Paypal, records the donation in the database and e-mails the user thank and the admin
 * to let them know.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @return void
 */
function ribcage_donate_ipn () {
	global $paypal;
	global $wpdb;
	
	if ($paypal->validate_ipn()) {
		// Add the person's donation to the database.
  		$log = sprintf("
			INSERT INTO  `%s` (
			`donate_id` ,
			`donate_ipn`
			)
			VALUES (
			NULL ,  '%s'
			);
			",
			$wpdb->ribcage_donations,
			serialize($paypal->ipn_data)
			);

			$wpdb->query("$log");
		
		// Send an e-mail to the administrator of the site, telling them they have recieved a donation.
		
		// Send an e-mail thanking the person for their donation.
	}
}
?>