<?php
/*
 * example php script that generates and outputs a hcard entry
 */

$myPersonalData = array(
	'name' 		=> 'Steve F. Better',
	'email' 	=> 'abuse-me@this-host-is-not-existing.info',
	'org' 		=> array(
		'name' 		=> 'The virtual company',
		'title' 	=> 'General chief of all'
	),

	'location'	=> array (
		'street'	=> 'Main street 15b',
		'town'		=> 'Mainhattan',
		'zip'		=> '22912',
		'state'		=> 'Main country',
		'country'	=> 'Countrinidad'	
	),	

	'phone'		=> array(
		'home'		=> '+1 123 66 71 292',
		'cell'		=> '+1 123 88 72 121'	
	),

	'photo'		=> 'http://enarion.net/img/phpsitemapng-170px.jpg',
		
	'im'		=> array(
		'skype'		=> 'echo-chinese',
		'aim'		=> 'ShoppingBuddy'
	)
);

require_once(dirname(__FILE__).'/../src/phpMicroformats.class.php');

echo phpMicroformats::createHCard($myPersonalData);

?>