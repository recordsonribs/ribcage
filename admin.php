<?php
/**
 * Includes the administration functions and adds admin panes.
 *
 * @author Alexander Andrews
 * @package Ribcage
 * @subpackage Adminstation
 **/

/**
 * Adds Ribcage admin panes
 *
 * @return void
 */
function ribcage_admin_menu() { 	
	add_menu_page('Ribcage', 'Ribcage', 8, dirname(__FILE__).'/admin.php', 'ribcage_admin_index');
	add_submenu_page(dirname(__FILE__).'/admin.php', 'Ribcage', 'Add Artist', 8,'add_artist', 'ribcage_add_artist');
	add_submenu_page(dirname(__FILE__).'/admin.php', 'Ribcage', 'Add Release', 8, 'add_release', 'ribcage_add_release');	
	add_submenu_page(dirname(__FILE__).'/admin.php', 'Ribcage', 'Add Review', 8, 'add_review', 'ribcage_add_review');	
	add_submenu_page(dirname(__FILE__).'/admin.php', 'Ribcage', 'Add Press', 8, 'add_press', 'ribcage_add_press');
	add_submenu_page(dirname(__FILE__).'/admin.php', 'Ribcage', 'Manage Artists', 8, 'manage_artists', 'ribcage_manage_artists');
	
	add_options_page('Ribcage', 'Ribcage', 8, 'ribcage_options', 'ribcage_options');
	
	settings_fields('ribcage');
	
	register_setting('ribcage','ribcage_paypal_email');
	register_setting('ribcage','ribcage_image_location');
	register_setting('ribcage','ribcage_file_location');
	register_setting('ribcage','ribcage_mark');
}
add_action('admin_menu', 'ribcage_admin_menu');

require_once dirname(__FILE__) . '/admin/functions.php';
require_once dirname(__FILE__) . '/admin/manage.php';
?>