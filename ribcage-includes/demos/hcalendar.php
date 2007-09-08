<?php
/*
 * example php script that generates and outputs a hcalendar entry
 */

$myEvent = array(
	'name' 		=> 'Release party of phpMicroformats',
	'begin'		=> time(),
	'end'		=> time()+2*60*60, // duration: 2 hours

	'location'	=> array (
		'street'	=> 'Main street 15b',
		'town'		=> 'Mainhattan',
		'zip'		=> '22912',
		'state'		=> 'Main country',
		'country'	=> 'Countrinidad'	
	),

	'url'		=> 'http://enarion.net/phpmicroformats/'
);

require_once(dirname(__FILE__).'/../src/phpMicroformats.class.php');

echo phpMicroformats::createHCalendar($myEvent);

?>