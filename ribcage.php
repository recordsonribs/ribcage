<?php
/*
	Plugin Name: Ribcage
	Plugin URI: http://recordsonribs.com/ribcage/
	Description: Manages and monitors artists, releases and downloads for a record label. Originally designed for Records On Ribs.
	Version: 1.0.1
	Author: Records On Ribs
	Author URI: http://recordsonribs.com
*/
/*
	Copyright 2010  Alexander Andrews  (email: alex@recordsonribs.com)

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

include ('ribcage-includes/functions.php');
include ('ribcage-includes/log.php');
include ('ribcage-includes/template.php');

require_once dirname(__FILE__) . '/admin.php';
require_once dirname(__FILE__) . '/download.php';
require_once dirname(__FILE__) . '/stream.php';
require_once dirname(__FILE__) . '/player.php';

require_once dirname(__FILE__) . '/donate.php';
require_once dirname(__FILE__) . '/buy.php';

require_once dirname(__FILE__) . '/widget.php';

add_action('template_redirect','ribcage_init');

$paypal = new paypal_class;

// Uncomment the below line to use Paypal Sandbox not real server.
//$paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

/**
 * Runs the whole of Ribcage.
 * A filter on the template that tries to find out if we are on a Ribcage page and responds accordingly.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_init (){
	global $wp_query;
	global $artists, $artist, $current_artist;
	global $releases, $release, $current_release;
	global $tracks, $track, $current_track;
	global $reviews, $review, $current_review;
	
	global $product;
	
	wp_enqueue_script('ribcage-player-popup', plugins_url('js/player.js', __FILE__), null, '3.0');
	
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
				$release = get_release_by_slug ($wp_query->query_vars['release_slug'], FALSE, FALSE);

                                if (is_wp_error($release)){
                                    ribcage_404();
                                }

				$artist = get_artist ($release['release_artist']);

                if (is_wp_error($artist)){
                    ribcage_404();
                }

                

				$load = ribcage_load_template('post-download.php');
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
 * Adds Ribcage specific re-write rules to Wordpress rules.
 * Filter on generate_rewrite_rules, which is called every time Wordpress works out its rewrite rules.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_add_rewrite_rules ( $wp_rewrite ) {
	$new_rules = array(
		"(artists)/(.*?)/(.*?)/?$" => 'index.php?artist_slug='.$wp_rewrite->preg_index(2).'&artist_page='.$wp_rewrite->preg_index(3),
		"(artists)/(.*?)/?$" => 'index.php?artist_slug=' . $wp_rewrite->preg_index(2),
		"(artists)/?$" => 'index.php?artist_index=1',
		
		"(releases)/(feed)/?$" => 'index.php?release_feed=1',
		"(releases)/?$" => 'index.php?release_index=1',
			
		"(download)/(track)/(.*?)/(.*?)/?$" => 'index.php?ribcage_download=1&track_slug='.$wp_rewrite->preg_index(3).'&format='.$wp_rewrite->preg_index(4),
		"(download)/(.*?)/(.*?)/?$" => 'index.php?ribcage_download=1&release_slug='.$wp_rewrite->preg_index(2).'&format='.$wp_rewrite->preg_index(3),
		"(download)/(.*?)/?$" => 'index.php?ribcage_download=1&release_slug='.$wp_rewrite->preg_index(2),
		"(download)/?$" => 'index.php?ribcage_download=1',
		
		"(stream)/(track)/(.*?)/(.*?)/(.*?)/?$" => 'index.php?ribcage_stream=1&track_slug='.$wp_rewrite->preg_index(3).'&stream_format='.$wp_rewrite->preg_index(4),
		"(stream)/(.*?)/(.*?)/?$" => 'index.php?ribcage_stream=1&release_slug='.$wp_rewrite->preg_index(2).'&stream_format='.$wp_rewrite->preg_index(3),
		"(stream)/?$" => 'index.php?ribcage_stream=1',
		
		"(player)/(.*?)/?$" => 'index.php?ribcage_player=1&release_slug='.$wp_rewrite->preg_index(2),
		
		"(buy)/(.*?)/(.*?)/?$" => 'index.php?ribcage_buy=1&ribcage_product_id='.$wp_rewrite->preg_index(2).'&ribcage_buy_mode='.$wp_rewrite->preg_index(3),
		"(buy)/(.*?)/?$" => 'index.php?ribcage_buy=1&ribcage_product_id='.$wp_rewrite->preg_index(2),
		"(buy)/?$" => 'index.php?ribcage_buy=1',
		
		"(donate)/(ipn)/?$" => 'index.php?ribcage_donate_ipn=1'	
	);

	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action('generate_rewrite_rules', 'ribcage_add_rewrite_rules');

/**
 * Adds the various Ribcage query variables to wp_query.
 * Filter on query_vars.
 *
 * @return void
 */
