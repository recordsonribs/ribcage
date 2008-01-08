<?php

// download_release
// Input the slug of the release, the desired format (flac/ogg/mp3)
// Outputs the release as a file for download.
function download_release ($release_slug, $format) {
	global $release;
	
	if (empty ($release_slug)) {
		return new WP_Error ('no-release-to-download', __("You didn't specify a release to grab."));
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
		return new WP_Error ('incorrect-format', __("$format isn't a format I am aware of.<br />Hence it isn't a format you can download, sorry."));
	}
	
	ribcage_log();			
	ribcage_download($file);
}

// download_track
// Input the slug of the track, the desired format
// Outputs the release as a file for download.
function download_track ($track_slug, $format) {
	global $track;
	
	if (empty ($track_slug)) {
		return new WP_Error ('no-track-to-download', __("You didn't specify a track to grab."));
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
		return new WP_Error('incorrect-format', __("$format isn't a format I am aware of.<br />Hence it isn't a format you can download."));
	}
	
	ribcage_log (TRUE);	
	ribcage_download($file);
}

// ribcage_download
// Input the download file path (which is usually from the database).
// Outputs the files for download.
// Borrowed a good deal of code from Lester 'GaMerZ' Chan's WP-DownloadManager (http://lesterchan.net/portfolio/programming.php)
// Mostly in the headers to output.
function ribcage_download ($file) {
	global $wpdb, $user_ID;
	echo 'Downloading:'.$file;
	
	// The full path is the site root plus whatever is in the database.
	$path = ABSPATH.$file;
	
	// If we don't have a file size on database then work it out.

			
	if(!is_file($file_path.$file_name)) {
		header('HTTP/1.0 404 Not Found');
		die(__('File does not exist.', 'wp-downloadmanager'));
	}
				
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=".basename($file_name).";");
	header("Content-Transfer-Encoding: binary");					
	header("Content-Length: ".filesize($file_path.$file_name));
	@readfile($file_path.$file_name);

	return(0);
}

?>