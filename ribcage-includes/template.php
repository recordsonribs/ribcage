<?php

$artists = null;
$artist = null;
$current_artist = 0;

$releases = null;
$release = null;
$current_release = 0;

$tracks = null;
$track = null;
$current_track = 0;

$reviews = null;
$review = null;

function is_artist_page ()
{
	global $wp_query;
	
	if (isset($wp_query->query_vars['artist_page'])){
		return (TRUE);
	}
	
	else {
		return (FALSE);
	}
}

//

function release_title ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wptexturize($release['release_title']);
	
	return $release['release_title'];
}

function release_slug ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_slug'];
	
	return $release['release_slug'];
}

function release_blurb_tiny ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wptexturize($release['release_blurb_tiny']);
	
	return $release['release_blurb_tiny'];
}

function release_blurb_short ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wptexturize($release['release_blurb_short']);
	
	return $release['release_blurb_short'];
}

function release_blurb_long ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wpautop(wptexturize($release['release_blurb_long']));
	
	return $release['release_blurb_long'];
}
function release_download_link ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'];
	
	return get_option('siteurl').'/download/'.$release['release_slug'];
}

function release_download_link_mp3 ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'].'/mp3';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/mp3';
}

function release_download_link_flac ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'].'/flac';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/flac';
}

function release_download_link_ogg ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'].'/ogg';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/ogg';
}

function release_cover_large ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_cover_image_large'];
	
	return $release['release_cover_image_large'];
}

function release_cover_tiny ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_cover_image_tiny'];
	
	return $release['release_cover_image_tiny'];
}

function release_player_link ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/player/'.$release['release_slug'].'/';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/';
}

// artist_*
// -----------
// Various artist_ template tags.

function artist_name ( $echo = true ) {
	global $artist;
	
	if ($echo) 
		echo wptexturize($artist['artist_name']);

	return $artist['artist_name'];
}

function artist_bio ( $echo = true )
{
	global $artist;
	
	if ($echo) {
		echo wpautop(wptexturize($artist['artist_bio']));
	}
	
	return $artist['artist_bio'];
}

function artist_slug ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_slug'];
	
	return $artist['artist_slug'];
}

function artist_press_link ( $echo = true ) {
	global $artist;
	$presslink = get_option('siteurl').'/artists/'.$artist['artist_slug'].'/press/';
	
	if ($echo)
		echo $presslink;
	
	return $presslink;
}

function artist_website_link ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_link_website'];
	
	return $artist['artist_link_website'];
}

function artist_myspace_link ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_link_myspace'];
	
	return $artist['artist_link_myspace'];
}

function artist_facebook_link ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_link_facebook'];
	
	return $artist['artist_link_facebook'];
}

function artist_lastfm_link ( $echo = true ) {
	global $artist;
	
	$lastfmlink = 'http://www.last.fm/music/'.str_replace(' ', '+',$artist['artist_name']);
	if ($echo)
		echo $lastfmlink;
	
	return $lastfmlink;
}

function artist_blurb_tiny ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo wptexturize($artist['artist_blurb_tiny']);
	
	return $artist['artist_blurb_tiny'];
}

function artist_blurb_short ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo wptexturize($artist['artist_blurb_short']);
	
	return $artist['artist_blurb_short'];
}

function artist_picture_1 ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_picture_1'];
	
	return $artist['artist_picture_1'];
}

function have_artists () {
	global $artists, $current_artist;
	
	$have_artists = ( !empty($artists[$current_artist]) );

	if ( !$have_artists ) {
		$GLOBALS['artists']	= null;
		$GLOBALS['current_artist'] = 0;
	}
	return $have_artists;
}

function the_artist (){
	global $artists, $artist, $current_artist;

	$GLOBALS['artist'] = $artists [$current_artist];
	$GLOBALS['current_artist']++;
}

//------------------------------------------------------


function track_title ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo wptexturize($track['track_title']);
	
	return $track['track_title'];
}

function track_stream ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_stream'];
	
	return $track['track_stream'];
}

function track_no ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_number'];
	
	return $track['track_number'];
}

function track_id ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_id'];
	
	return $track['track_id'];
}

function track_time ( $echo = true ) {
	global $track;
	
 	$split = explode (':', $track['track_time']);
	$str = str_split ($split[1]);
	
	if ($echo) {
		if ($str[0] == 0) {
			echo $str[1].'.'.$split[2];
		}
		else {
			echo $split[1].'.'.$split[2];
		}
	}
	
	return $split[1].'.'.$split[2];
}

function have_tracks () {
	global $tracks, $current_track;
	
	$have_tracks = ( !empty($tracks[$current_track]) );

	if ( !$have_tracks ) {
		$GLOBALS['tracks']	= null;
		$GLOBALS['current_track'] = 0;
	}
	return $have_tracks;
}

function the_track (){
	global $tracks, $track, $current_track;

	$GLOBALS['track'] = $tracks [$current_track];
	$GLOBALS['current_track']++;
}

function have_releases () {
	global $releases, $current_release;
	
	$have_releases = ( !empty($releases[$current_release]) );

	if ( !$have_releases ) {
		$GLOBALS['releases']	= null;
		$GLOBALS['current_release'] = 0;
	}
	return $have_releases;
}

function the_release (){
	global $releases, $release, $current_release, $tracks;

	$GLOBALS['release'] = $releases [$current_release];
	$GLOBALS['tracks'] = $release ['release_tracks'];
	$GLOBALS['current_release']++;
}

?>