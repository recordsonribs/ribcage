<?php
/**
 * Functions for downloading files
 *
 * @package Ribcage
 * @subpackage Downloads
 **/

/**
 * Outputs the file selected from database to user for download.
 *
 * @author Alex Andrews
 * @param string $release_slug The slug of the release to download.
 * @param string $format The format of the release to download, flac|mp3|ogg
 * @return void
 */
function download_release ($release_slug, $format) {
	global $release;
	
	if (empty ($release_slug)) {
		return new WP_Error ('ribcage-no-release-to-download', __("You didn't specify a release to grab."));
	}
		
	$release = get_release_by_slug ($release_slug, FALSE, FALSE);
		
	// If we don't know the release, then error nicely, not with a snarky SQL error.
	// Remember this page is user viewed. Display a 404.
	if (is_wp_error ($release)) {
		return $release;
	}
		
	if ($format == 'mp3') {
		$file = $release['release_mp3'];
	} 
	elseif ($format == 'ogg') {
		$file = $release['release_ogg'];
	} 
	else if ($format == 'flac') {
		$file = $release['release_flac'];
	}
	else {
		return new WP_Error ('ribcage-incorrect-format', __("$format isn't a format I am aware of.<br />Hence it isn't a format you can download, sorry."));
	}
	
	ribcage_log();			
	ribcage_download($file);
}

/**
 * Outputs an individual track for the user to download.
 *
 * @author Alex Andrews
 * @param string $track_slug The slug of the track that is to be downloaded.
 * @param string $format The format of the release to download, flac|mp3|ogg
 * @return void
 */
function download_track ($track_slug, $format) {
	global $track;
	
	if (empty ($track_slug)) {
		return new WP_Error ('ribcage-no-track-to-download', __("You didn't specify a track to grab."));
	}
	
	$track = get_track_by_slug($track_slug);
	
	if (is_wp_error ($release)) {
		return $release;
	}
	
	if ($format == 'mp3') {
			$file = $track['track_mp3'];
	} 
	elseif ($format == 'ogg') {
			$file = $track['track_ogg'];
	} 
	elseif ($format == 'flac') {
		$file = $track['track_flac'];
	}
	else {
		return new WP_Error('ribcage-incorrect-format', __("$format isn't a format I am aware of.<br />Hence it isn't a format you can download."));
	}
	
	ribcage_log (TRUE);	
	ribcage_download($file);
}

/**
 * Outputs a file of a given path to the user, setting the headers correctly so it pops up nicely.
 *
 * Borrowed a good deal of code from Lester 'GaMerZ' Chan's WP-DownloadManager (http://lesterchan.net/portfolio/programming.php)
 *
 * @author Alex Andrews
 * @param string $file File path of the file to download
 */
function ribcage_download ($file) {
	// The full path is the site root plus whatever is in the database.
	$path = ABSPATH.$file;
	
	if(!is_file($path)) {
		header('HTTP/1.0 404 Not Found');
		die(__('File does not exist.', 'ribcage'));
	}
	/*			
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=".basename($file).";");
	header("Content-Transfer-Encoding: binary");					
	header("Content-Length: ".filesize($path));*/
	@readfile($path);
	
	return(0);
}

?>