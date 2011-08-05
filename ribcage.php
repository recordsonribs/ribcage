<?php
/*
	Plugin Name: Ribcage
	Plugin URI: http://recordsonribs.com/ribcage/
	Description: Manages and monitors artists, releases and downloads for a record label. Originally designed for Records On Ribs.
	Version: 2.0
	Author: Records On Ribs
	Author URI: http://recordsonribs.com
*/
/*
	Copyright 2011  Alexander Andrews  (email: alex@recordsonribs.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA	
*/

// Setup our custom post types. Keep it dry.
foreach (array('artists','releases','events','reviews','tracks') as $pt) {
	require_once(TEMPLATEPATH . "/post-types/ribcage_$pt.php");
}

/**
 * Runs the whole of Ribcage.
 * 
 * In essence Ribcage is a series of custom post types with tasty taxonomies thrown in for spice.
 * This function sets these up, does some other well documented things and then redirect the user appropriately.
 * 
 * @author Alex Andrews <alex@recordsonribs.com>
 * @version 2.0
 * @since 1.0
 * @return void
 */
function ribcage_init (){
    
}
add_action('init','ribcage_init');
 
/**
 * Activates the Ribcage plugin. 
 * Adds Ribcage tables to the database and options to wp_options with defaults installed.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_activate(){
    
}
register_activation_hook(__FILE__, 'ribcage_activate');

/**
 * De-activates Ribcage and removes its databases and wp_options entries.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_deactivate(){
    
}
register_deactivation_hook(__FILE__, "ribcage_deactivate");

?>