<?php
/**
 * Provides a stream of a track or a release in various formats.
 *
 * @package Ribcage
 * @subpackage Streaming
 **/

/**
 * Stream a whole release as xspf or m3u.
 *
 * @return void
 * @param string $release_slug The slug of the release to stream
 * @param string $stream_format The format of the streaming, either xspf or m3u
 **/
function stream_release ($release_slug, $stream_format) {
	global $wp_query, $release, $artist;
	global $tracks, $track, $current_track;
	
	if (empty ($release_slug)) {
            return new WP_Error ('no-release-to-stream', __("You didn't specify a release to stream."));
            ribcage_404();
	}
	
	$release = get_release_by_slug ($release_slug, TRUE, FALSE);

        if (is_wp_error($release)){
            ribcage_404();
        }

	$artist['artist_name'] = get_artistname_by_id ($release['release_artist']);

        if (is_wp_error($artist)){
            ribcage_404();
        }

	$tracks = $release['release_tracks'];
	$track = $tracks[$current_track];
	
	if (is_wp_error ($release)) {
			ribcage_404();
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

/**
 * Stream a single track
 *
 * @param string $track_slug The slug of the track we are streaming
 * @return void
 **/
function stream_track ($track_slug) {
	if (empty ($track_slug)) {
			return new WP_Error ('no-release-to-stream', __("You didn't specify a track to stream."));
	}
	
	$track = get_track_by_slug ($track_slug);
	
	if (is_wp_error ($release)) {
			ribcage_404();
	}
	
	print_r ($track);
}
?>