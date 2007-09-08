<?php

function stream_release ($release_slug, $stream_format) {
	global $wp_query, $release, $artist;
	global $tracks, $track, $current_track;
	
	if (empty ($release_slug)) {
			return new WP_Error ('no-release-to-stream', __("You didn't specify a release to stream."));
	}
	
	$release = get_release_by_slug ($release_slug, TRUE, FALSE);
	$artist['artist_name'] = get_artistname_by_id ($release['release_artist']);
	$tracks = $release['release_tracks'];
	$track = $tracks[$current_track];
	
	if (is_wp_error ($release)) {
			return $release;
	}
	
	if ($stream_format == 'xspf') {	
		$load = ribcage_load_template('./stream/xspf.php');
	}
	elseif ($stream_format == 'm3u') {	
		$load = ribcage_load_template('stream/m3u.php');
	}
	
	if (is_wp_error($load)){
		return $load;
	}
}

function stream_track ($track_slug) {
	if (empty ($track_slug)) {
			return new WP_Error ('no-release-to-stream', __("You didn't specify a track to stream."));
	}
	
	$track = get_track_by_slug ($track_slug);
	
	if (is_wp_error ($release)) {
			return $track;
	}
	
	print_r ($track);
}
?>