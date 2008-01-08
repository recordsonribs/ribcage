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
		
	// Log the download.
	ribcage_log();
		
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
	
	// Log the download.
	ribcage_log (TRUE);
	
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
		
	ribcage_download($file);
}

// ribcage_download
// Input the download file path.
// Outputs the files for download using various methods.
function ribcage_download ($file) {
	echo 'Downloading:'.$file;
	return;
}

?>