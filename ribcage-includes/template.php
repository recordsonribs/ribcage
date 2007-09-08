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

function is_artist_page()
{
	global $wp_query;
	
	if (isset($wp_query->query_vars['artist_page'])){
		return (TRUE);
	}
	
	else {
		return (FALSE);
	}
}
// release_title
// Input false if you want no echo.
// Returns the contents of $release['release_title']
function release_title ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_title'];
	
	return $release['release_title'];
}

function release_slug ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_slug'];
	
	return $release['release_slug'];
}

// artist_*
// -----------
// Various artist_ template tags.

// release_title
// Input false if you want no echo.
// Returns the contents of $artist['artist_name']
function artist_name ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_name'];
	
	return $artist['artist_name'];
}

function artist_bio( $echo = true )
{
	global $artist;
	
	if ($echo) {
		echo $artist['artist_bio'];
	}
	
	return $artist['artist_bio'];
}
function artist_slug ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_slug'];
	
	return $artist['artist_slug'];
}

function artist_blurb_tiny ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_blurb_tiny'];
	
	return $artist['artist_blurb_tiny'];
}

function artist_blurb_short ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_blurb_short'];
	
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
		echo $track['track_title'];
	
	return $track['track_title'];
}

function track_stream ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_stream'];
	
	return $track['track_stream'];
}

function track_number ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_number'];
	
	return $track['track_number'];
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