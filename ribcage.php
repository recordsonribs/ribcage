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
 * A filter on the template that tries to find out if we are on a Ribcage page and responds accordingly.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @version 2.0
 * @return void
 */
function ribcage_init (){
	global $wp_query;
	global $artists, $artist, $current_artist;
	global $releases, $release, $current_release;
	global $tracks, $track, $current_track;
	global $reviews, $review, $current_review;
	
	global $product;
	
	wp_enqueue_script('ribcage-player-popup', get_option('siteurl').'/wp-content/plugins/ribcage/js/player.js');
	
	// Add our streams.
	add_filter('wp_head', 'ribcage_release_feeds');
	
	if (is_ribcage_page () == 0){
		return;
	}
	
	$GLOBALS['ribcage_page'] = TRUE;
	
	// Add our bits to the page title in the header ans elsewhere.
	add_filter('wp_title', 'ribcage_page_title',10,3);
	
	// Donate IPN from Paypal	
	if (isset($wp_query->query_vars['ribcage_donate_ipn'])) {
		ribcage_donate_ipn();
	}
	
	// Artist Index
	if (isset($wp_query->query_vars['artist_index'])) {
		$artists = list_artists_blurb();
		$artist = $artists [$current_artist];
		
		$wp_query->query_vars['pagename'] = 'artists';

		$load = ribcage_load_template ('artist-index.php');
	}
	
	// Individual Artist (including bio, contact et al)
	if (isset($wp_query->query_vars['artist_slug'])) {
		$artist = get_artist_by_slug ($wp_query->query_vars['artist_slug']);

                if (is_wp_error($artist)){
                    ribcage_404();
                }
                
                $wp_query->query_vars['pagename'] = $wp_query->query_vars['artist_slug'];
                
		if (is_artist_page()){
			switch ($wp_query->query_vars['artist_page']) {
				case 'press':
					$releases = list_artist_releases ($artist['artist_id'], TRUE);
					$load = ribcage_load_template('press.php');
					break;
					
				case 'bio':
					$load  = ribcage_load_template('bio.php');
					break;
					
				case 'feed':		
					$releases = list_artist_releases ($artist['artist_id']);
					$load = ribcage_load_template ('feeds/artist-rss2.php');
					break;
					
				default :
					$release = get_release_by_slug ($wp_query->query_vars['artist_page']);

                                        if (is_wp_error($release)){
                                            ribcage_404();
                                        }

					$tracks = $release ['release_tracks'];
					$reviews = $release['release_reviews'];
					$load = ribcage_load_template ('release.php');				
			}
		}
		else {
			$releases = list_artist_releases ($artist['artist_id']);
			$load = ribcage_load_template ('artist.php');
		}
	}
		
	// Releases Index
	if (isset($wp_query->query_vars['release_index']) or isset($wp_query->query_vars['release_feed'])) {
		$releases = list_recent_releases_blurb();
		$artists = list_artists_blurb();
		
		$wp_query->query_vars['pagename'] = 'releases';
		
		if (isset($wp_query->query_vars['release_feed'])){
			$load = ribcage_load_template ('feeds/release-rss2.php');
		}
		else {
			$load = ribcage_load_template ('release-index.php');
		}
			
	}
	
	// Downloads
	if (isset($wp_query->query_vars['ribcage_download'])) {
		
		// Download whole release.
		if (isset($wp_query->query_vars['release_slug']) && isset($wp_query->query_vars['format'])) {
			
			// Re-direct them to donate at Paypal
			if ($wp_query->query_vars['format'] == 'donate') {
				$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);

                                if (is_wp_error($release)){
                                    ribcage_404();
                                }

				$artist = get_artist ($release['release_artist']);

                                if (is_wp_error($artist)){
                                    ribcage_404();
                                }
                                
				ribcage_donate();
			}
			
			// They just donated at Paypal, probably.
			else if ($wp_query->query_vars['format'] == 'back') {
				ribcage_donate_download_thanks();				
			}
			
			else if ($wp_query->query_vars['format'] == 'skip') {
				$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);

                                if (is_wp_error($release)){
                                    ribcage_404();
                                }

				$artist = get_artist ($release['release_artist']);

                                if (is_wp_error($artist)){
                                    ribcage_404();
                                }

				$load = ribcage_load_template('download.php');
			}
			
			else {
				$load = download_release ($wp_query->query_vars['release_slug'], $wp_query->query_vars['format']);
			}
		}
		
		// Download individual track.
		else if (isset($wp_query->query_vars['track_slug'])) {
			$load = download_track ($wp_query->query_vars['track_slug'], $wp_query->query_vars['format']);
		}
		
		// Download nag/links page.
		else if (isset($wp_query->query_vars['release_slug'])) {
			$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);

                        if (is_wp_error($release)){
                            ribcage_404();
                        }

			$artist = get_artist ($release['release_artist']);

                        if (is_wp_error($artist)){
                            ribcage_404();
                        }
			
			// If we haven't seen the user before, then nag them about the download.
			if (!isset($_COOKIE["ask_donate"])){
				setcookie("ask_donate", "1", time()+3600);
				$load = ribcage_load_template('nag.php');
			}
			
			// If we have seen the user before, then there is a one in five chance they will see the nag.
			else if (isset($_COOKIE["ask_donate"])) {
				$random = rand(1, 8);
				if ($random == 5) {
					$load = ribcage_load_template('nag.php');
				}
				else {
					$load = ribcage_load_template('download.php');
				}	
		}
		
			// If the user has just got back from Paypal congratulate them on their brillance and given them
			// the download. Maybe lower the chance of a nag?
			
		}
		
		
	}
			
	// Streams
	if (isset($wp_query->query_vars['ribcage_stream'])) {
		// Stream whole release.
		if (isset($wp_query->query_vars['release_slug'])) {
			$load = stream_release ($wp_query->query_vars['release_slug'],$wp_query->query_vars['stream_format']);
		}
		// Stream individual track.
		if (isset($wp_query->query_vars['track_slug'])) {
			$load = stream_track ($wp_query->query_vars['track_slug']);
		}
	}
	
	if (isset($wp_query->query_vars['ribcage_player']))	{
		if ($wp_query->query_vars['release_slug'] == 'stats'){
			ribcage_log_play();
		}
		else {
			$load = show_player($wp_query->query_vars['release_slug']);
		}
		
	}
	
	// Purchases
	if (isset($wp_query->query_vars['ribcage_buy']) && isset($wp_query->query_vars['ribcage_product_id'])) {
		
		// Lookup the item they are looking for in the database.
		$product = get_product($wp_query->query_vars['ribcage_product_id']);

                if (is_wp_error($product)){
                    ribcage_404();
                }
		
		// Some products are associated with releases, some are not.
		if (isset($product['product_related_release'])) {
			$release = get_release($product['product_related_release']);
			$artist = get_artist($release['release_artist']);
		}
	
		// Set this so the feeds at the bottom of the page show up for the artist.
		$wp_query->query_vars['artist_slug'] = true;
		
		if (isset($wp_query->query_vars['ribcage_buy_mode'])){		
			switch ($wp_query->query_vars['ribcage_buy_mode']) {			
				// Send them to Paypal
				case 'go-ww' :
				case 'go-uk' :
					ribcage_buy_process();			
					break;
						
				// They just got back from Paypal and it was a success. Thank them for it.
				case 'thanks': 
					$load = ribcage_load_template('thanks.php');
					break;
			
				// We are recieving an IPN ping from Paypal.
				case 'ipn' :
					ribcage_buy_ipn();
					break;
			
				// They cancelled.
				case 'cancel' :
					echo "Cancelled";
					break;
			}
		}
		
		// Just show the person the item they are looking for.
		else {
			$load = ribcage_load_template('buy.php');
		}
	}
	
	// Did we get an error by the end of all this? If so let the user know.
	if (is_wp_error($load)) {
		echo $load->get_error_message();
	}
	
	// Don't output anything else.
	die ();
}

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