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
    /**
     * Custom post type for Artists
     *
     * The artist has many releases, which are attached as children to this parent post type.
     * In order to do this, we simply have a customised metabox which allows one to attach artists to releases.
     *
     * @author Alex Andrews
     * @version 2.0
     */
    register_post_type (
        'ribcage_artists',
        array(
            'label' => 'Artists',
            'description' => 'Label Artists', // Replace with something clever to get the name of label
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20, // Replace with a submenu a Ribcage custom admin menu
            'capability_type' => 'post',
            'hiearchical' => true,
            'rewrite' => true, // Check this to set up correct re-writes
            'query_var' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor','thumbnail','yoast-seo','thumbnails'),
            'register_metabox_cb' => 'ribcage_artists_metaboxes',
            labels = array(
                'name' => 'Artists',
                'singular_name' => 'Artist',
                'menu_name' => 'Artists',
                'add_new' => 'Add New Artist',
                'add_new_item' => 'Add New Brand',
                'edit' => 'Edit',
                'edit_item' => 'Edit Artist',
                'new_item' => 'New Artist',
                'view' => 'View Artist',
                'search_items' => 'Search Artists',
                'not found' => 'No Artists',
                'not_found_in_trash' => 'No Artists in Trash - good sign?',
                'parent_item_colon' => false
            )
        )
    );
    
    /**
     * Custom post type for Releases
     *
     * The release is the child of the artist, in WordPress as well as actuality.
     * The release has many tracks, which are added when we add a release.
     * You can't have orphaned tracks, and their is no direct UI for tracks.
     *
     * @author Alex Andrews
     * @since 2.0
     * @version 1.0
     */
     register_post_type (
         'ribcage_releases',
         array()
     );
     
     /**
      * Custom post type for Tracks
      *
      * Tracks are, guess what, children of releases: Artist has many Releases has many Tracks
      * There is no direct interface with tracks, though they themselves have attachments in the form
      * of files, which attach the audio files to allow for listening and download.
      *
      * @author Alex Andrews
      * @since 2.0
      * @version 1.0
      */
      register_post_type (
          'ribcage_tracks',
          array()
      );
      
     /**
      * Custom post type for Files
      *
      * This is essentially a media type that used the media upload and attaches to tracks.
      * These can be bundles together to make a release download, or you can download them individually.
      * They are zipped up and sent out on the fly.
      *
      * @author Alex Andrews
      * @since 2.0
      * @version 1.0
      */
      register_post_type (
          'ribcage_files',
          array()
      );
      
      /**
       * Custom post type for Products
       *
       * Products are things to buy. They can be associated with either the Artist, or a release
       * and hence by proxy and artist, or they can free float as products independent of either.
       *
       * @author Alex Andrews
       * @since 2.0
       * @version 1.0
       */
       register_post_type (
           'ribcage_products',
           array()
       );
       
       /**
        * Custom post type for Events
        *
        * Previously Records On Ribs used a external plugin to create events, but it was clunky and suchlike.
        * This new version integrates events directly into the core of the plugin.
        * Events are associated with an artist (or artists) or the label as a whole.
        * They drop of page at the right time as you would expect - when the release date of a record is set,
        * these also appear automatically on the /events page. How very nice!
        * 
        * Fancy stuff like maps is handled by copying the best plugin of this kind - XXXX
        *
        * @author Alex Andrews
        * @since 2.0
        * @version 1.0
        */
        register_post_type (
            'ribcage_events',
            array()
        );
        
        /**
         * Custom post type for Reviews
         *
         * Reviews are good things people have said about your releases that are children of them - nice.
         * Through the back end you can order them as you like and so on.
         *
         * @author Alex Andrews
         * @since 2.0
         * @version 1.0
         */
         register_post_type (
             'ribcage_reviews',
             array()
         );
        
        /**
         * Post status for Releases
         *
         * Releases have unique statuses as befits their status as your records.
         *
         * These are:
         *      - Released
         *      - Unreleased
         *      - Scheduled Release - this is the norm for Release, obviously - set it up set a release date and boom!
         *
         * @author Alex Andrews
         * @since 2.0
         * @version 1.0
         */
}
add_action('init','ribcage_init');

/**
 * Clean up stuff
 *
 * This function re-writes lot of things as per user request. 
 * Liberally borrowed from the excellent Roots theme - http://www.rootstheme.com/
 * a theme which makes WordPress so much more sexy - what is does documented in code.
 *
 * @author Alex Andrews
 */
 
/**
 * Activates the Ribcage plugin. 
 * Adds Ribcage tables to the database and options to wp_options with defaults installed.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_activate(){
	global $wpdb, $table_prefix;
	
	$version = get_option("ribcage_db_version");
	if($version != 1){
	// Upgrade function changed in WordPress 2.3	
	if (version_compare($wp_version, '2.3-beta', '>='))		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	else
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		
		require_once dirname(__FILE__) . '/ribcage-includes/install.php';
		dbDelta($ribcage_schema);
		update_option('ribcage_db_version',1);
		update_option('ribcage_release_image_tiny','/tiny');
	}
	ribcage_flush_rules();
}
register_activation_hook(__FILE__, 'ribcage_activate');

/**
 * De-activates Ribcage and removes its databases and wp_options entries.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_deactivate(){
	global $wpdb;
	//delete_option("ribcage_db_version");
}
register_deactivation_hook(__FILE__, "ribcage_deactivate");

?>