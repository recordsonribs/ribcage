<?php
/**
 * General functions for administration.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @package Ribcage
 * @subpackage Administration
 **/

/**
 * Displays form for changing Ribcage options.
 *
 * @return void
 **/
function ribcage_options()
{
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Ribcage</h2>
		<form method="post" action="options.php">
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="ribcage_paypal_email">Paypal E-mail Address</label></th>
		<td><input type="text" name="ribcage_paypal_email" value="<?php echo get_option('ribcage_paypal_email'); ?>" class="regular-text code"/><span class="description">E-mail to send money to from donations and purchases via Paypal</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="ribcage_image_location">Image Location</label></th>
		<td><input type="text" name="ribcage_image_location" value="<?php echo get_option('ribcage_image_location'); ?>" class="regular-text code"/><span class="description">The directory to begin the directory tree of images for artists and release covers</class></td>
		</tr>
		<tr valign="top">
		<th scope="row">File Location</th>
		<td><input type="text" name="ribcage_file_location" value="<?php echo get_option('ribcage_file_location'); ?>" class="regular-text code"/><span class="description">The directory to begin the directory tree of files for audio and one sheets</class></td>
		</tr>
		<tr valign="top">
		<th scope="row">Record Label Mark</th>
		<td><input type="text" name="ribcage_mark" value="<?php echo get_option('ribcage_mark'); ?>" class="regular-text code"/><span class="description">The record label mark, Records On Ribs uses ROR, for example</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Default Postage Within Your Country</th>
		<td><input type="text" name="ribcage_postage_country" value="<?php echo get_option('ribcage_postage_country'); ?>" class="regular-text"/><span class="description">The default postage for a purchased item within the country you are in</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Default Postage Worldwide</th>
		<td><input type="text" name="ribcage_postage_worldwide" value="<?php echo get_option('ribcage_postage_worldwide'); ?>" class="regular-text"/><span class="description">The default postage for a purchased item worldwide</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Press Contact</th>
		<td><input type="text" name="ribcage_press_contact" value="<?php echo get_option('ribcage_press_contact'); ?>" class="regular-text code"/><span class="description">E-mail address people should contact for press enquires</span></td>
		</tr>
		</table>
		<?php settings_fields('ribcage'); ?>
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		</div>
	</div>
	<?php
}

/**
 * Adds the remote downloads from Legaltorrents.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @param bool $echo If true the remote downloads are displayed.
 * @return void
 */
function remote_downloads( $echo = TRUE )
{
	global $release;
	
	$total_downloads = 0;

	$torrents = array (
		'mp3'=>$release['release_torrent_mp3'],
		'ogg'=>$release['release_torrent_ogg'],
		'flac'=>$release['release_torrent_flac']
	);

	foreach ($torrents as $format => $val) {
		
		if ($val == NULL) {
			$torrents[$format] = 0;
			continue;
		}
		else {
			$downloads = get_remote_downloads($val);
				
			if (is_wp_error($downloads)) {
				echo $downloads->get_error_message();
				continue;
			}
			
			$torrents[$format] = $downloads;
			
			$total_downloads = $total_downloads + $downloads;
		}
	}
		
	if ( $echo ) {
		?>
		MP3: <?php echo number_format($torrents['mp3']); ?><br />
		Ogg: <?php echo number_format($torrents['ogg']); ?><br />
		Flac: <?php echo number_format($torrents['flac']); ?><br />
		Total: <?php echo number_format($total_downloads);?>
		<?php
	}

	return 	$total_downloads;
}

/**
 * Gets the total downloads for a specific torrent on LegalTorrents.
 *
 * @author Alex Andrews (alex@recordsonribs.com)
 * @param string $torrent The full URL of the torrent file we are getting.
 * @return int Total number of download of the torrent.
 */
function get_remote_downloads ($torrent) 
{
	$torrent = str_replace(array('http://','https://'), '', $torrent);
	$torrent = str_replace(array('www.legaltorrents.com/get/','beta.legaltorrents.com/get/','beta.legaltorrents.com/torrents/','.torrent'), '', $torrent);

	$request_url = "http://www.legaltorrents.com/torrents/$torrent.xml";
	$xml = simplexml_load_file($request_url);
	
	if (! $xml) {
		return new WP_Error('ribcage-legaltorrents-xml-not-found', __("The xml file could not be found on Legaltorrents."));
	}
	
	return $xml->{'totaldl'};
}
?>