function ribcage_queryvars ($qvars){ 	
	// Artist Listings
	$qvars[] = 'artist_index';
	$qvars[] = 'artist_slug';
	$qvars[] = 'artist_id';
	$qvars[] = 'artist_page';
	
	// Release Listings
	$qvars[] = 'release_index';
	$qvars[] = 'release_feed';
	
	// Downloads
	$qvars[] = 'ribcage_download';

	// Streams
	$qvars[] = 'ribcage_stream';
	$qvars[] = 'stream_format';
	
	// Releases and Tracks
	$qvars[] = 'release_slug';
	$qvars[] = 'track_slug';
	
	$qvars[] = 'format';
	$qvars[] = 'ribcage_player';
	
	$qvars[] = 'ribcage_buy';
	$qvars[] = 'ribcage_product_id';
	$qvars[] = 'ribcage_buy_mode';
	
	$qvars[] = 'ribcage_donate_ipn';
	
	return $qvars;
}
add_filter('query_vars', 'ribcage_queryvars' );

/**
 * Flushes Ribcage rewrite rules
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 **/
function ribcage_flush_rules (){
	global $wp_rewrite;
	
	$wp_rewrite->flush_rules();
}

/**
 * Filter on wp_title to add the Ribcage pages to page title.
 *
 * Some stuff from this function is lifted from the wp_title function itself. Cheers to the developers there.
 * 
 * @param string $title The title as it currently stands - what we are adding to.
 * @param string $seplocation Optional. Direction to display title, 'right'.
 * @return string The title with added Ribcage
 * @author Alex Andrews <alex@recordsonribs.com>
 **/
function ribcage_page_title ($title, $sep = '&raquo;', $seplocation = '') {
	global $wp_query;
	global $release, $artist, $product;

        // We've got a 404 situation here.
        if (is_wp_error($artist) or is_wp_error($release) or is_wp_error($product)){
            return;
        }
	
	if (isset($wp_query->query_vars['release_index'])) {
		$title_array [] = "Releases";
	}
	
	if (isset($wp_query->query_vars['artist_index'])) {
		$title_array [] = "Artists";
	}
	
	if (isset($wp_query->query_vars['artist_slug'])) {
		$title_array [] = "Artists";
		$title_array [] = $artist['artist_name'];
	}
	
	if (isset($wp_query->query_vars['ribcage_buy']) && isset($wp_query->query_vars['ribcage_product_id'])) {
		$title_array [] = "Buy";
		$title_array[] = $product['product_name'];
	}
	
	if (is_artist_page()){	
		switch ($wp_query->query_vars['artist_page']) {
			case 'press':
				$title_array [] = 'Press';
				break;

			case 'bio':
				$title_array [] = 'Biography';
				break;

			default :	
				$title_array [] = $release['release_title'];
		}
	}
	
	if (isset($wp_query->query_vars['ribcage_download'])){
		$title_array [] = "Downloading ".$artist['artist_name']." - ".$release['release_title'];
	}
	
	// If we have the title on the right, then switch the whole thing around.
	if ($seplocation == 'right') {
		$title_array = array_reverse($title_array);
		$title_array [] = $title;
	}
	else {
		if (count($title_array) > 1) {
			array_unshift ($title_array,$title);
		}	
	}
	
	if (count($title_array) > 1) {
		$title = implode (" $sep ",$title_array);
	}

	return ($title);
}

/**
 * Activates the Ribcage plugin. 
 * Adds Ribcage tables to the database and options to wp_options with defaults installed.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 * @todo When uninstall and deactive routines are added convert into a class as per http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
 */
function ribcage_activate(){
	require_once dirname(__FILE__) . '/ribcage-includes/install.php';

	if (!get_option('ribcage_database_version') || get_option('ribcage_database_version') != '1.1'){
		ribcage_create_tables();
		update_option("ribcage_database_version", "1.1");
	}

	// Flush rewrite rules
	ribcage_flush_rules();
}
register_activation_hook(WP_PLUGIN_DIR . '/ribcage/ribcage.php', 'ribcage_activate');

/**
 * De-activates Ribcage.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_deactivate(){
}
register_deactivation_hook(WP_PLUGIN_DIR . '/ribcage/ribcage.php', "ribcage_deactivate");

/**
 * Removes Ribcage from installation.
 * 
 * @author Alex Andrews
 * @return void
 *
 */
function ribcage_uninstall(){
	delete_option('ribcage_database_version');
}
register_uninstall_hook(WP_PLUGIN_DIR . '/ribcage/ribcage.php', "ribcage_uninstall");
